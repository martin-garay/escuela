<?php 

class CrearUsuario{
	protected $db;

	function __construct(){
		$this->db = toba_instancia::instancia()->get_db();
	}
	function existeUsuario($usuario){
		$usuario = addslashes($usuario);
		$datos = $this->db->consultar("SELECT count(1) FROM apex_usuario WHERE usuario = '$usuario'");
		return ($datos[0]['count']>0);
	}
	function crear($usuario, $nombre ,$pass, $atributos, $perfiles=null){
		//if( !$this->existeUsuario($usuario) && $this->passwordValido($usuario,$pass) ){
		if( !$this->existeUsuario($usuario) ){
			toba::instancia()->agregar_usuario($usuario, $nombre, $pass, $atributos);
			if(isset($perfiles) && is_array($perfiles))
				$this->asignarPerfiles($usuario, $perfiles);
		}
		//else{
		//	throw new toba_error("El usuario ya existe");
		//}
	}
	function passwordValido($usuario,$password){
		if(strtoupper($usuario)==strtoupper($password))
			throw new toba_error("La contraseña no puede ser el nombre de usuario ");
		return true;		
	}
	function asignarPerfiles($usuario, $perfiles){
		foreach ($perfiles as $key => $perfil) {
			toba::instancia()->vincular_usuario(toba::proyecto()->get_id(), $usuario, $perfil);
		}		
	}
}

?>
<?php 
include_once 'comunes.php';

class alertas extends comunes
{
	function get_alertas($where=null, $order_by=null){
		return $this->get_generico('v_alertas',$where,$order_by);
	}
	function get_tipo_alertas($where=null, $order_by=null){
		return $this->get_generico('tipo_alerta',$where,$order_by);
	}
	function get_nivel_alerta($where=null, $order_by=null){
		return $this->get_generico('nivel_alerta',$where,$order_by);
	}

	function nivel_tiene_opciones($id_nivel){
		$nivel = $this->get_nivel_alerta("id=$id_nivel");
		return $nivel[0]['opciones'];
	}
	function get_opciones_nivel($id_nivel){		
		if($this->nivel_tiene_opciones($id_nivel)){
			$nivel = $this->get_nivel_alerta("id=$id_nivel");
			return toba::db()->consultar($nivel[0]['sql_opciones']);
		}else{
			return array();
		}
	}
	function get_alertas_niveles($where=null, $order_by=null){
		return $this->get_generico('v_alertas_niveles',$where,$order_by);
	}
	function get_alertas_persona($id_persona){
		$alertas_persona = array();
		$alertas = $this->get_alertas("activo");
		foreach ($alertas as $key => $alerta) {

			//recorro los niveles donde se muestra la alerta
			$niveles_alerta = $this->get_alertas_niveles("id=".$alerta['id']);			
			foreach ($niveles_alerta as $key => $nivel_alerta) {
				$nivel = $this->get_nivel_alerta("id=".$nivel_alerta['id_nivel_alerta']); 					//datos de la parametrizacion
				if($nivel[0]['opciones']){
					$opciones_nivel = $nivel_alerta['opciones_nivel']; 										//opcion que selecciono el usuario
					$sql_personas = str_replace('$opciones',$opciones_nivel,$nivel[0]['sql_personas']);		//query que trae las personas del nivel
				}else{
					$sql_personas = $nivel[0]['sql_personas'];												//query que trae las personas del nivel
				}				
				$sql = "SELECT $id_persona IN ($sql_personas) as mostrar_alerta";							//si la persona esta entre las personas del nivel
				$resultado = toba::db()->consultar($sql);
				if( $resultado[0]['mostrar_alerta'] ){
					$alertas_persona[] = $alerta;
					break;
				}
			}
		}
		return $alertas_persona;
	}
}
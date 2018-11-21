<?php
class ci_asistencia extends escuela_ci
{
	protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
//	function ini(){
//		if( toba::memoria()->existe_dato('id_editable_zona') ){
//			$id_zona = toba::memoria()->get_dato('id_editable_zona');
//			toba::zona()->cargar($id_zona); 
//		}
//	}
	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_cursos();
		if(toba::zona()->cargada()){
			$curso = array('id'=>toba::zona()->get_editable_id());
		}
	}

//	function ini__operacion() {
//		//si el id de la zona esta cargada en memoria uso este por que el de la zona se pierde en los ajax
//		if(toba::memoria()->existe_dato('id_editable_zona')){
//			$editable = toba::memoria()->get_dato('id_editable_zona');
//		}else{
//			$editable = toba::zona()->get_editable();	
//			toba::memoria()->set_dato('id_editable_zona',$editable);
//		}
//	}


	function evt__cancelar()
	{
		$this->dep('datos_asistencia')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__procesar()
	{
		$this->dep('datos_asistencia')->guardar();
		$this->dep('datos_asistencia')->resetear();
		$this->set_pantalla('pant_inicial');
	}


	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__filtro))
			$filtro->set_datos($this->s__filtro);
	}
	function evt__filtro__filtrar($datos)
	{
		$this->s__filtro = $datos;
	}
	function evt__filtro__cancelar()
	{
		unset($this->s__filtro);
	}


	//-----------------------------------------------------------------------------------
	//---- cuadro_cursadas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cursadas(escuela_ei_cuadro $cuadro)
	{		
		if(isset($this->s__filtro)){
			//si es un profesor traigo solamente las cursadas de este, sino muestro todas las cursadas
			$where = (isset($this->s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
			$sql = toba::perfil_de_datos()->filtrar($sql);
			if(toba::consulta_php('comunes')->tiene_perfil('profesor')){						
				$datos = toba::zona()->get_cursadas_profesor($where);
			}else{			
				$datos = toba::zona()->get_cursadas($where);
			}
			$cuadro->set_datos($datos);	
		}		
	}

	function evt__cuadro_cursadas__seleccion($seleccion)
	{
		$this->dep('datos_asistencia')->set_cursada($seleccion['id']);
		$this->set_pantalla('pant_edicion');
	}	

	function conf_evt__cuadro_cursadas__eliminar(toba_evento_usuario $evento, $fila)
	{
		$evento->anular();
	}
	function get_cursadas_de_sede($id_sede){
		return toba::zona()->get_cursadas("id_sede=$id_sede");
	}
	
}
?>
<?php
class ci_curso extends escuela_ci
{
	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_cursos();
		if(toba::zona()->cargada()){
			$curso = array('id'=>toba::zona()->get_editable_id());			
			$this->dep('datos_curso')->cargar($curso);			
		}

	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		$this->dep('datos_curso')->guardar();
	}

	function evt__cancelar()
	{
		$this->dep('datos_curso')->resetear();		//deshago las modificaciones y vuevo a cargar
		
		if(toba::zona()->cargada()){
			$curso = array('id'=>toba::zona()->get_editable_id());			
			$this->dep('datos_curso')->cargar($curso);			
		}
	}

}

?>
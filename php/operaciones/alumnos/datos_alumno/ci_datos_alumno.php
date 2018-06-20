<?php
class ci_datos_alumno extends escuela_ci
{
	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_alumno();	
		if(toba::zona()->cargada()){
			$alumno = array('id'=>toba::zona()->get_editable_id());			
			$this->dep('datos_persona')->relacion()->cargar($alumno);
		}		
	}

	function evt__procesar(){
		$this->dep('datos_persona')->guardar();
	}
	function evt__cancelar(){
		$this->dep('datos_persona')->relacion()->resetear();
		toba::vinculador()->navegar_a('escuela','3514'); //navega a la seleccion de usuario
	}
}

?>
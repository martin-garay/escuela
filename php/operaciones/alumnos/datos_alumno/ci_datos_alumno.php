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
}

?>
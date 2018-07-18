<?php
class ci_materia_estudio extends escuela_ci
{
	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_alumno();	
		// if(toba::zona()->cargada()){
		// 	$alumno = array('id'=>toba::zona()->get_editable_id());			
		// 	$this->dep('datos_persona')->relacion()->cargar($alumno);
		// }		
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		return toba::zona()->get_clases();
	}

	function evt__cuadro__seleccion($seleccion)
	{
	}

	function conf_evt__cuadro__seleccion(toba_evento_usuario $evento, $fila)
	{
	}

}
?>
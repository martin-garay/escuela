<?php
class ci_asistencia extends escuela_ci
{
	protected $s__id_cursada_alumno;
	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_alumno();			
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_cursadas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cursadas(escuela_ei_cuadro $cuadro)
	{
		return toba::zona()->get_cursadas();
	}
	
	//-----------------------------------------------------------------------------------
	//---- pant_asistencia --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_asistencia(toba_ei_pantalla $pantalla)
	{
		$cursada_alumno = toba::consulta_php('cursos')->get_cursadas_alumnos('id='.$this->s__id_cursada_alumno);
		$pantalla->set_descripcion($cursada_alumno[0]['curso'].' - '.$cursada_alumno[0]['cursada'].' - '.$cursada_alumno[0]['sede']);
	}

	function evt__cuadro_cursadas__seleccion($seleccion)
	{
		$this->s__id_cursada_alumno = $seleccion['id'];
		$this->set_pantalla('pant_asistencia');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_teoricas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_teoricas(escuela_ei_cuadro $cuadro)
	{
		return toba::consulta_php('cursos')->get_asistencia_clases_teoricas("id_cursada_alumno=".$this->s__id_cursada_alumno);
	}



}
?>
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
		
		$datos_curso = toba::consulta_php('cursos')->get_cursos("id=".$cursada_alumno[0]['id_curso']);
		$descripcion = $cursada_alumno[0]['curso'].' - '.$cursada_alumno[0]['cursada'].' - '.$cursada_alumno[0]['sede'] ."<br>";
		$descripcion .= "<br>Cantidad de horas practicas: {$datos_curso[0][cant_clases_practicas]} hs(Minimo {$datos_curso[0][cant_minima_practicas]})";
		$descripcion .= "<br>Cantidad de horas teoricas: {$datos_curso[0][cant_clases_teoricas]} hs(Minimo {$datos_curso[0][cant_minima_teoricas]})";
		$pantalla->set_descripcion($descripcion);
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

	//-----------------------------------------------------------------------------------
	//---- cuadro_practicas -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_practicas(escuela_ei_cuadro $cuadro)
	{
		return toba::consulta_php('cursos')->get_asistencia_clases_practicas("id_cursada_alumno=".$this->s__id_cursada_alumno);	
	}

	function extender_objeto_js(){
		if($this->get_id_pantalla()=='pant_asistencia')
			echo "		
				$('.ei-cuadro-total').each(function(){
					var cant_horas = '<strong>' + $(this).first().text() + ' hs</strong>';
					$(this).first().html(cant_horas);
				});
			";
	}
}
?>
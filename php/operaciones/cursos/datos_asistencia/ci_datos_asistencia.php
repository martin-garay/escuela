<?php
class ci_datos_asistencia extends escuela_ci
{
	protected $s__id_cursada;
	protected $id_curso;


	function set_curso($id_curso){
		$this->id_curso = $id_curso;
	}
//	function ini(){
//		if( toba::memoria()->existe_dato('id_editable_zona') ){
//			$id_zona = toba::memoria()->get_dato('id_editable_zona');
//			toba::zona()->cargar($id_zona); 
//		}
//	}

	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}
	function conf__pant_asistencia(toba_ei_pantalla $pantalla)
	{
		$cursada = toba::consulta_php('cursos')->get_cursadas('id='.$this->s__id_cursada);
		$clase = $this->tabla('clases')->get();
		$descripcion_cursada = $cursada[0]['curso']. ' ('.$cursada[0]['sede'].') - ' . $cursada[0]['descripcion'];
		$descripcion_clase = 'Clase: '.$clase['descripcion'].
							'. Fecha: '.date('d-m-Y',strtotime($clase['fecha'])).
							' de '.substr($clase['hora_inicio'], 0,5) . ' a '.substr($clase['hora_fin'], 0,5);
		$pantalla->set_descripcion('<strong>'.$descripcion_cursada . '<br>' .$descripcion_clase.'</strong>');
	}
	//-----------------------------------------------------------------------------------
	//---- cuadro_clases ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_clases(escuela_ei_cuadro $cuadro)
	{
		if(isset($this->s__id_cursada)){
			$datos = toba::consulta_php('cursos')->get_clases("id_cursada=".$this->s__id_cursada);
			$cuadro->set_datos($datos);	
		}		
	}

	function evt__cuadro_clases__seleccion($seleccion)
	{
		$this->relacion()->cargar($seleccion);
		$this->set_pantalla('pant_asistencia');
	}	

	//-----------------------------------------------------------------------------------
	//---- form_ml_asistencia -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_asistencia(escuela_ei_formulario_ml $form_ml)
	{
		if($this->tabla('clases_asistencia')->get_cantidad_filas()>0){
			$datos = $this->tabla('clases_asistencia')->get_filas();
		}else{
			$datos = $this->get_alumnos_clase();
		}
		$form_ml->set_datos($datos);
	}

	function evt__form_ml_asistencia__modificacion($datos)
	{		
		$this->tabla('clases_asistencia')->procesar_filas($datos);
	}

	function get_alumnos_del_modulo(){
		$clase = $this->tabla('clases')->get();
		$id_modulo = $clase['id_modulo'];		 
		$sql = "SELECT $id_clase as id_clase,id_cursadas_alumnos as id_cursada_alumno, 'A' as apex_ei_analisis_fila 
				FROM v_cursadas_modulos_alumnos WHERE id_modulo=$id_modulo ORDER BY apellido_alumno,nombre_alumno";
		return toba::db()->consultar($sql);
	}

	function get_inscripciones($filtro){
		$id_curso = toba::zona()->get_editable_id();
		//$sql = "SELECT id, dni||' '||apellido||' '||nombre as descripcion
		//		FROM v_personas WHERE es_alumno(id) AND dni||' '||apellido||' '||nombre ILIKE '%$filtro%' AND
		//			EXISTS(SELECT 1 FROM cursadas_alumnos ca 
		//					WHERE ca.id_alumno=v_personas.id AND ca.id_curso=$id_curso /*AND id_condicion_alumno=2*/)";
		$sql = "SELECT id, dni||' '||apellido_alumno||' '||nombre_alumno as descripcion 
				FROM v_cursadas_alumnos WHERE id_curso=$id_curso";
		return toba::db()->consultar($sql);
	}
	function get_inscripciones_descripcion($id_cursada_alumno){
		$sql = "SELECT dni||' '||apellido_alumno||' '||nombre_alumno as descripcion 
				FROM v_cursadas_alumnos WHERE id=$id_cursada_alumno";
        $datos = toba::db()->consultar($sql);
        return $datos[0]['descripcion'];
	}

	/* --------------------------------------------------------------------------- */
	/* --------------------------- API para Consumidores -------------------------- */
	/* --------------------------------------------------------------------------- */
	function set_cursada($id_cursada){
		$this->s__id_cursada = $id_cursada;
	}

	function guardar(){
		try {			
			//$this->tabla('clases_asistencia')->sincronizar();
			$this->relacion()->sincronizar();
		} catch (toba_error_db $e) {
			toba::notificacion()->error("Error. No se pueden guardar los datos");
		}
	}
	function resetear(){
		unset($this->s__id_cursada);
		$this->relacion()->resetear();
	}

	function get_alumnos_clase(){			
		$clase = $this->tabla('clases')->get();
		$datos = toba::consulta_php('cursos')->get_alumnos_modulos("id_modulo=".$clase['id_modulo'],"apellido_alumno,nombre_alumno");
		foreach ($datos as $key => $value) {
		 	$datos[$key]['apex_ei_analisis_fila'] = 'A';
		 	$datos[$key]['id_cursada_alumno'] = $datos[$key]['id_cursadas_alumnos'];
		 } 
		return $datos;
		
	}



}
?>
<?php
class ci_datos_clase extends escuela_ci
{

	protected $id_curso;

	function set_curso($id_curso){
		$this->id_curso = $id_curso;
	}
	function get_cursadas(){
		if(isset($this->id_curso))
			return toba::consulta_php('cursos')->get_cursadas("id_curso={$this->id_curso}", 'fecha_inicio DESC');
		else
			return toba::consulta_php('cursos')->get_cursadas(null, 'fecha_inicio DESC');
	}
	function get_modulos($id_cursada){
		return toba::consulta_php('cursos')->get_modulos_cursadas("id_cursada=$id_cursada");
	}

	//oculto la pantalla de asistencia por que ahora se hace desde otra opcion
	function conf(){
		$this->pantalla()->eliminar_tab('pant_asistencia');
	}
	function conf__form_clase(escuela_ei_formulario $form)
	{        
		//if($this->tabla('clases')->esta_cargada())
			$form->set_datos($this->tabla('clases')->get());
		if(isset($this->id_curso))
			$form->ef('id_curso')->set_estado($this->id_curso);
	}
	function evt__form_clase__modificacion($datos)
	{     
		if(isset($this->id_curso))
			$datos['id_curso'] = $this->id_curso; 
		$this->tabla('clases')->set($datos);        
	}

	function conf__form_ml_profesores(escuela_ei_formulario_ml $form)
	{        
		if($this->tabla('clases_profesores')->esta_cargada())
			return $this->tabla('clases_profesores')->get_filas();
	}
	function evt__form_ml_profesores__modificacion($datos){
		$this->tabla('clases_profesores')->procesar_filas($datos);
	}

	function conf__form_ml_alumnos(escuela_ei_formulario_ml $form)
	{        
//		if($this->tabla('cursadas_alumnos')->esta_cargada())
//			return $this->tabla('cursadas_alumnos')->get_filas();
	}
	function evt__form_ml_alumnos__modificacion($datos){
//		$this->tabla('cursadas_alumnos')->procesar_filas($datos);
	}

/* --------------------------------------------------------------------------- */
/* --------------------------- API para Consumidores -------------------------- */
/* --------------------------------------------------------------------------- */
	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}

	function cargar($cursada){		
		$this->relacion()->cargar($cursada);
	}
	function guardar(){
		try {			
			$this->relacion()->sincronizar();			
		} catch (toba_error_db $e) {
			toba::notificacion()->error("Error. No se pueden guardar los datos");
		}
	}
	function resetear(){
		$this->relacion()->resetear();
	}
	function borrar($cursada){
		$this->relacion()->cargar($cursada);        
		try{
			$this->relacion()->eliminar_todo();
			$this->relacion()->sincronizar();
		}catch(toba_error_db $e){
			if($e->get_sqlstate()=="db_23503"){
				toba::notificacion()->agregar('ATENCION! El registro esta siendo utilizado');
			}else{
				toba::notificacion()->agregar('ERROR! El registro No puede eliminarse');
			}
		}
		$this->relacion()->resetear();
	}

	function ajax__validar_fecha_modulo($parametros, toba_ajax_respuesta $respuesta){
		$id_modulo = $parametros[0];
		$fecha = $parametros[1];
		$resultado['ok'] = toba::consulta_php('cursos')->validar_fecha_clase_en_modulo($id_modulo,$fecha);
		$respuesta->set($resultado);
	}	
}
?>
<?php
class ci_datos_cursadas extends escuela_ci
{
	protected $id_curso;

	function set_curso($id_curso){
		$this->id_curso = $id_curso;
	}
	function conf(){
		if(!$this->relacion()->esta_cargada()){
			$this->pantalla()->tab('pant_alumnos')->ocultar();
			$this->pantalla()->tab('pant_modulos')->ocultar();
		}

	}

	function conf__form_cursada(escuela_ei_formulario $form)
	{        		
		$form->set_datos($this->tabla('cursadas')->get());
		if(isset($this->id_curso))
			$form->ef('id_curso')->set_estado($this->id_curso);		
	}
	function evt__form_cursada__modificacion($datos)
	{     
		if(isset($this->id_curso))
			$datos['id_curso'] = $this->id_curso; 
		$this->tabla('cursadas')->set($datos);		
	}

	function conf__form_ml_profesores(escuela_ei_formulario_ml $form)
	{        
		//if($this->tabla('cursadas_profesores')->esta_cargada())
			return $this->tabla('cursadas_profesores')->get_filas();
	}
	function evt__form_ml_profesores__modificacion($datos){
		$this->tabla('cursadas_profesores')->procesar_filas($datos);
	}

	function conf__form_ml_alumnos(escuela_ei_formulario_ml $form)
	{        
		if($this->tabla('cursadas_alumnos')->esta_cargada())
			return $this->tabla('cursadas_alumnos')->get_filas();
	}
	function evt__form_ml_alumnos__modificacion($datos){
		$this->tabla('cursadas_alumnos')->procesar_filas($datos);
	}
	function conf__form_ml_modulos(escuela_ei_formulario_ml $form)
	{        
		if($this->tabla('cursadas_modulos')->esta_cargada())
			return $this->tabla('cursadas_modulos')->get_filas();
	}
	function evt__form_ml_modulos__modificacion($datos){
		$this->tabla('cursadas_modulos')->procesar_filas($datos);
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
}
?>
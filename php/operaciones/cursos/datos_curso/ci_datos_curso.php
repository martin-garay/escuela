<?php
class ci_datos_curso extends escuela_ci
{

	function conf__form(escuela_ei_formulario $form)
	{        
		if($this->tabla('cursos')->esta_cargada())
			return $this->tabla('cursos')->get();    
	}
	function evt__form__modificacion($datos)
	{        
		$this->tabla('cursos')->set($datos);        
	}

	function conf__form_ml(escuela_ei_formulario_ml $form)
	{        
		if($this->tabla('cursos_correlatividad')->esta_cargada())
			return $this->tabla('cursos_correlatividad')->get_filas();
	}
	function evt__form_ml__modificacion($datos){
		$this->tabla('cursos_correlatividad')->procesar_filas($datos);
	}

	function conf__form_ml_modulos(escuela_ei_formulario_ml $form)
	{        
		if($this->tabla('cursos_modulos')->esta_cargada())
			return $this->tabla('cursos_modulos')->get_filas();
	}
	function evt__form_ml_modulos__modificacion($datos){
		$this->tabla('cursos_modulos')->procesar_filas($datos);
	}
	function conf__form_ml_titulos(escuela_ei_formulario_ml $form)
	{        
		if($this->tabla('cursos_titulos')->esta_cargada())
			return $this->tabla('cursos_titulos')->get_filas();
	}
	function evt__form_ml_titulos__modificacion($datos){
		$this->tabla('cursos_titulos')->procesar_filas($datos);
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

	function cargar($curso){		
		$this->relacion()->cargar($curso);
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
	function borrar($curso){
		$this->relacion()->cargar($curso);        
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
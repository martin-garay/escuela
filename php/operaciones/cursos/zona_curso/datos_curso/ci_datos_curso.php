<?php
class ci_datos_curso extends escuela_ci
{

	function conf__form(escuela_ei_formulario $form)
	{        
		if($this->dep('datos')->esta_cargada())
			return $this->dep('datos')->get();    
	}
	function evt__form__modificacion($datos)
	{        
		$this->dep('datos')->set($datos);        
	}

/* --------------------------------------------------------------------------- */
/* --------------------------- API para Consumidores -------------------------- */
/* --------------------------------------------------------------------------- */
	function cargar($curso){		
		$this->dep('datos')->cargar($curso);
	}
	function guardar(){
		try {			
			$this->dep('datos')->sincronizar();			
		} catch (toba_error_db $e) {
			toba::notificacion()->error("Error. No se pueden guardar los datos");
		}
	}
	function resetear(){
		$this->dep('datos')->resetear();
	}
	function borrar($curso){
		$this->dep('datos')->cargar($curso);        
		try{
			$this->dep('datos')->eliminar_todo();
			$this->dep('datos')->sincronizar();
		}catch(toba_error_db $e){
			if($e->get_sqlstate()=="db_23503"){
				toba::notificacion()->agregar('ATENCION! El registro esta siendo utilizado');
			}else{
				toba::notificacion()->agregar('ERROR! El registro No puede eliminarse');
			}
		}
		$this->dep('datos')->resetear();
	}
}

?>
<?php
class ci_datos_persona extends escuela_ci
{


	function ini()
	{
		//toba::consulta_php('comunes')->chequeo_zona_alumno();
		/*
		if( null !==(toba::zona()) ){
			if(toba::zona()->cargada()){
				$alumno = array('id'=>toba::zona()->get_editable_id());
				$this->relacion()->cargar($alumno);
			}
		}*/
	}

	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__procesar(){}
	function evt__cancelar(){}

	//-----------------------------------------------------------------------------------
	//---- form_persona ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_persona(escuela_ei_formulario $form)
	{        
		return $this->relacion()->tabla("personas")->get();    
	}
	function evt__form_persona__modificacion($datos)
	{        
		$this->relacion()->tabla("personas")->set($datos);        
	}

	//-----------------------------------------------------------------------------------
	//---- form_laboral -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_laboral(escuela_ei_formulario $form)
	{                
		return $this->relacion()->tabla("datos_laborales")->get();        
	}
	function evt__form_laboral__modificacion($datos)
	{        
		$this->relacion()->tabla("datos_laborales")->set($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_academicos --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_academicos(escuela_ei_formulario $form)
	{            
		return $this->relacion()->tabla("datos_academicos")->get();        
	}
	function evt__form_academicos__modificacion($datos)
	{        
		$this->relacion()->tabla("datos_academicos")->set($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_salud -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_salud(escuela_ei_formulario $form)
	{                
		return $this->relacion()->tabla("datos_salud")->get();
	}
	function evt__form_salud__modificacion($datos)
	{        
		$this->relacion()->tabla("datos_salud")->set($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_datos_actuales ----------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_datos_actuales(escuela_ei_formulario $form)
	{                
		return $this->relacion()->tabla("datos_actuales")->get();        
	}

	function evt__form_datos_actuales__modificacion($datos)
	{        
		$this->relacion()->tabla("datos_actuales")->set($datos);
	}

/* --------------------------------------------------------------------------- */
/* --------------------------- API para Consumidores -------------------------- */
/* --------------------------------------------------------------------------- */
	private function crearUsuario(){
		$persona = $this->tabla('personas')->get();
		
		//perfiles que le tengo que asignar
		$perfiles_persona = toba::consulta_php('personas')->get_tipo_persona_perfiles("id_tipo_persona=".$persona['id_tipo_persona']); 
		$perfiles = array_column($perfiles_persona,'perfil');
		
		$datos_actuales = $this->tabla('datos_actuales')->get();
		$atributos = (isset($datos_actuales['email'])) ? array('email'=>$datos_actuales['email']) : array();
		
		$crear_usuario = new CrearUsuario();                
		$crear_usuario->crear($persona['dni'], $persona['nombre'].' '.$persona['apellido'], $persona['dni'], $atributos, $perfiles);
	}
	function guardar(){
		try {
			$this->crearUsuario();
			$this->relacion()->sincronizar();
			//$this->crearUsuario();
		} catch (toba_error_db $e) {
			toba::notificacion()->error("Error. No se pueden guardar los datos");
		}
	}
	function borrar(){        
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
	function imprimir(toba_vista_pdf $salida){
		$salida->subtitulo('Datos Generales');
		$this->dep('form_persona')->vista_pdf($salida);

		$salida->subtitulo('Datos Actuales');
		$this->dep('form_datos_actuales')->vista_pdf($salida);

		$salida->subtitulo('Datos Salud');
		$this->dep('form_salud')->vista_pdf($salida);

		$salida->subtitulo('Datos Laborales');
		$this->dep('form_laboral')->vista_pdf($salida);

		$salida->subtitulo('Datos Académicos');
		$this->dep('form_academicos')->vista_pdf($salida);
	}
	function get_datos_generales(){
		return $this->tabla('personas')->get();
	}
	/* ------------------------------- FIN API --------------------------------- */

}

?>
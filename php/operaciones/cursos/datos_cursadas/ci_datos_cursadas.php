<?php
class ci_datos_cursadas extends escuela_ci
{
	protected $s__filtro;

	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}

	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_cursos();
		if(toba::zona()->cargada()){
			$curso = array('id'=>toba::zona()->get_editable_id());			
			//$this->dep('datos_curso')->cargar($curso);			
		}
	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------	
	function evt__cancelar()
	{
		$this->relacion()->resetear();			
		$this->set_pantalla('pant_inicial');
	}

	function evt__procesar()
	{		
		try {
			$this->relacion()->sincronizar();
			$this->set_pantalla('pant_inicial');
		} catch (toba_error_db $e) {
			toba::notificacion()->error("Error al grabar el registro");
		}
	}

	function evt__nuevo(){
		$this->set_pantalla('pant_edicion');
	}

//-----------------------------------------------------------------------------------
//---- Pant Inicial -----------------------------------------------------------------
//-----------------------------------------------------------------------------------	

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__filtro))
			$filtro->set_datos($this->s__filtro);
	}
	function evt__filtro__filtrar($datos)
	{
		$this->s__filtro = $datos;
	}
	function evt__filtro__cancelar()
	{
		unset($this->s__filtro);
	}
	
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		return toba::zona()->get_cursadas();
	}
	function evt__cuadro__seleccion($seleccion)
	{
		$this->relacion()->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	function evt__cuadro__eliminar($seleccion)
	{
		try{
			$this->relacion()->cargar($seleccion);
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

//-----------------------------------------------------------------------------------
//---- Pant Edicion -----------------------------------------------------------------
//-----------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form(escuela_ei_formulario $form)
	{
		if( $this->tabla('cursadas')->esta_cargada() ){
			$form->set_datos($this->tabla('cursadas')->get());	
		}			
	}
	function evt__form__modificacion($datos)
	{
		$datos['id_curso'] = toba::zona()->get_editable_id();
		$this->tabla('cursadas')->set($datos);
	}

	
	//-----------------------------------------------------------------------------------
	//---- form_ml ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_ml(escuela_ei_formulario_ml $form_ml)
	{
		if($this->tabla('cursadas_profesores')->esta_cargada())
			$form_ml->set_datos($this->tabla('cursadas_profesores')->get_filas());
	}

	function evt__form_ml__modificacion($datos)
	{
		$this->tabla('cursadas_profesores')->procesar_filas($datos);
	}

}
?>
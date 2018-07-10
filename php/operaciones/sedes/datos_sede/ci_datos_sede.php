<?php
class ci_datos_sede extends escuela_ci
{
	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form(escuela_ei_formulario $form)
	{
		if($this->tabla('sedes')->esta_cargada()){
			$form->set_datos($this->tabla('sedes')->get());
		}
	}
	function evt__form__modificacion($datos)
	{
		$this->tabla('sedes')->set($datos);		
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_ml(escuela_ei_formulario_ml $form_ml)
	{
		if( $this->tabla('aulas')->esta_cargada() )
			$form_ml->set_datos( $this->tabla('aulas')->get_filas() );
	}
	function evt__form_ml__modificacion($datos)
	{
		$this->tabla('aulas')->procesar_filas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_formadores ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_ml_formadores(escuela_ei_formulario_ml $form_ml)
	{
		if( $this->tabla('formadores')->esta_cargada() )
			$form_ml->set_datos( $this->tabla('formadores')->get_filas() );
	}
	function evt__form_ml_formadores__modificacion($datos)
	{
		$this->tabla('formadores')->procesar_filas($datos);
	}
	function get_combo_formadores(){
		return toba::consulta_php('personas')->get_personas("id_tipo_persona=2","apellido, nombre");
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
	function guardar(){
		$this->relacion()->sincronizar();
		$this->relacion()->resetear();
	}
	function borrar($id_relacion){
		$this->relacion()->cargar($id_relacion);
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
<?php
class ci_alertas extends escuela_ci
{
	protected $s__filtro;

	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->dep('relacion')->tabla($nombre);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		$this->relacion()->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__procesar()
	{
		try {
			$this->relacion()->sincronizar();
		} catch (toba_error_db $e) {
			toba::notificacion()->error('Error al guardar');
		}		
		$this->set_pantalla('pant_inicial');
	}


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
		$where = (isset($this->s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
		$datos = toba::consulta_php('alertas')->get_alertas($where);
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->relacion()->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(escuela_ei_formulario $form)
	{
		if($this->tabla('alertas')->esta_cargada())
			$form->set_datos($this->tabla('alertas')->get());
	}

	function evt__form__modificacion($datos)
	{
		$this->tabla('alertas')->set($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml(escuela_ei_formulario_ml $form_ml)
	{
		if($this->tabla('alertas_niveles')->esta_cargada())
			$form_ml->set_datos($this->tabla('alertas_niveles')->get_filas());		
	}

	function evt__form_ml__modificacion($datos)
	{
		$this->tabla('alertas_niveles')->procesar_filas($datos);
	}

}
?>
<?php
class ci_numero_registro extends escuela_ci
{
	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(escuela_ei_formulario $form)
	{
		$this->dep('datos')->cargar(array('id'=>1));
		return $this->dep('datos')->get();
	}

	function evt__form__guardar($datos)
	{
		$this->dep('datos')->set($datos);
		$this->dep('datos')->sincronizar();
	}

}

?>
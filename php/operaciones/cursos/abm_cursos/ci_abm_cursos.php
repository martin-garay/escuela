<?php
class ci_abm_cursos extends escuela_ci
{
	protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		$datos = toba::consulta_php('cursos')->get_cursos();
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('datos_curso')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__eliminar($seleccion)
	{
		$this->dep('datos_curso')->borrar($seleccion);
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
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		$this->dep('datos_curso')->guardar();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->dep('datos_curso')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

}
?>
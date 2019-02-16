<?php
class ci_clases_practicas extends escuela_ci
{
	protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__procesar()
	{
		$this->dep('generacion_clase')->guardar();
		toba::notificacion()->info("Se genero la clase");
		$this->dep('generacion_clase')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->dep('generacion_clase')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__filtro))
			return $this->s__filtro;
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
		return toba::consulta_php('cursos')->get_clases_practicas($where, 'fecha');
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('generacion_clase')->relacion()->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}


}
?>
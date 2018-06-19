<?php

class ci_abm_sedes extends escuela_ci
{
	protected $s__datos_filtro;

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro)){
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		$where = (isset($this->s__datos_filtro)) ? $this->dep('filtro')->get_sql_where() : '';		
		$datos = toba::consulta_php('comunes')->get_generico('v_sedes',$where,'nombre');
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('datos_sede')->relacion()->cargar($seleccion);
		$this->set_pantalla("pant_edicion");
	}

	function evt__cuadro__eliminar($seleccion)
	{
		$this->dep('datos_sede')->borrar($seleccion);		
	}	
	function evt__cancelar()
	{
		$this->dep('datos_sede')->relacion()->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo(){
		$this->dep('datos_sede')->relacion()->resetear();
		$this->set_pantalla('pant_edicion');
	}
	function evt__procesar(){
		$this->dep('datos_sede')->guardar();		
		$this->set_pantalla("pant_inicial");
	}
	
}
?>
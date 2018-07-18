<?php
class ci_clases extends escuela_ci
{
	protected $s__filtro;

	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_cursos();
		if(toba::zona()->cargada()){
			$curso = array('id'=>toba::zona()->get_editable_id());
		}
	}
	//-----------------------------------------------------------------------------------
	//---- eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__procesar(){		
		$this->dep('datos_clase')->guardar();
		$this->dep('datos_clase')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->dep('datos_clase')->resetear();		//deshago las modificaciones y vuevo a cargar	
		$this->set_pantalla('pant_inicial');
	}
	function evt__nuevo(){
		$this->dep('datos_clase')->resetear();
		$this->dep('datos_clase')->set_curso(toba::zona()->get_editable_id()); //le paso el id del curso al ci hijo
		$this->set_pantalla('pant_edicion');
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
	//---- cuadro_clases ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_clases(escuela_ei_cuadro $cuadro)
	{
		$where = (isset($this->s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
		return toba::zona()->get_clases($where,'fecha ASC');
	}

	function evt__cuadro_clases__seleccion($seleccion)
	{
		$this->dep('datos_clase')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}

}
?>
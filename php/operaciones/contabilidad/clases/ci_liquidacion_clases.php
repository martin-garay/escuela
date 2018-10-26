<?php
class ci_liquidacion_clases extends escuela_ci
{
	protected $s__filtro;
	protected $s__filtro_clases;
	protected $s__clases_a_liquidar;

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->set_pantalla('pant_inicial');
	}

	function evt__generar()
	{
		toba::consulta_php('liquidaciones')->liquidar_clases_practicas( array_column($this->s__clases_a_liquidar,'id') );
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
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
		if(isset($this->s__filtro)){
			$where = $this->dep('filtro')->get_sql_where();
			return toba::consulta_php("liquidaciones")->get_liquidaciones($where, "fecha DESC");	
		}
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->s__id_liquidacion = $seleccion['id'];
		$this->set_pantalla('edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_clases ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_clases(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__filtro_clases))
			return $this->s__filtro_clases;
	}

	function evt__filtro_clases__filtrar($datos)
	{
		$this->s__filtro_clases = $datos;
	}

	function evt__filtro_clases__cancelar()
	{
		unset($this->s__filtro_clases);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_liquidacion -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_liquidacion(escuela_ei_cuadro $cuadro)
	{
		$cuadro->set_titulo("Clases Practicas <div style='float:right'>Seleccionar Todos <input type='checkbox' id='seleccionar_todos'/></div>");
		$where = (isset($this->s__filtro_clases)) ? $this->dep('filtro_clases')->get_sql_where() : null;
		return toba::consulta_php('liquidaciones')->get_clases_practicas_a_liquidar($where, "id_profesor,fecha DESC");
		
	}

	function evt__cuadro_liquidacion__seleccionar($datos)
	{
		$this->s__clases_a_liquidar = $datos; 
	}

	function extender_objeto_js(){
		if($this->get_id_pantalla()=='pant_edicion'){
			echo "
			$('.ei-cuadro-barra-sup').css('height','25px');
			$('#seleccionar_todos').click(function(){
				if($('#seleccionar_todos').is(':checked')){
					{$this->dep('cuadro_liquidacion')->objeto_js}.seleccionar_todos('seleccionar');
				}else{
					{$this->dep('cuadro_liquidacion')->objeto_js}.deseleccionar_todos('seleccionar');
				}
			});
			";	
		}
		
	}
}

?>
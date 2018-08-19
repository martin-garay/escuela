<?php
class ci_generacion_cuotas extends escuela_ci
{
	protected $s__filtro;
	protected $s__seleccion_cuota;
	protected $s__seleccion_alumnos;

	function relacion(){
		return $this->cn()->relacion();
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__volver_inicio()
	{
		$this->set_pantalla('pant_inicial');
	}

	function evt__volver_cuota()
	{
		$this->set_pantalla('pant_alta_cuota');
	}

	function evt__generar()
	{
		$this->cn()->desactivar_transaccion();
		$this->cn()->generar();
		// $this->set_pantalla('pant_inicial');		
	}

	function evt__nuevo()
	{
		$this->relacion()->resetear();
		$this->set_pantalla('pant_alta_cuota');
	}

	function evt__ir_a_generar()
	{
		$this->set_pantalla('pant_alumnos');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		$where = (isset($this->s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
		$datos = toba::consulta_php('cuotas')->get_cuotas_generadas($where,'fecha');
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->set_pantalla('pant_alumnos');
		$this->s__seleccion_cuota = $seleccion;

	}

	function conf_evt__cuadro__seleccion(toba_evento_usuario $evento, $fila)
	{
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
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form(escuela_ei_formulario $form)
	{
		if($this->tabla('cuotas')->get_cantidad_filas()>0){
			$form->set_datos($this->tabla('cuotas')->get());

		}
	}

	function evt__form__modificacion($datos)
	{
		$this->tabla('cuotas')->set($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_ml(escuela_ei_formulario_ml $form_ml)
	{
		//si selecciono el modulo traigo los alumnos de ese modulo
		if($this->tabla('cuotas')->get_cantidad_filas()>0){
			$cuota = $this->tabla('cuotas')->get();
			$datos = toba::consulta_php('cuotas')->get_alumnos_modulo_sin_cuota($cuota['id_modulo']);
			$form_ml->set_datos($datos);
		}	
	}

	function evt__form_ml__modificacion($datos)
	{
		$this->relacion()->tabla('cuotas_detalle')->procesar_filas($datos);
	}
	function get_fecha_operacion($id_modulo){
		$modulo = toba::consulta_php('cursos')->get_modulos_cursadas("id=$id_modulo");
		$mes = substr(($modulo[0]['mes']+100), 1);
		return "01/$mes/".$modulo[0]['anio'];
	}
	function get_importe_modulo($id_modulo){
		$modulo = toba::consulta_php('cursos')->get_modulos_cursadas("id=$id_modulo");
		return $modulo[0]['importe_cuota'];
	}	
	function get_modulos_cursada($id_cursada){
		$sql = "SELECT id, descripcion||'('||anio||'-'||mes||')' as descripcion FROM v_cursadas_modulos WHERE id_cursada=$id_cursada ORDER BY anio,mes";
		return toba::consulta_php('cursos')->get_modulos_cursadas("id_cursada=$id_cursada");		
	}		
	function get_importe_cuota_curso($id_curso){
		$datos = toba::consulta_php('cursos')->get_cursos("id=$id_curso");
		return $datos[0]['importe_cuota'];
	}
}
?> 
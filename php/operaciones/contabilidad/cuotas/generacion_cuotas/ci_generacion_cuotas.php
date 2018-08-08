<?php
class ci_generacion_cuotas extends escuela_ci
{
	protected $s__filtro;
	protected $s__seleccion_cuota;
	protected $s__seleccion_alumnos;

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
		$this->set_pantalla('pant_inicial');		
	}

	function evt__nuevo()
	{
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
	//---- cuadro_alumnos ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__cuadro_alumnos(escuela_ei_cuadro $cuadro)
	{
		//Edicion
		if(isset($this->s__seleccion_cuota)){
			$where = 'id='.$this->s__seleccion_cuota['id'];
			$datos = toba::consulta_php('cuotas')->get_alumnos_cuota_generada($where,'apellido,nombre');
			$cuadro->set_datos($datos);
		}else{
		//Alta
			if($this->dep('datos')->esta_cargada()){
				$cuota = $this->dep('datos')->get();
				$datos = toba::consulta_php('cuotas')->get_alumnos_modulo_sin_cuota($cuota['id_modulo']);
				$cuadro->set_datos($datos);	
			}			
		}		
	}

	function evt__cuadro_alumnos__seleccion($datos)
	{
		$this->s__seleccion_alumnos = $datos;
	}

	function conf_evt__cuadro_alumnos__seleccion(toba_evento_usuario $evento, $fila)
	{
		//Edicion
		if(!$this->dep('datos')->esta_cargada()){
			$evento->anular();
		}
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
		if($this->dep('datos')->esta_cargada()){
			$form->set_datos($this->dep('datos')->get());
		}
	}

	function evt__form__modificacion($datos)
	{
		$this->dep('datos')->set($datos);
	}

	function get_importe_modulo($id_modulo){
		$modulo = toba::consulta_php('cursos')->get_modulos_cursadas("id=$id_modulo");
		return $modulo[0]['importe_cuota'];
	}	
	function get_modulos_cursada($anio_modulo, $mes_modulo, $id_cursada){		
		return toba::consulta_php('cursos')->get_modulos_cursadas("id_cursada=$id_cursada AND anio=$anio_modulo AND mes=$mes_modulo AND paga_cuota");		
	}	
}

?>
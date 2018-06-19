<?php
class ci_alquiler_sede extends escuela_ci
{
	protected $s__datos_filtro;
	protected $s__seleccion_sede;
	protected $s__seleccion_alquiler;

	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}

//-----------------------------------------------------------------------------------
//---- Pant Incial ------------------------------------------------------------------
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
//---- Eventos ----------------------------------------------------------------------
//-----------------------------------------------------------------------------------

	function validar_superposicion($datos){		
		$error = false;
		$datos = $this->tabla('detalle')->get_filas();
		foreach ($datos as $key => $fila) {
			$id_detalle_alquiler = (isset($fila['id'])) ? $fila['id'] : null;	//si es una modificacion no valido la fila contra si mismo
			//valida superposicion con otros alquileres de la misma aula			
			$superposicion = toba::consulta_php('sedes')->superposicion_fecha_alquiler($fila['id_aula'],$fila['fecha'],$fila['hora_desde'], $fila['hora_hasta'],$id_detalle_alquiler);			
			if(count($superposicion)>0){
				$error = true;
				$fecha_formateada = date('d-m-Y',strtotime($fila['fecha']));
				foreach ($superposicion as $key2 => $value) {
					$msj = "<strong>$fecha_formateada {$fila['hora_desde']}-{$fila['hora_hasta']}</strong><br>
							se superpone con <br>
							<strong>{$value['fecha_base']} {$value['hora_desde_base']}-{$value['hora_hasta_base']}</strong> para aula \"{$value['aula']}\"";
					toba::notificacion()->error($msj);
				}
			}
		}
		return $error;
	}
	function evt__cancelar()
	{
		$this->relacion()->resetear();
		$this->set_pantalla('pant_inicial');
	}	
	function evt__procesar()
	{
		try {
			$error = $this->validar_superposicion( $this->tabla('detalle')->get_filas() );			
			if(!$error){
				$this->relacion()->sincronizar();
				$this->relacion()->resetear();
				$this->set_pantalla('pant_inicial');	
			}			
		} catch (toba_error_db $e) {
			toba::notificacion()->error('Error al guardar el registro');
		}
	}
	function evt__nuevo(){
		$this->relacion()->resetear();
		$this->set_pantalla('pant_edicion');
	}

//-----------------------------------------------------------------------------------
//---- Pant Inicial -----------------------------------------------------------------
//-----------------------------------------------------------------------------------


	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro))
			$filtro->set_datos($this->s__datos_filtro);
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
		$datos = toba::consulta_php('sedes')->get_alquiler_sede_detallado($where,'fecha_alta DESC');		
		$cuadro->set_datos($datos);
	}
	function evt__cuadro__seleccion($seleccion)
	{
		$this->relacion()->cargar($seleccion);
		$this->set_pantalla("pant_edicion");
	}
	function evt__cuadro__eliminar($seleccion)
	{
	}
	function conf_evt__cuadro__eliminar(toba_evento_usuario $evento, $fila){
		
	}

//-----------------------------------------------------------------------------------
//---- Pant Edicion -----------------------------------------------------------------
//-----------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form(escuela_ei_formulario $form)
	{			
		$form->set_datos($this->tabla('cabecera')->get());			
	}	
	function evt__form__modificacion($datos)
	{		
		$this->tabla('cabecera')->set($datos);
	}
	//-----------------------------------------------------------------------------------
	//---- form_ml ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_ml(escuela_ei_formulario_ml $form_ml)
	{		
		$form_ml->set_datos($this->tabla('detalle')->get_filas());	
	}
	function evt__form_ml__modificacion($datos)
	{		
		$this->tabla('detalle')->procesar_filas($datos);
	}


	function get_aulas_sede(){		
		if( $this->dep('form')->ef('id_sede')->tiene_estado() ){
			$id_sede = $this->dep('form')->ef('id_sede')->get_estado();
			$where = "id_sede=$id_sede";
			return toba::consulta_php('sedes')->get_aulas($where,'nombre');	
		}else{
			return array();
		}
		
	}
	function get_sedes_alquiler(){
		return toba::consulta_php('sedes')->get_sedes("paga_alquiler", "sede_descripcion");
	}
}
?>
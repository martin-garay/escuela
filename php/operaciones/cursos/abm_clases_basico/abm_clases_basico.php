<?php
class abm_clases_basico extends escuela_ci
{
	protected $s__id_cursada;
	protected $s__filtro;

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->set_pantalla('pant_inicial');
	}

//-----------------------------------------------------------------------------------------
//---- pant_inicial -----------------------------------------------------------------------
//-----------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__filtro)){
			$filtro->set_datos($this->s__filtro);
		}
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
	//---- cuadro_cursadas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__cuadro_cursadas(escuela_ei_cuadro $cuadro)
	{
		$where = (isset($this->s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
		$datos = toba::consulta_php('cursos')->get_cursadas($where, 'fecha_inicio DESC');
		$cuadro->set_datos($datos);
	}
	function evt__cuadro_cursadas__seleccion($seleccion)
	{
		$this->s__id_cursada = $seleccion['id'];
		$this->set_pantalla('pant_clases');
	}
	function conf_evt__cuadro_cursadas__eliminar(toba_evento_usuario $evento, $fila)
	{
		$evento->anular();
	}

//-----------------------------------------------------------------------------------------
//---- pant_clases ------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------

	//-----------------------------------------------------------------------------------
	//---- cuadro_clases ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__cuadro_clases(escuela_ei_cuadro $cuadro)
	{
		if(isset($this->s__id_cursada)){
			$cuadro->set_datos( toba::consulta_php('cursos')->get_clases("id_cursada=".$this->s__id_cursada,"fecha") );
		}
	}
	function evt__cuadro_clases__seleccion($seleccion)
	{
		$this->dep('dt_clases')->cargar($seleccion);
	}

	//-----------------------------------------------------------------------------------
	//---- form_clase -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__form_clase(escuela_ei_formulario $form)
	{
		//if($this->dep('dt_clases')->esta_cargada()){
			$form->set_datos($this->dep('dt_clases')->get());
		//}
	}
	function evt__form_clase__alta($datos)
	{
		$datos['id_cursada'] = $this->s__id_cursada;
		$this->dep('dt_clases')->set($datos);
		try{
			$this->dep('dt_clases')->sincronizar();
			$this->dep('dt_clases')->resetear();			
		} catch(toba_error_db $e){
			toba::db()->abortar_transaccion();
            if($e->get_sqlstate()=="db_23505"){
                /* Clave Duplicada */
                $mensaje ="Ya existe la clase que desea Grabar";
                toba::notificacion()->error($mensaje);
            }else{
                $mensaje_usuario='ERROR al guardar. Los cambios NO fueron registrados.';
                $mensaje.='<br><br>Información Adicional: ';
                $mensaje.='<br><strong>Error Nº </strong>'.$e->get_sqlstate();
                $mensaje.='<br><br><strong> Mensaje: </strong>'.$e->get_mensaje_motor();
                throw new toba_error($mensaje_usuario,$mensaje);
            }      
		}


	}
	function evt__form_clase__baja()
	{
		try {
			$this->dep('dt_clases')->eliminar();
		} catch (toba_error_db $e) {
			toba::notificacion()->error('No se puede eliminar el registro');
		}
	}
	function evt__form_clase__modificacion($datos)
	{
		$datos['id_cursada'] = $this->s__id_cursada;
		$this->dep('dt_clases')->set($datos);
		$this->dep('dt_clases')->sincronizar();
		$this->dep('dt_clases')->resetear();
	}

	function evt__form_clase__cancelar()
	{
		$this->dep('dt_clases')->resetear();
	}
	function get_modulos_cursada(){
		return toba::consulta_php('cursos')->get_modulos_cursadas("id_cursada=".$this->s__id_cursada);
	}
	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__pant_clases(toba_ei_pantalla $pantalla)
	{
		$cursada = toba::consulta_php('cursos')->get_cursadas('id='.$this->s__id_cursada);
		$pantalla->set_descripcion($cursada[0]['curso']. ' - ' . $cursada[0]['descripcion']);
	}

}
?>
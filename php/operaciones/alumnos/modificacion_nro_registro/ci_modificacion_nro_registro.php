<?php

class ci_modificacion_nro_registro extends escuela_ci
{
	protected $s__datos_filtro;
	protected $s__datos_form;

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
		$datos = toba::consulta_php('alumnos')->get_numeros_registros($where,"anio_registro,nro_registro");
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('registro_alumnos')->cargar($seleccion);		
		$this->set_pantalla("pant_edicion");
	}	

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(escuela_ei_formulario $form)
	{
		if($this->dep('registro_alumnos')->esta_cargada()){
			$form->set_datos($this->dep('registro_alumnos')->get());
		}
	}
	function evt__form__modificacion($datos)
	{
		$this->dep('registro_alumnos')->set($datos);
		$this->dep('registro_alumnos')->set($datos);		
	}

	function evt__cancelar()
	{
		$this->dep('registro_alumnos')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__procesar(){
		
		// $this->dep('titulos_alumnos')->persistidor()->desactivar_transaccion(false);
		// $this->dep('registro_alumnos')->persistidor()->desactivar_transaccion(false);
		// toba::db()->abrir_transaccion();

		$registro = $this->dep('registro_alumnos')->get();
		$duplicado = $this->buscar_duplicado($registro['id_alumno'],$registro['anio_registro'],$registro['nro_registro']);
		if( !$duplicado ){
			try {			
				$this->dep('registro_alumnos')->sincronizar();			
				$this->dep('registro_alumnos')->resetear();
				
				$this->set_pantalla("pant_inicial");	
				//toba::db()->cerrar_transaccion();
			} catch (toba_error_db $e) {
				toba::notificacion()->error('Error al grabar!');
				//toba::db()->abortar_transaccion();
			}	
		}else{
			$persona = $duplicado['dni'] . ' - ' . $duplicado['apellido'] . ' ' .$duplicado['nombre'];
			toba::notificacion()->error("El registro esta duplicado ". $persona);
		}

		
		
	}


	function get_titulos_alumno($id_alumno){
		return toba::consulta_php('cursos')->get_titulos_alumnos("id_alumno=$id_alumno AND id_tipo_titulo=1","fecha");
	}

	
	function ajax__validar_duplicado($parametros, toba_ajax_respuesta $respuesta)
    {    	
    	$id_alumno 		= $parametros[0];
    	$anio_registro 	= $parametros[1];
    	$nro_registro 	= $parametros[2];

    	$duplicado = $this->buscar_duplicado($id_alumno, $anio_registro, $nro_registro);
    	$respuesta->set( $duplicado );
    	
    }

    function buscar_duplicado($id_alumno, $anio_registro, $nro_registro){

    	$datos = toba::consulta_php('alumnos')->get_numeros_registros("id_alumno<>$id_alumno AND anio_registro=$anio_registro AND nro_registro=$nro_registro");
    	return (count($datos)>0) ? $datos[0] : false;

    }

	function extender_objeto_js(){
		if($this->get_id_pantalla()=='pant_edicion'){
			echo "
				
			";
		}
	}	
}
?>
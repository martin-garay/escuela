<?php
#$this->get_parametro('a') => tabla
#$this->get_parametro('b') => order by
#$this->get_parametro('c') => vista para cargar el cuadro , si no se pasa se toma 'a'
class ci_titulos_alumnos extends escuela_ci
{
	protected $s__datos_filtro;
	protected $s__datos_form;

//	function relacion(){
//		return $this->dep('relacion');
//	}
//	function tabla($nombre){
//		return $this->relacion()->tabla($nombre);
//	}
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
		$tabla = ( null !== $this->get_parametro('c') ) ? $this->get_parametro('c')	: $this->get_parametro('a');	
		$datos = toba::consulta_php('comunes')->get_generico($tabla,$where,$this->get_parametro('b'));
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('titulos_alumnos')->cargar($seleccion);
		$this->set_pantalla("pant_edicion");
	}

	function evt__cuadro__eliminar($seleccion)
	{
		$this->dep('titulos_alumnos')->cargar($seleccion);
		try{
            $this->dep('titulos_alumnos')->eliminar_todo();
            $this->dep('titulos_alumnos')->sincronizar();
		}catch(toba_error_db $e){
			if($e->get_sqlstate()=="db_23503"){
				toba::notificacion()->agregar('ATENCION! El registro esta siendo utilizado');
            }else{
				toba::notificacion()->agregar('ERROR! El registro No puede eliminarse');
            }
		}
        $this->dep('titulos_alumnos')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(escuela_ei_formulario $form)
	{
		if($this->dep('titulos_alumnos')->esta_cargada()){
			$form->set_datos($this->dep('titulos_alumnos')->get());
		}
	}
	function evt__form__modificacion($datos)
	{
		$this->dep('titulos_alumnos')->set($datos);
		$this->dep('registro_alumnos')->set($datos);		
	}

	function evt__cancelar()
	{
		$this->dep('titulos_alumnos')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo(){
		$this->set_pantalla('pant_edicion');
	}
	function evt__procesar(){
		$id_alumno = $this->dep('registro_alumnos')->get_columna('id_alumno');
		$this->dep('titulos_alumnos')->persistidor()->desactivar_transaccion(false);
		$this->dep('registro_alumnos')->persistidor()->desactivar_transaccion(false);
		toba::db()->abrir_transaccion();
		try {			
			$this->dep('titulos_alumnos')->sincronizar();
					
			//si el alumno tiene numero de registro uso el que tiene asignado
			if( !toba::consulta_php('alumnos')->tiene_nro_registro($id_alumno) ){
				$id_titulo = $this->dep('titulos_alumnos')->get_columna('id');
				$this->dep('registro_alumnos')->set_columna_valor('id_titulo',$id_titulo);
				$this->dep('registro_alumnos')->sincronizar();
			}
			$this->dep('registro_alumnos')->resetear();
			$this->dep('titulos_alumnos')->resetear();
			$this->set_pantalla("pant_inicial");	
			toba::db()->cerrar_transaccion();
		} catch (toba_error_db $e) {
			toba::notificacion()->error('Error al grabar!');
			toba::db()->abortar_transaccion();
		}
		
		//$this->dep('alumno')->set_columna_valor('nro_registro',);
	}
	function get_nro_registro($id_alumno){
		if( toba::consulta_php('alumnos')->tiene_nro_registro($id_alumno) ){
			return toba::consulta_php('alumnos')->get_nro_registro($id_alumno);
		}else{
			$nro_registro = toba::consulta_php('alumnos')->get_ultimo_nro_registro() +1;
			return $nro_registro;
		}
	}
	function get_anio_registro($id_alumno){
		if( toba::consulta_php('alumnos')->tiene_nro_registro($id_alumno) ){
			return toba::consulta_php('alumnos')->get_anio_registro($id_alumno);
		}else{
			return date("Y");			
		}
	}

	function extender_objeto_js(){
		if($this->get_id_pantalla()=='pant_edicion'){
			echo "
				$('#cont_ef_form_2679_formnro_registro').append(' - ');
				$('#cont_ef_form_2679_formnro_registro').append($('#ef_form_2679_formanio_registro'));
				$('#nodo_ef_form_2679_formanio_registro').hide();
			";
		}
	}
}
?>
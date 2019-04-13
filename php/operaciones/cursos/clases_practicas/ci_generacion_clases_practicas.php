<?php
class ci_generacion_clases_practicas extends escuela_ci
{
	protected $id_clase;
	protected $id_calendario;	//para levantar los datos de la clase del calendario semanal

	function set_clase($id_clase){
		$this->id_clase = $id_clase;
	}

	function set_calendario($id_calendario){
		$this->id_calendario = $id_calendario;
	}
	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}
	function resetear(){
		$this->relacion()->resetear();
	}
	function validar(){		
		//cantidad de profesores y alumnos
		if( ($this->tabla('profesores')->get_cantidad_filas()==0) || ($this->tabla('alumnos')->get_cantidad_filas()==0) ){						
			toba::notificacion()->error('Se debe cargar al menos un profesor y un alumno');
			return false;
		}		
		
		//superposicion de clases de un profesor
		$profesores = $this->tabla('profesores')->get_filas();
		$clase = $this->tabla('clase')->get();
		if( $this->solapa_profesor($profesores[0]['id_profesor'], $clase['fecha'], $clase['hora_inicio'], $clase['hora_fin']) ){
			toba::notificacion()->error('Existe solapamiento de horario en la clase para el profesor');
			return false;
		}
		return true;		
	}
	function solapa_profesor($id_profesor, $fecha, $hora_inicio, $hora_fin){
		//si es esdicion no comparo contra si mismo		
		$where_id_clase = ($this->relacion()->esta_cargada()) ? "and id_clase_practica<>".$this->tabla('clase')->get_columna('id') : "";
		$datos = toba::consulta_php('comunes')->get_generico('v_clases_practicas_profesores',"id_profesor=$id_profesor and fecha='$fecha' and hora_inicio<'$hora_fin' AND hora_fin>'$hora_inicio' $where_id_clase");
		return (count($datos)>0);
	}
	function guardar(){
		try {
			if($this->validar())
				$this->relacion()->sincronizar();
			else
				throw new toba_error_usuario("Existen errores");				
		} catch (toba_error_db $e) {
			toba::notificacion()->error('Error al guardar');
		}
	}
	
	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(escuela_ei_formulario $form)
	{
		if( $this->tabla('clase')->esta_cargada() ){
			return $this->tabla('clase')->get();
		}else{
			if(isset($this->id_calendario)){		//traigo los datos del calendario
				$datos = toba::consulta_php('cursos')->get_calendario_clases_practicas("id=".$this->id_calendario);
				return $datos[0];
			}
		}
	}

	function evt__form__modificacion($datos)
	{
		$this->tabla('clase')->set($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_alumnos --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_alumnos(escuela_ei_formulario_ml $form_ml)
	{
		if( $this->tabla('alumnos')->esta_cargada() ){
			return $this->tabla('alumnos')->get_filas();
		}
	}

	function evt__form_ml_alumnos__modificacion($datos)
	{
		$this->tabla('alumnos')->procesar_filas($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml_profesores -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml_profesores(escuela_ei_formulario_ml $form_ml)
	{
		if( $this->tabla('profesores')->esta_cargada() ){
			return $this->tabla('profesores')->get_filas();
		}
	}

	function evt__form_ml_profesores__modificacion($datos)
	{
		$this->tabla('profesores')->procesar_filas($datos);
	}

	function extender_objeto_js(){
		echo "

		{$this->objeto_js}.validar = function(){
			var cant_profesores = {$this->dep('form_ml_profesores')->objeto_js}.filas().length;
			var cant_alumnos = {$this->dep('form_ml_alumnos')->objeto_js}.filas().length;
			console.log(cant_profesores);
			if(cant_profesores>0 && cant_alumnos>0 ){
				return true;
			}else{
				if(cant_profesores==0){
					notificacion.agregar('Debe agregar al menos un profesor');	
				}
				if(cant_alumnos==0){
					notificacion.agregar('Debe agregar al menos un alumno');	
				}
				notificacion.mostrar();
				notificacion.limpiar();
				return false;
			}
		}

		";
	}


}
?>
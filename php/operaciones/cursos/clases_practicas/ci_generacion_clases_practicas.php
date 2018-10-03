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
		if( ($this->tabla('profesores')->get_cantidad_filas()>0) && ($this->tabla('alumnos')->get_cantidad_filas()>0) )
			return true;
		return false;
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
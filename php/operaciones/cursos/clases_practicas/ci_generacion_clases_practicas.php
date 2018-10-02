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

	function guardar(){
		try {
			$this->relacion()->sincronizar();
		} catch (toba_error_db $e) {
			toba::notificacion()->error('Error al guardar');
		}
	}

	function resetear(){
		$this->relacion()->resetear();
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


}
?>
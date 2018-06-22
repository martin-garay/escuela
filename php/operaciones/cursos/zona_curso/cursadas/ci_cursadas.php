<?php
class ci_cursadas extends escuela_ci
{
	protected $s__filtro;

	function ini()
	{
		toba::consulta_php('comunes')->chequeo_zona_cursos();
		if(toba::zona()->cargada()){
			$curso = array('id'=>toba::zona()->get_editable_id());
		}
	}
	//-----------------------------------------------------------------------------------
	//---- eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__procesar(){
		$this->dep('datos_cursada')->guardar();
	}

	function evt__cancelar()
	{
		$this->dep('datos_curso')->resetear();		//deshago las modificaciones y vuevo a cargar	
		if(toba::zona()->cargada()){
			$curso = array('id'=>toba::zona()->get_editable_id());			
			$this->dep('datos_curso')->cargar($curso);			
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
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		return toba::zona()->get_cursadas();
	}
	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('datos_cursada')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	function evt__cuadro__eliminar($seleccion)
	{
		try{
			$this->relacion()->cargar($seleccion);
			$this->relacion()->eliminar_todo();
			$this->relacion()->sincronizar();
		}catch(toba_error_db $e){
			if($e->get_sqlstate()=="db_23503"){
				toba::notificacion()->agregar('ATENCION! El registro esta siendo utilizado');
			}else{
				toba::notificacion()->agregar('ERROR! El registro No puede eliminarse');
			}
		}
		$this->relacion()->resetear();
	}
}
?>
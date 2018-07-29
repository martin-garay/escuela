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
		$this->dep('datos_cursada')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->dep('datos_cursada')->resetear();		//deshago las modificaciones y vuevo a cargar	
		$this->set_pantalla('pant_inicial');
	}
	function evt__nuevo(){		
		$this->dep('datos_cursada')->set_curso(toba::zona()->get_editable_id()); //le paso el id del curso al ci hijo
		$this->set_pantalla('pant_edicion');
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
		//si es un profesor traigo solamente las cursadas de este, sino muestro todas las cursadas
		$where = (isset($this->s__filtro)) ? $this->dep('filtro')->get_sql_where() : null;
		if(toba::consulta_php('comunes')->tiene_perfil('profesor')){						
			$datos = toba::zona()->get_cursadas_profesor($where);
		}else{			
			$datos = toba::zona()->get_cursadas($where);
		}
		$cuadro->set_datos($datos);		
	}
	function evt__cuadro__seleccion($seleccion)
	{
		$this->dep('datos_cursada')->cargar($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	function evt__cuadro__eliminar($seleccion)
	{
		$this->dep('datos_cursada')->borrar($seleccion);
	}
}
?>
<?php
class ci_inscripcion extends escuela_ci
{
	protected $s__datos_filtro;
	protected $id_cursada;
	protected $id_curso;
	protected $modulo_inicio;

	function tabla($nombre){
		return $this->dep('relacion')->tabla($nombre);
	}
	function relacion(){
		return $this->dep('relacion');
	}

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
		$this->dep('datos')->cargar($seleccion);
		$this->set_pantalla("pant_edicion");
	}

	function evt__cuadro__eliminar($seleccion)
	{
		$this->dep('datos')->cargar($seleccion);
		try{
            $this->dep('datos')->eliminar_todo();
            $this->dep('datos')->sincronizar();
		}catch(toba_error_db $e){
			if($e->get_sqlstate()=="db_23503"){
				toba::notificacion()->agregar('ATENCION! El registro esta siendo utilizado');
            }else{
				toba::notificacion()->agregar('ERROR! El registro No puede eliminarse');
            }
		}
        $this->dep('datos')->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(escuela_ei_formulario $form)
	{		
		if( $this->tabla('cursadas_alumnos')->get_cantidad_filas()>0 ){		//esta_cargada no andaba ni pa atras
			$form->set_datos($this->tabla('cursadas_alumnos')->get());
		}
		if($form->ef('id_cursada')->tiene_estado())
				$this->id_cursada = $form->ef('id_cursada')->get_estado();
		if($form->ef('id_curso')->tiene_estado())
				$this->id_curso = $form->ef('id_curso')->get_estado();
		if($form->ef('modulo_inicio')->tiene_estado())
				$this->modulo_inicio = $form->ef('modulo_inicio')->get_estado();
	}
	function evt__form__modificacion($datos)
	{
		$this->tabla('cursadas_alumnos')->set($datos);		
	}

	//-----------------------------------------------------------------------------------
	//---- form_ml ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_ml(escuela_ei_formulario_ml $form_ml)
	{
		/* Si se esta dando de alta creo tantas filas como modulos tenga la cursada. 
		Si empieza en el primer modulo lleno con todos los modulos, sino con los modulos de la cursada empezando en el 
		modulo_inicio y las demas filas las llena el usuario eligiendo en que cursada debe hacer los modulos iniciales que 
		no hizo.*/		
		if($this->tabla('cursadas_modulos_alumnos')->esta_cargada()){
			return $this->tabla('cursadas_modulos_alumnos')->get_filas();
		}else{
			if(isset($this->id_cursada) && isset($this->modulo_inicio)){
				return $this->get_modulos_alta_inscripcion($this->id_cursada);  //traigo los modulos solo en el alta, no en la modificacion
			}	
		}
		
	}

	function evt__form_ml__modificacion($datos)
	{
		$this->tabla('cursadas_modulos_alumnos')->procesar_filas($datos);
	}


	function evt__cancelar()
	{
		$this->relacion()->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo(){
		$this->set_pantalla('pant_edicion');
	}
	function evt__procesar(){
		$this->relacion()->sincronizar();
		$this->relacion()->resetear();
		$this->set_pantalla("pant_inicial");
	}
	function get_modulos_vigentes_de_cursada($id_cursada){
		return toba::consulta_php('cursos')->get_modulos_cursadas("id_cursada=$id_cursada and modulo_vigente");
	}
	function get_modulos_vigentes(){
		
		if(isset($this->id_curso)){
			$datos = toba::consulta_php('cursos')->get_modulos_cursadas("id_curso={$this->id_curso} and modulo_vigente", "id_cursada,periodo asc");
			foreach ($datos as $key => $fila) {
				$datos[$key]['descripcion2'] = $fila['nombre'] . ' (' .$fila['cursada'] . ')';
			}	
			return $datos;
		}else{
			return null;
		}
		
	}
	function get_modulos_alta_inscripcion($id_cursada){
		$sql = "SELECT case when modulo_vigente then id else null end as id_modulo,
					'A' as apex_ei_analisis_fila
					FROM (	select 1 as orden1,* from v_cursadas_modulos where modulo_vigente and id_cursada=$id_cursada
							UNION
							select 2 as orden1,* from v_cursadas_modulos where not modulo_vigente and id_cursada=$id_cursada)  as s 
					order by orden1,orden";
			return toba::db()->consultar($sql);
	}
}
?>
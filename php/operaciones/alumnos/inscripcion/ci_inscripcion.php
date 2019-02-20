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
	function es_edicion(){
		return $this->relacion()->esta_cargada();
	}

	function limpiar_variables(){
		unset($id_cursada);
		unset($id_curso);
		unset($modulo_inicio);		
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
		$this->relacion()->cargar($seleccion);
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
			//ei_arbol($this->tabla('cursadas_alumnos')->get());
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
			//if(isset($this->id_cursada) && isset($this->modulo_inicio)){
			//if($this->tabla('cursadas_alumnos')->esta_cargada()){
			if( $this->tabla('cursadas_alumnos')->get_cantidad_filas()>0 ){
				$cursadas_alumnos = $this->tabla('cursadas_alumnos')->get();
				$id_alumno = $cursadas_alumnos['id_alumno'];
				$modulo = toba::consulta_php('cursos')->get_modulos_cursadas("id=".$this->modulo_inicio);
				$nro_modulo_inicio = $modulo[0]['nro_modulo'];
				return $this->get_modulos_alta_inscripcion($this->id_cursada,$nro_modulo_inicio, $id_alumno);  //traigo los modulos solo en el alta, no en la 
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
		$this->limpiar_variables();
		$this->set_pantalla('pant_edicion');
	}
	function evt__procesar(){
		$this->relacion()->sincronizar();
		$this->relacion()->resetear();
		$this->set_pantalla("pant_inicial");
	}
	function get_modulos_vigentes_de_cursada($id_cursada){
		return toba::consulta_php('cursos')->get_modulos_cursadas("id_cursada=$id_cursada /*and modulo_vigente*/"); //comento "and modulo_vigente" para la carga inicial
	}
	//comento "and modulo_vigente" para la carga inicial
	function get_modulos_vigentes(){
		
		if(isset($this->id_curso)){
			$datos = toba::consulta_php('cursos')->get_modulos_cursadas("id_curso={$this->id_curso} /*and modulo_vigente*/", "id_cursada,periodo asc");
			foreach ($datos as $key => $fila) {
				$datos[$key]['descripcion2'] = $fila['nombre_mes'] . ' (' .$fila['cursada'] . ' - '.$fila['sede'].')';
			}	
			return $datos;
		}else{
			return null;
		}
		
	}
	//DESCOMENTAR /*modulo_vigente and*/
	function get_modulos_alta_inscripcion($id_cursada, $nro_modulo_inicio, $id_alumno){
		$datos_cursada = toba::consulta_php('cursos')->get_cursadas("id=$id_cursada");
		$id_curso = $datos_cursada[0]['id_curso'];
		$id_sede = $datos_cursada[0]['id_sede'];
		$id_tipo_cursada = $datos_cursada[0]['id_tipo_cursada'];
		$limit = (isset($datos_cursada[0]['cant_modulos'])) ? ' LIMIT '.$datos_cursada[0]['cant_modulos'] : '';
		
		$sql = "SELECT $id_alumno as id_alumno,
				case when modulo_vigente then id else id end as id_modulo,/*case when modulo_vigente then id else null end as id_modulo,*/
				'A' as apex_ei_analisis_fila
				FROM (	select 1 as orden1,* from v_cursadas_modulos where /*modulo_vigente and*/ id_cursada=$id_cursada and nro_modulo>=$nro_modulo_inicio
					UNION
					/* modulos vigentes de otras cursadas del mismo curso y en la misma sede */	
					select 2 as orden1,* from v_cursadas_modulos cm 
					where /*modulo_vigente and*/ id_cursada<>$id_cursada and id_curso=$id_curso and id_sede=$id_sede and id_tipo_cursada=$id_tipo_cursada
				)  as s 
				order by orden1,orden $limit";


		$modulo_inicio = toba::consulta_php('cursos')->get_modulos_cursadas("id_cursada=$id_cursada AND nro_modulo=$nro_modulo_inicio")[0];
		$sql = "SELECT $id_alumno as id_alumno,id as id_modulo,'A' as apex_ei_analisis_fila
				from v_cursadas_modulos 
				where periodo>='$modulo_inicio[periodo]' and id_curso=$id_curso and id_sede=$id_sede and id_tipo_cursada=$id_tipo_cursada
				ORDER BY periodo ASC
				$limit";
		return toba::db()->consultar($sql);
	}


	//para llenar el combo con las sedes. 
	function get_cascada_sedes_dictan_curso($id_curso){
		if( $this->es_edicion() ){
			$id_sede = $this->tabla('cursadas_alumnos')->get_columna('id_sede');
			$sql = "SELECT id ,nombre as descripcion from sedes";
		}else{		//Trae las sedes donde se dicta el curso
			$sql = "SELECT distinct(id_sede) as id,sede as descripcion from v_cursadas where id_curso = $id_curso";
		}		
		return toba::db()->consultar($sql);
	}	
}
?>
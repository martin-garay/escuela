<?php
#$this->get_parametro('a') => tabla
#$this->get_parametro('b') => order by
#$this->get_parametro('c') => vista para cargar el cuadro , si no se pasa se toma 'a'
class ci_horas_profesores extends escuela_ci
{
	protected $s__datos_filtro;

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
		if(isset($this->s__datos_filtro)){
			//ei_arbol($this->s__datos_filtro);
			$where = " WHERE ".$this->dep('filtro')->get_sql_where();
			$sql = "SELECT *,apellido||' '||nombre as apellido_nombre FROM 
					(SELECT 'PRACTICA' as tipo_clase,id_sede,sede,id_profesor,nombre,apellido,dni,sum(horas) as horas
					from v_clases_practicas_profesores 
					$where GROUP BY id_sede,sede,id_profesor,nombre,apellido,dni
					UNION
					SELECT 'TEORICA' as tipo_clase,id_sede,sede,id_profesor,nombre,apellido,dni,sum(horas) as horas 
					from v_clases_teoricas_profesores 
					$where GROUP BY id_sede,sede,id_profesor,nombre,apellido,dni) as s";
			$datos = toba::consulta_php('comunes')->get_generico_sql($sql,null,"sede,apellido,nombre,tipo_clase");
			$cuadro->set_datos($datos);

			//agrego descripcion al titulo
			if(count($datos)>0)
				$cuadro->set_titulo('Listado. '.$this->descripcion_fecha());
		}

	}	
	
	function descripcion_fecha(){
		
		switch ($this->s__datos_filtro['fecha']['condicion']) {
			case 'entre':
				$fecha_desde = date('d-m-Y', strtotime($this->s__datos_filtro['fecha']['valor']['desde']));
				$fecha_hasta = date('d-m-Y', strtotime($this->s__datos_filtro['fecha']['valor']['hasta']));
				$descripcion = "Fecha entre $fecha_desde y $fecha_hasta";
				break;
			case 'desde':
				$fecha_desde = date('d-m-Y', strtotime($this->s__datos_filtro['fecha']['valor']));
				$descripcion = "Fecha desde $fecha_desde";
				break;
			case 'hasta':
				$fecha_hasta = date('d-m-Y', strtotime($this->s__datos_filtro['fecha']['valor']));
				$descripcion = "Fecha hasta $fecha_hasta";
				break;
			case 'es_distinto_de':
				$fecha = date('d-m-Y', strtotime($this->s__datos_filtro['fecha']['valor']));
				$descripcion = "Fecha distinto de $fecha";
				break;			
		}
		return $descripcion;
	}

}
?>
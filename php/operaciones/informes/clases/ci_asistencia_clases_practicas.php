<?php
class ci_asistencia_clases_practicas extends escuela_ci
{
	protected $s__seleccion;
	protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__filtro)){
			$filtro->set_datos($this->s__filtro);
		}
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
		if(isset($this->s__filtro)){
			$where_tipo_persona = '';
			$clausulas=$this->dep('filtro')->get_sql_clausulas();

			if( isset($this->s__filtro['id_tipo_persona']) ){			
				unset($clausulas['id_tipo_persona']);	//borro para no incluirla en el where y armo la clausula propia
				$id_tipo_persona = $this->s__filtro['id_tipo_persona']['valor'];
				$where_tipo_persona = " AND id_alumno IN (SELECT id_persona FROM personas_tipo WHERE id_tipo_persona=$id_tipo_persona)";
			}
			$where =  $this->dep('filtro')->get_sql_where("AND",$clausulas) . $where_tipo_persona;
			return toba::consulta_php('cursos')->get_clases_practicas_alumnos($where,"anio_clase,mes_clase DESC");
		}		
	}

	function evt__cuadro__seleccion($seleccion)
	{
	}

	function conf_evt__cuadro__seleccion(toba_evento_usuario $evento, $fila)
	{
	}

}

?>
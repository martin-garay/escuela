<?php 
include_once 'comunes.php';

class cursos extends comunes
{
	function get_cursos($where=null, $order_by=null){
		return $this->get_generico('cursos', $where, $order_by);
	}
	function get_cursadas($where=null, $order_by=null){
		return $this->get_generico('v_cursadas', $where, $order_by);
	}
	function get_clases($where=null, $order_by=null){
		return $this->get_generico('v_clases', $where, $order_by);
	}
	function get_tipo_profesor($where=null, $order_by=null){
		return $this->get_generico('tipo_profesor', $where, $order_by);	
	}
	function get_modulos_cursos($where=null, $order_by=null){
		return $this->get_generico('v_cursos_modulos',$where,$order_by);
	}
	/* Al crear una cursada se graba una copia de los modulos de su curso */
	function get_modulos_cursadas($where=null, $order_by=null){
		return $this->get_generico('v_cursadas_modulos',$where,$order_by);
	}
	function get_cascada_cursadas_curso($id_curso){
		return $this->get_cursadas("id_curso=$id_curso");
	}
	function get_cascada_cursadas_curso_sede($id_curso,$id_sede){
		return $this->get_cursadas("id_curso=$id_curso AND id_sede=$id_sede");
	}
	function get_cascada_cursadas_sede_curso($id_sede,$id_curso){ //por que en toba_editor no puedo poner orden a los parametros
		return $this->get_cursadas("id_curso=$id_curso AND id_sede=$id_sede");
	}
	function get_cascada_modulos_cursada($id_cursada){
		return $this->get_modulos_cursadas("id_cursada=$id_cursada");
	}
	function get_titulos($where=null, $order_by=null){
		return $this->get_generico("v_titulos", $where, $order_by);	
	}
	function get_tipo_titulo($where=null, $order_by=null){
		return $this->get_generico("tipo_titulo", $where, $order_by);	
	}
	//Trae las sedes donde se dicta el curso
	function get_cascada_sedes_dictan_curso($id_curso){
		$sql = "SELECT distinct(id_sede) as id,sede as descripcion from v_cursadas where id_curso = $id_curso";
		return toba::db()->consultar($sql);
	}
	function get_tipo_cursadas($where=null, $order_by=null){
		return $this->get_generico('tipo_cursada', $where, $order_by);
	}
	function get_cascada_cursos_sede($id_sede){
		$sql = "SELECT distinct(id_curso) as id, curso as descripcion 
				FROM v_cursadas c
				WHERE id_sede=$id_sede
				ORDER BY curso";
		return toba::db()->consultar($sql);
	}
	function existe_clase($modulo, $fecha, $hora_inicio, $hora_fin){
		$sql = "SELECT * FROM v_clases WHERE id_modulo=$id_modulo AND fecha=$fecha AND hora_inicio=$hora_inicio AND hora_fin=$hora_fin";
	}
	function get_alumnos_modulos($where=null, $order_by=null){
		return $this->get_generico('v_cursadas_modulos_alumnos',$where,$order_by);
	}
	//valida que la fecha este en el rango de fechas del modulo
	function validar_fecha_clase_en_modulo($id_modulo, $fecha){		
		$sql = "SELECT '$fecha' BETWEEN fecha_inicio AND fecha_fin as existe_fecha FROM v_cursadas_modulos WHERE id=$id_modulo";
		$datos = toba::db()->consultar($sql);
		return $datos[0]['existe_fecha'];		
	}

	/*clases practicas*/
	function get_tipos_clases_practicas($where=null, $order_by=null){
		return $this->get_generico('tipos_clases_practicas', $where, $order_by);	
	}
	function get_dias($where=null, $order_by=null){
		return $this->get_generico('dias', $where, $order_by);	
	}
	function get_rangos_horarios($where=null, $order_by=null){
		return $this->get_generico('v_rango_horario', $where, $order_by);	
	}
	function get_tipos_alumnos($where=null, $order_by=null){
		return $this->get_generico('tipos_alumnos', $where, $order_by);	
	}
	function get_calendario_semanal($id_sede, $html){
		$sql = "SELECT (select extract( hour from hora_desde)|| ' a '|| extract( hour from hora_hasta)) as rango_horario,
				lunes,martes,miercoles,jueves,viernes,sabado
				from 
				(SELECT *
				FROM  crosstab(
				   'select r.id,d.descripcion as dia,generar_string_clase_practica(d.id,r.id,$id_sede,$html)
				    from dias d cross join rango_horario r' 
				   ) AS ct (\"id_rango_horario\" integer, \"lunes\" text, \"martes\" text, \"miercoles\" text, \"jueves\" text, \"viernes\" text, \"sabado\" text)
				) as s
				inner join rango_horario rh ON rh.id=s.id_rango_horario
				order by id_rango_horario";
			return toba::db()->consultar($sql);
	}
	function get_calendario_clases_practicas($where=null, $order_by=null){
		return $this->get_generico('v_calendario_clases_practicas', $where, $order_by);	
	}
	function get_clases_practicas($where=null, $order_by=null){
		return $this->get_generico('v_clases_practicas', $where, $order_by);		
	}
	function get_cursadas_alumnos($where=null, $order_by=null){
		return $this->get_generico('v_cursadas_alumnos', $where, $order_by);		
	}
	//solo para alumnos del curso
	function get_asistencia_clases_teoricas($where=null, $order_by=null){
		return $this->get_generico('v_asistencia_clases_teoricas', $where, $order_by);		
	}
	//solo para alumnos del curso
	function get_asistencia_clases_practicas($where=null, $order_by=null){
		return $this->get_generico('v_asistencia_clases_practicas', $where, $order_by);		
	}
	//para alumnos del curso y practicantes
	function get_clases_practicas_alumnos($where=null, $order_by=null){
		return $this->get_generico('v_clases_practicas_alumnos', $where, $order_by);		
	}

}
?>
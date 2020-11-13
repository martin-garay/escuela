<?php 
include_once 'comunes.php';

class alumnos extends comunes
{
	function get_condiciones_alumno($where=null, $order_by=null){
		return $this->get_generico('condiciones_alumno',$where,$order_by);		
	}

	function get_clases($where=null, $order_by=null){
		return $this->get_generico('v_clases_alumnos',$where,$order_by);		
	}
	function get_alumnos_cursada($where=null, $order_by=null){
		return $this->get_generico('v_cursadas_alumnos',$where,$order_by);		
	}
	function get_numero_inscripcion($id_alumno, $id_cursada){
		$condicion_alumno = 2; //REGULAR
		$datos = $this->get_generico('cursadas_alumnos',"id_alumno=$id_alumno AND id_cursada=$id_cursada and id_condicion_alumno=$condicion_alumno");
		return $datos[0]['id'];
	}

	function get_nro_registro($id_alumno){
		$sql = "SELECT * FROM registro_alumnos WHERE id_alumno=$id_alumno";
		$datos = toba::db()->consultar($sql);
		return $datos[0]['nro_registro'];
	}
	function get_anio_registro($id_alumno){
		$sql = "SELECT * FROM registro_alumnos WHERE id_alumno=$id_alumno";
		$datos = toba::db()->consultar($sql);
		return $datos[0]['anio_registro'];
	}
	function get_registro($id_alumno){
		//$sql = "SELECT * FROM registro_alumnos WHERE id_alumno=$id_alumno";
		$datos = $this->get_generico('registro_alumnos',"id_alumno=$id_alumno");
		return (isset($datos)) ? $datos[0] : null;
	}
	function tiene_nro_registro($id_alumno){
		$sql = "SELECT * FROM registro_alumnos WHERE id_alumno=$id_alumno";
		$datos = toba::db()->consultar($sql);
		return (count($datos)>0);
	}
	function get_ultimo_nro_registro(){
		$sql = "SELECT nro_registro from ultimo_nro_registro";
		$datos = toba::db()->consultar($sql);
		return $datos[0]['nro_registro'];
	}
	function get_numeros_registros($where=null, $order_by=null){
		$sql = "SELECT r.*,
					p.nombre,p.apellido,p.dni,sede 
				FROM registro_alumnos r
				JOIN v_personas p ON r.id_alumno=p.id";
		return $this->get_generico_sql($sql, $where, $order_by);
	}
}
?>
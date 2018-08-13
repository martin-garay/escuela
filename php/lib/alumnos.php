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
}
?>
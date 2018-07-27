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
}
?>
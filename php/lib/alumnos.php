<?php 
include_once 'comunes.php';

class alumnos extends comunes
{
	function get_condiciones_alumno($where=null, $order_by=null){
		return $this->get_generico('condiciones_alumno',$where,$order_by);		
	}
}
?>
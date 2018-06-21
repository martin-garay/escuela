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

}
?>
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
		return $this->get_generico('cursos_modulos',$where,$order_by);
	}
	/* Al crear una cursada se graba una copia de los modulos de su curso */
	function get_modulos_cursadas($where=null, $order_by=null){
		return $this->get_generico('cursadas_modulos',$where,$order_by);
	}
}
?>
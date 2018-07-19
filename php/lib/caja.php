<?php 
include_once 'comunes.php';

class caja extends comunes
{
	function get_tipo_comprobantes($where=null,$order_by=null){
		return $this->get_generico('caja_tipo_comprobantes', $where, $order_by);
	}
	function get_tipo_operaciones($where=null,$order_by=null){
		return $this->get_generico('caja_tipo_operaciones', $where, $order_by);
	}
	function get_operaciones($where=null,$order_by=null){
		return $this->get_generico('caja_operaciones', $where, $order_by);
	}
	function get_cuentas($where=null,$order_by=null){
		return $this->get_generico('caja_cuentas', $where, $order_by);
	}
	function get_comprobates($where=null,$order_by=null){
		return $this->get_generico('v_caja_comprobantes', $where, $order_by);
	}
}
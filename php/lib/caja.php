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
	function get_medios_pagos($where=null,$order_by=null){
		return $this->get_generico('caja_medios_pagos', $where, $order_by);
	}
	function get_movimientos($where=null,$order_by=null){
		return $this->get_generico('v_caja_movimientos', $where, $order_by);
	}
	function get_tipos_titulares($where=null,$order_by=null){
		return $this->get_generico('caja_tipo_titulares', $where, $order_by);
	}
	function get_tipos_titulares_activos($where=null,$order_by=null){
		$where = (isset($where)) ? "activo AND $where" : "activo";
		return $this->get_tipos_titulares($where, $order_by);
	}
}
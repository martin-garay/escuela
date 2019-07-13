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
	function get_subcuentas($where=null,$order_by=null){
		return $this->get_generico('caja_subcuentas', $where, $order_by);
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
	function get_parametrizacion($id_comprobante, $id_medio_pago, $id_movimiento){
		$where = "id_comprobante=$id_comprobante and id_medio_pago=$id_medio_pago and id_movimiento=$id_movimiento";
		return $this->get_generico('v_caja_parametrizacion', $where);
	}
	function get_numero_nueva_operacion(){
		$operacion = $this->get_generico('caja_operaciones_diarias', null, 'numero_operacion DESC LIMIT 1');
		return ($operacion[0]['numero_operacion'] +1);
	}
	function get_comprobante($identificador){
		$identificador = trim($identificador);
		$comprobante = $this->get_generico('caja_comprobantes',"identificador='$identificador'");
		return $comprobante[0];
	}
	function get_id_comprobante($identificador){
		$comprobante = $this->get_comprobante($identificador);
		return $comprobante['id'];
	}
	function get_cascada_subcuentas_cuenta($id_cuenta){
		return $this->get_subcuentas("id_cuenta=$id_cuenta and activo", "descripcion");
	}
}
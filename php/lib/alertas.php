<?php 
include_once 'comunes.php';

class alertas extends comunes
{
	function get_alertas($where=null, $order_by=null){
		return $this->get_generico('v_alertas',$where,$order_by);
	}
	function get_tipo_alertas($where=null, $order_by=null){
		return $this->get_generico('tipo_alerta',$where,$order_by);
	}
	function get_nivel_alerta($where=null, $order_by=null){
		return $this->get_generico('nivel_alerta',$where,$order_by);
	}
}
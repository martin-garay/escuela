<?php
class cn_operaciones_diarias extends escuela_cn
{

	function grabar($datos){
		$parametrizaciones = toba::consulta_php('caja')->get_parametrizacion($datos['id_comprobante'],$datos['id_medio_pago'],$datos['id_movimiento']);
		foreach ($parametrizaciones as $key => $parametrizacion) {
			
		}
	}
	function get_ultimo_numero_operacion(){

	}
	function get_nuevo_numero_operacion(){
		return $this->get_ultimo_numero_operacion()+1;		
	}
}

?>
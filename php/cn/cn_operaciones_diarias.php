<?php
class cn_operaciones_diarias extends escuela_cn
{
	//param: id,id_comprobante,id_medio_pago,id_movimiento,id_cuenta,id_subcuenta,id_tipo_titular,signo,envia_sub_cta,impacta_original

	/*cod: 	id,fecha,id_movimiento,id_comprobante,id_sede,id_medio_pago,id_cuenta,id_subcuenta,id_tipo_titular,id_titular,importe,usuario,
			signo,fecha_operacion,periodo,id_inscripcion,numero_operacion */

	/*
	*@param $datos 
	*/
	function desactivar_transaccion(){
		$this->dep('datos')->persistidor()->desactivar_transaccion(true);
	}

	function grabar($datos){
		$numero_operacion = $this->get_nuevo_numero_operacion();
		$parametrizaciones = toba::consulta_php('caja')->get_parametrizacion($datos['id_comprobante'],$datos['id_medio_pago'],$datos['id_movimiento']);
		ei_arbol($parametrizaciones);
		foreach ($parametrizaciones as $key => $parametrizacion) {

			$cod['numero_operacion'] = $numero_operacion;

			//$cod['fecha'] = $datos['fecha'];
			$cod['id_sede'] = $datos['id_sede'];
			$cod['id_titular'] = $datos['id_titular'];
			$cod['importe'] = $datos['importe'];
			$cod['usuario'] = $datos['usuario'];
			$cod['fecha_operacion'] = $datos['fecha_operacion'];			
			$cod['id_inscripcion'] = $datos['id_inscripcion'];
			//$cod['id_periodo'] = $datos['id_periodo'];

			$cod['id_movimiento'] = $parametrizacion['id_movimiento'];
			$cod['id_comprobante'] = $parametrizacion['id_comprobante'];			
			$cod['id_medio_pago'] = $parametrizacion['id_medio_pago'];
			$cod['id_cuenta'] = $parametrizacion['id_cuenta'];
			$cod['id_subcuenta'] = $parametrizacion['id_subcuenta'];
			$cod['id_tipo_titular'] = $parametrizacion['id_tipo_titular'];			
			$cod['signo'] = $parametrizacion['signo'];

			$this->dep('datos')->set($cod);
            $this->dep('datos')->sincronizar();
            $this->dep('datos')->resetear();
		}
		return $numero_operacion;
	}
	function get_ultimo_numero_operacion(){
		$sql = "SELECT max(numero_operacion) as numero_operacion FROM caja_operaciones_diarias";
		$datos = toba::db()->consultar($sql);
		if(count($datos)>0)
			return $datos[0]['numero_operacion'];
		else
			return 1;
	}
	function get_nuevo_numero_operacion(){
		return $this->get_ultimo_numero_operacion()+1;		
	}
}

?>
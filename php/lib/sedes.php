<?php 
include_once 'comunes.php';

class sedes extends comunes
{
	function get_sedes($where=null, $order_by=null){
		return $this->get_generico('sedes',$where,$order_by);
	}	
	function get_alquiler_sede_detallado($where=null, $order_by=null){		
		return $this->get_generico('v_alquiler_cabecera', $where, $order_by);
	}
	function get_aulas($where=null, $order_by=null){
		return $this->get_generico('v_aulas', $where, $order_by);
	}
 	
 	//$fecha_hora_desde: 'YYYY-MM-DD hh24:mi'
	//$fecha_hora_hasta: 'YYYY-MM-DD hh24:mi'
	//$id_detalle_alquiler para no validar contra si mismo.	
	function superposicion_fecha_alquiler($id_aula,$fecha, $hora_desde,$hora_hasta,$id_detalle_alquiler=null){
		$where = (isset($id_detalle_alquiler)) ? " AND s.id<>$id_detalle_alquiler" : '';
		$sql = "SELECT s.*,a.nombre_sede,a.nombre as aula,fecha_alta,
				desde1::date as fecha_base, desde1::time as hora_desde_base, hasta1::time as hora_hasta_base
				FROM
				(SELECT 	id,
					id_aula,
					id_cabecera,
					to_timestamp(fecha||' '||hora_desde,'YYYY-MM-DD hh24:mi')::timestamp without time zone as desde1,
					to_timestamp(fecha||' '||hora_hasta,'YYYY-MM-DD hh24:mi')::timestamp without time zone as hasta1,
					to_timestamp('$fecha $hora_desde','YYYY-MM-DD hh24:mi')::timestamp without time zone as desde2,
					to_timestamp('$fecha $hora_hasta','YYYY-MM-DD hh24:mi')::timestamp without time zone as hasta2	
				FROM alquiler_sede_detalle 
				WHERE fecha='$fecha') as s
				LEFT JOIN v_aulas a ON a.id=s.id_aula
				LEFT JOIN alquiler_sede_cabecera c ON c.id=s.id_cabecera
				WHERE id_aula=3 AND
					/* validacion fecha */
					((desde1<=desde2 and hasta1>=hasta2) OR
					(desde1>desde2 and desde1<hasta2) OR/*(desde1 between desde2 and hasta2) OR*/
					(hasta1>desde2 and hasta1<hasta2))	/*(hasta1 between desde2 and hasta2))*/
					$where";
		return toba::db()->consultar($sql);
	}
	function get_tipo_pago_sede($where=null, $order_by=null){
		return $this->get_generico('tipo_pago_sede', $where, $order_by);
	}	
}
?>
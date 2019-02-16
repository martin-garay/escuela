<?php 
include_once 'comunes.php';

class liquidaciones extends comunes
{
	function get_liquidaciones($where=null, $order_by=null){
		$sql = "SELECT l.*,tl.descripcion as tipo_liquidacion 
				FROM con_liquidacion l
				LEFT JOIN tipos_liquidaciones tl ON tl.id=l.id_tipo_liquidacion";
		return $this->get_generico_sql($sql,$where,$order_by);
	}

	function get_clases_practicas_a_liquidar($where=null, $order_by=null){
		$where = (isset($where)) ? "$where AND not liquidada" : "not liquidada";
		return $this->get_generico('v_clases_practicas_profesores',$where,$order_by);
	}
	function liquidar_clases_practicas($ids_clases){
		$usuario = toba::usuario()->get_id();
		$tipo_liquidacion = 1; //liquidacion de clases practicas

		//grabo cabecera de la liquidacion
		$id_bloque = toba::cn('cn_operaciones_diarias')->get_nuevo_numero_bloque();
		$liquidacion = toba::db()->consultar("INSERT INTO con_liquidacion(usuario,id_tipo_liquidacion,id_bloque) VALUES ('$usuario',$tipo_liquidacion,$id_bloque) RETURNING id");
		$id_liquidacion = $liquidacion[0]['id'];

		//pongo las clases como liquidadas
		$ids_clases_str = implode(",", $ids_clases);
		toba::db()->ejecutar("UPDATE clases_practicas_profesores SET id_liquidacion=$id_liquidacion WHERE id IN ($ids_clases_str)");

		
		//grabo caja operaciones diarias
		$datos_cod['id_comprobante'] 	= 8;	//LIQUIDACION CLASES PRACTICAS
		$datos_cod['id_medio_pago'] 	= 5;	//CTA CTE
		$datos_cod['id_movimiento'] 	= 21;	//LIQUIDACION PROFESOR
		$datos_cod['fecha_operacion'] 	= date('Y-m-d');	//hoy
		$datos_cod['usuario'] 	= $usuario;	//usuario
		$datos_cod['periodo'] = date('Y').'-'.date('m').'-01';
		$datos_cod['id_bloque'] = $id_bloque;	//asocio toda la liquidacion en un bloque

		$sql = "SELECT id_profesor,sum(importe) as importe FROM v_clases_practicas_profesores WHERE id in ($ids_clases_str) GROUP BY id_profesor";
		$liquidaciones = toba::db()->consultar($sql);
		foreach ($liquidaciones as $key => $liquidacion) {
			$datos_cod['id_titular'] = $liquidacion['id_profesor'];
			$datos_cod['importe'] = $liquidacion['importe'];
			$numero_operacion = toba::cn('cn_operaciones_diarias')->grabar($datos_cod);
		}
		

	}

}
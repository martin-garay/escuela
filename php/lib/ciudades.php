<?php 
include_once 'comunes.php';

class ciudades extends comunes
{
	function get_ciudad_detallado($where=null, $order_by=null){
		$sql = "SELECT * FROM 
				(SELECT c.*, pr.nombre as provincia, pr.id_pais, p.nombre as pais
				FROM ciudades c 
				INNER JOIN provincias pr ON c.id_provincia=pr.id
				INNER JOIN paises p ON p.id=pr.id_pais) as s";
		return $this->get_generico_sql($sql, $where, $order_by);
	}
	function get_codigo_postal($id_ciudad){
		$datos = self::get_ciudad_detallado("id=$id_ciudad");
		return $datos[0]['cp'];
	}
	function get_provincia($id_ciudad){
		$datos = self::get_ciudad_detallado("id=$id_ciudad");
		return $datos[0]['provincia'];
	}
	function get_pais($id_ciudad){
		$datos = self::get_ciudad_detallado("id=$id_ciudad");
		return $datos[0]['pais'];
	}
}

?>
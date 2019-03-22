<?php 
include_once 'comunes.php';

class combo_editable extends comunes
{
	function get_alumnos($filtro){
		$sql = "SELECT id, dni||' '||apellido||' '||nombre as descripcion
				FROM v_personas WHERE es_alumno(id) AND dni||' '||apellido||' '||nombre ILIKE '%$filtro%' ";
		return toba::db()->consultar($sql);
	}
	function get_alumnos_descripcion($id){
		$sql = "SELECT dni||' '||apellido||' '||nombre as descripcion FROM v_personas WHERE id=$id";
        $datos = toba::db()->consultar($sql);
        return $datos[0]['descripcion'];
	}
	function get_ciudades($filtro){
        $sql = "SELECT id, nombre||' (CP: '||cp||')' as descripcion 
                FROM ciudades WHERE nombre||' (CP: '||cp||')' ILIKE '%$filtro%'";
        return toba::db()->consultar($sql);
	}
	function get_ciudades_descripcion($id_ciudad){
		$sql = "SELECT nombre||' (CP: '||cp||')' as descripcion FROM ciudades WHERE id=$id_ciudad";
        $datos = toba::db()->consultar($sql);
        return $datos[0]['descripcion'];
	}
	function get_profesores($filtro){
        $sql = "SELECT id, apellido||' '||nombre||' - '||dni as descripcion 
        		FROM v_personas WHERE es_profesor(id) AND apellido||' '||nombre||' - '||dni ILIKE '%$filtro%'";
        return toba::db()->consultar($sql);        
	}
	function get_profesores_descripcion($id_persona){
		$sql = "SELECT apellido||' '||nombre||' - '||dni as descripcion FROM v_personas WHERE id=$id_persona";
        $datos = toba::db()->consultar($sql);
        return $datos[0]['descripcion'];
	}
	function get_alumnos_y_practicantes($filtro){
		$sql = "SELECT id, dni||' '||apellido||' '||nombre as descripcion
				FROM v_personas WHERE ( es_alumno(id) OR es_practicante(id) ) AND dni||' '||apellido||' '||nombre ILIKE '%$filtro%' ";
		return toba::db()->consultar($sql);
	}
}
?>
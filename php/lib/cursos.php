<?php 
include_once 'comunes.php';

class cursos extends comunes
{
	function get_cursos($where=null, $order_by=null){
		return $this->get_generico('cursos', $where, $order_by);
	}
	function get_cursadas($where=null, $order_by=null){
		return $this->get_generico('v_cursadas', $where, $order_by);
	}
	function get_clases($where=null, $order_by=null){
		return $this->get_generico('v_clases', $where, $order_by);
	}
	function get_tipo_profesor($where=null, $order_by=null){
		return $this->get_generico('tipo_profesor', $where, $order_by);	
	}
	function get_modulos_cursos($where=null, $order_by=null){
		return $this->get_generico('v_cursos_modulos',$where,$order_by);
	}
	/* Al crear una cursada se graba una copia de los modulos de su curso */
	function get_modulos_cursadas($where=null, $order_by=null){
		return $this->get_generico('v_cursadas_modulos',$where,$order_by);
	}
	function get_cascada_cursadas_curso($id_curso){
		return $this->get_cursadas("id_curso=$id_curso");
	}
	function get_cascada_cursadas_curso_sede($id_curso,$id_sede){
		return $this->get_cursadas("id_curso=$id_curso");
	}
	function get_cascada_modulos_cursada($id_cursada){
		return $this->get_modulos_cursadas("id_cursada=$id_cursada");
	}
	function get_titulos($where=null, $order_by=null){
		return $this->get_generico("v_titulos", $where, $order_by);	
	}
	function get_tipo_titulo($where=null, $order_by=null){
		return $this->get_generico("tipo_titulo", $where, $order_by);	
	}
	//Trae las sedes donde se dicta el curso
	function get_cascada_sedes_dictan_curso($id_curso){
		$sql = "SELECT distinct(id_sede) as id,sede as descripcion from v_cursadas where id_curso = $id_curso";
		return toba::db()->consultar($sql);
	}
}
?>
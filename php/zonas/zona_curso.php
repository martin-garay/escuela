<?php
class zona_curso extends toba_zona
{
	function generar_html_barra_nombre() {
		echo "<script>
				$(document).ready(function(){
					$('#barra_superior').css('min-height','65px');
					$('.item-barra').css('margin-top','35px');
					$('.cuerpo').css('padding-top','40px');					
				});
			</script>";
		parent::generar_html_barra_nombre();
	}

	function cargar($id)
	{
		if (!isset($this->editable_info) || !isset($this->editable_id) || $id !== $this->editable_id) { 
			toba::logger()->debug("Cargando la zona '{$this->id}' con el editable '".var_export($id, true)."'"); 
			$this->editable_id = $id; 
			$this->cargar_info();
		}
	}

	function cargar_info(){
		$curso = toba::consulta_php('cursos')->get_cursos('id='.$this->editable_id);
		if(count($curso)>0){
			$this->editable_info = $curso[0];
		}
	}

	function get_info($clave = NULL)
	{
		return $this->editable_info; 
	}

	function get_editable_nombre()
	{
		return 'Curso: '.$this->editable_info['nombre'];	
	}

	function get_editable_id()
	{
		return $this->editable_id;
	}	

	function cargada()
	{
		return (isset($this->editable_id) && ($this->editable_id != ''));
	}

	function get_cursadas($where=null){		
		$where1 = "id_curso=".$this->get_editable_id();
		$where = (isset($where)) ? "$where1 AND $where " : $where1;
		return toba::consulta_php('cursos')->get_cursadas($where,'fecha_inicio DESC');
	}
	function get_cursadas_profesor($where=null){
		$id_profesor = toba::consulta_php('personas')->get_id(toba::usuario()->get_id());
		$where1 = "id_curso=".$this->get_editable_id(). " AND id IN (SELECT id_cursada FROM cursadas_profesores WHERE id_profesor=$id_profesor)";
		$where = (isset($where)) ? "$where1 AND $where " : $where1;
		return toba::consulta_php('cursos')->get_cursadas($where,'fecha_inicio DESC');
	}
	function get_clases($where=null, $order_by=null){
		$where = (isset($where)) ? "$where AND id_curso=".$this->get_editable_id() : "id_curso=".$this->get_editable_id();
		return toba::consulta_php('cursos')->get_clases($where,$order_by);
	}
}
?>

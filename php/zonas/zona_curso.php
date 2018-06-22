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

	function get_cursadas(){
		$where = "id_curso=".$this->get_editable_id();
		return toba::consulta_php('cursos')->get_cursadas($where,'fecha_inicio DESC');
	}		
}
?>

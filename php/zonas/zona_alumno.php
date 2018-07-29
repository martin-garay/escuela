<?php
class zona_alumno extends toba_zona
{
	const ALERTAS = '3556';

	function conf(){		
		if( count($this->get_alertas())==0 ) //si no hay alertas elimino la operacion
			$this->desactivar_item(self::ALERTAS);
	}
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
		$alumno = toba::consulta_php('personas')->get_personas('id='.$this->editable_id);
		if(count($alumno)){
			$this->editable_info = $alumno[0];
		}
	}

	function get_info($clave = NULL)
	{
		return $this->editable_info; 
	}

	function get_editable_nombre()
	{
		return 'Alumno: '.$this->editable_info['apellido'].' '.$this->editable_info['nombre'].' - '.$this->editable_info['dni'];	
	}

	function get_editable_id()
	{
		return $this->editable_id;
	}	

	function cargada()
	{
		return (isset($this->editable_id) && ($this->editable_id != ''));
	}

	function get_cursos(){

	}

	function get_cursos_vigentes(){

	}
	function get_clases(){
		return toba::consulta_php('alumnos')->get_clases("id_alumno=".$this->get_editable_id(),"fecha_clase,hora_inicio_clase");
	}
	function get_alertas(){
		return toba::consulta_php('alertas')->get_alertas_persona($this->get_editable_id());
	}

}
?>

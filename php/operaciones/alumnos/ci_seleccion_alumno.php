<?php
class ci_seleccion_alumno extends escuela_ci
{	
	function ini()
	{
		toba::memoria()->eliminar_dato('id_alumno');
		toba::zona()->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form__seleccion($datos)
	{
		toba::zona()->cargar($datos['id_alumno']);
		toba::memoria()->set_dato('id_alumno',$datos['id_alumno']);
	}

	function get_alumnos(){
		if( toba::consulta_php('comunes')->tiene_perfil('alumno') ){
			$usuario = toba::usuario()->get_id();
			return toba::consulta_php('personas')->get_personas("es_alumno(id) AND dni=$usuario",'apellido,nombre');	
		}
		return toba::consulta_php('personas')->get_personas('es_alumno(id)','apellido,nombre');
	}
		
    //-----------------------------------------------------------------------------------
    //---- js ---------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    function extender_objeto_js()
    {
    	if(toba::memoria()->existe_dato('id_alumno')){
			echo "
				zona = $('.zona-items').clone().attr('id', 'zona_centro');
				$('.cuerpo').append(zona);
				izq = $(window).width() / 2 - $('#zona_centro').width() / 2;
				$('#zona_centro').css({
				  'position':'absolute',
				  'margin-left':izq
				});
				$('#cuerpo_js_ci_2534').hide();

			";
		}
	}

}
?>
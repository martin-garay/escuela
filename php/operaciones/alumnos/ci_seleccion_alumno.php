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
		return toba::consulta_php('personas')->get_personas('id_tipo_persona=1','apellido,nombre');
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
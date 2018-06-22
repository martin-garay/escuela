<?php
class ci_seleccion_curso extends escuela_ci
{	
	function ini()
	{
		toba::memoria()->eliminar_dato('id_curso');
		toba::zona()->resetear();
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__form__seleccion($datos)
	{
		toba::zona()->cargar($datos['id']);
		toba::memoria()->set_dato('id_curso',$datos['id']);
	}

	function get_cursos(){
		if( toba::consulta_php('comunes')->tiene_perfil('alumno') ){
			$usuario = toba::usuario()->get_id();
			return toba::consulta_php('comunes')->get_generico("v_cursos_alumno",'curso');	
		}
		return toba::consulta_php('cursos')->get_cursos();
	}
		
    //-----------------------------------------------------------------------------------
    //---- js ---------------------------------------------------------------------------
    //-----------------------------------------------------------------------------------
    function extender_objeto_js()
    {
    	if(toba::memoria()->existe_dato('id_curso')){
			echo "
				zona = $('.zona-items').clone().attr('id', 'zona_centro');
				$('.cuerpo').append(zona);
				izq = $(window).width() / 2 - $('#zona_centro').width() / 2;
				$('#zona_centro').css({
				  'position':'absolute',
				  'margin-left':izq
				});
				//$('#cuerpo_js_form_18000462_form').hide();
				$('.ci-simple-cont').hide();

			";
		}
	}

}
?>
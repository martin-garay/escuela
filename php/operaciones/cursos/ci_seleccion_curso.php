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
		if( toba::consulta_php('comunes')->tiene_perfil('profesor') ){
			$usuario = toba::usuario()->get_id();
			$id_profesor = toba::consulta_php('personas')->get_id(toba::usuario()->get_id());
			$where = "id IN (select get_cursos_profesor($id_profesor))";
			return toba::consulta_php('cursos')->get_cursos($where);
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
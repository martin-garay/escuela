<?php
class form_js extends escuela_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.ef('nro_registro').ocultar();
		{$this->objeto_js}.ef('anio_registro').ocultar();

		$('#cont_ef_form_2679_formnro_registro').append(' - ');
		$('#cont_ef_form_2679_formnro_registro').append($('#ef_form_2679_formanio_registro'));
		$('#nodo_ef_form_2679_formanio_registro').hide();

		{$this->objeto_js}.evt__id_tipo_titulo__procesar = function(es_inicial)
		{
			if(this.ef('id_tipo_titulo').tiene_estado()){
				var id_tipo_titulo = this.ef('id_tipo_titulo').get_estado();
				if( id_tipo_titulo == 1){ //si es DIPLOMA lleva nro_registro
					this.ef('nro_registro').mostrar();
					this.ef('anio_registro').mostrar();
				}else{
					this.ef('nro_registro').ocultar();
					this.ef('anio_registro').ocultar();
				}
				$('#nodo_ef_form_2679_formanio_registro').hide();
			}
			
		}
		";
	}

}

?>
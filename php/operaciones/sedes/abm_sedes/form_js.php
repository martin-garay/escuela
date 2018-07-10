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
		
		{$this->objeto_js}.evt__paga_alquiler__procesar = function(es_inicial)
		{
			if(this.ef('paga_alquiler').chequeado()){
				this.ef('id_tipo_pago_sede').mostrar();
				this.ef('valor_hora').mostrar();
			}else{
				this.ef('id_tipo_pago_sede').ocultar();
				this.ef('valor_hora').ocultar();
			}
		}
		";
	}

}
?>
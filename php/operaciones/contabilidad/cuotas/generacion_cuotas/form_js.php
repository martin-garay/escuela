<?php
class form_js extends escuela_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Validacion de EFs -----------------------------------
		
		{$this->objeto_js}.evt__id_modulo__procesar = function(es_inicial)
		{
			if(!es_inicial){
				if(this.ef('id_modulo').tiene_estado()){
					
					this.controlador.set_evento(new evento_ei('modificacion',true,''));	
				}				
			}
		}
		";
	}

}

?>
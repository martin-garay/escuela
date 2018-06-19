<?php
class form extends escuela_ei_formulario
{
	
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		$form_ml = $this->controlador->dep('form_ml')->objeto_js;
		echo "		
		//---- Procesamiento de EFs --------------------------------		
		{$this->objeto_js}.evt__id_sede__procesar = function(es_inicial)
		{
			if(!es_inicial){
				this.set_evento(new evento_ei('modificacion',true,''));	
			}else if( !this.ef('id_sede').tiene_estado() ){
				{$this->objeto_js}.ef('descripcion').ocultar();
				{$this->objeto_js}.ef('anio').ocultar();
				{$this->objeto_js}.ef('mes').ocultar();
				{$this->objeto_js}.ef('id_estado_pago').ocultar();
				{$this->objeto_js}.ef('total').ocultar();		
				{$form_ml}.ocultar();									
			}			
		}
		";
	}

}
?>
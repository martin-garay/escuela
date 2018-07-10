<?php
class fom_js extends escuela_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__id_cursada__procesar = function(es_inicial)
		{

			if(!es_inicial){
				if(this.ef('id_cursada').tiene_estado() && this.ef('modulo_inicio').tiene_estado()){
					this.controlador.set_evento(new evento_ei('modificacion',true,''));	
				}				
			}
		}
		
		{$this->objeto_js}.evt__modulo_inicio__procesar = function(es_inicial)
		{
			if(!es_inicial){
				if(this.ef('id_cursada').tiene_estado() && this.ef('modulo_inicio').tiene_estado()){
					this.controlador.set_evento(new evento_ei('modificacion',true,''));	
				}				
			}
		}
		";
	}

}

?>
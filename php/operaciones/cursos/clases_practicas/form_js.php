<?php
class form_js extends escuela_ei_formulario
{

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		{$this->objeto_js}.ef('id_clase').ocultar();


		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__id_sede__procesar = function(es_inicial)
		{
			if(!es_inicial && this.ef('id_sede').tiene_estado()){
				this.set_evento(new evento_ei('modificacion',true,''));				
			}
		}
		";
	}

}

?>
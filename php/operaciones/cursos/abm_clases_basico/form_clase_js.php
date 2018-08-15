<?php
class form_clase_js extends escuela_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__id_modulo__procesar = function(es_inicial)
		{
			if(!es_inicial){
				this.validar_fecha_modulo();	
			}
		}
		
		{$this->objeto_js}.evt__fecha__procesar = function(es_inicial)
		{
			if(!es_inicial){
				this.validar_fecha_modulo();	
			}			
		}
		{$this->objeto_js}.validar_fecha_modulo = function(){
			if(this.ef('id_modulo').tiene_estado() && this.ef('fecha').tiene_estado()){
				var parametros = new Array(2);
				parametros[0] = this.ef('id_modulo').get_estado();
				parametros[1] = this.ef('fecha').get_estado();
				this.controlador.ajax('validar_fecha_modulo',parametros,this,this.respuesta)
			}
		}
		{$this->objeto_js}.respuesta = function(respuesta){
			if(!respuesta.ok){
				alert('La fecha ingresada se encuentra fuera del rango de fecha del Modulo');
			}
		}
		";
	}

}

?>
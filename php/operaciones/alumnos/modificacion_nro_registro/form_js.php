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
				
		{$this->controlador->objeto_js}.desactivar_boton('procesar');

		$(document).ready(function(){
			$('.dhx_combo_input').attr('disabled','disabled');	
		});
		
		//---- Procesamiento de EFs --------------------------------


		{$this->objeto_js}.evt__id_alumno__procesar = function(es_inicial)
		{
			//this.validar_duplicado();
		}
		
		{$this->objeto_js}.evt__nro_registro__procesar = function(es_inicial)
		{
			this.validar_duplicado();
		}
		
		{$this->objeto_js}.evt__anio_registro__procesar = function(es_inicial)
		{
			this.validar_duplicado();
		}

		{$this->objeto_js}.validar_duplicado = function(){
			if(this.ef('nro_registro').tiene_estado() && this.ef('anio_registro').tiene_estado()){
				var parametros = new Array(3);

				parametros[0] = this.ef('id_alumno').get_estado();
				parametros[1] = this.ef('anio_registro').get_estado();
				parametros[2] = this.ef('nro_registro').get_estado();

									
                this.controlador.ajax('validar_duplicado', parametros, this, this.respuesta);
			}
		}
		{$this->objeto_js}.respuesta = function(duplicado) { 
			var msj = '';
			console.log(duplicado);
			if( !duplicado ){
				msj = '<span style=\"color:green;\">OK. El Numero de registro no esta en uso</span>';
				{$this->controlador->objeto_js}.activar_boton('procesar');
			}else{
				msj = '<span style=\"color:red;\">ERROR. El Numero de registro esta en uso. <br>';
				msj += '<strong>' + duplicado.nombre + ' ' + duplicado.apellido + ' ' + duplicado.dni + '</strong><br>';
				msj += 'Debe cambiar el Nro de Registro antes continuar </span>';
				{$this->controlador->objeto_js}.desactivar_boton('procesar');
			}
			this.ef('control').set_estado(msj);			
				
		}
		";
	}


}
?>
<?php
class form_ml_js extends escuela_ei_formulario_ml
{	
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//calcula el total del alquiler en base al valor hora
		{$this->objeto_js}.calcular_total = function(){
			var filas = this.filas();
			var total = 0;
			for(id_fila in filas){
				if(this.ef('valor_hora').ir_a_fila(filas[id_fila]).tiene_estado()){
					var valor_hora = this.ef('valor_hora').ir_a_fila(filas[id_fila]).get_estado();
					var cant_horas = this.cantidad_horas(filas[id_fila]);
					total += valor_hora*cant_horas;	
				}				
			}
			js_form_2558_form.ef('total').set_estado(total);
		}
		{$this->objeto_js}.cantidad_horas = function(fila){
			if(this.ef('fecha').tiene_estado() && this.ef('hora_desde').tiene_estado() && this.ef('hora_hasta').tiene_estado() ){
				var fecha = this.ef('fecha').ir_a_fila(fila).fecha();
				var hora_desde = this.ef('hora_desde').ir_a_fila(fila).get_estado();
				var hora_hasta = this.ef('hora_hasta').ir_a_fila(fila).get_estado();

				var str_fecha_hora_desde = fecha.getYear()+'/'+fecha.getMonth()+'/'+fecha.getDate()+' '+hora_desde+':00';
				var str_fecha_hora_hasta = fecha.getYear()+'/'+fecha.getMonth()+'/'+fecha.getDate()+' '+hora_hasta+':00';
				
				var fecha_hora_desde = new Date(str_fecha_hora_desde);
				var fecha_hora_hasta = new Date(str_fecha_hora_hasta);			

				var diff = fecha_hora_hasta - fecha_hora_desde;				
				var horas = diff/(1000*60*60);						//tranformo de miliseg a horas
				console.log('Horas diferencia :'+horas);
				return horas;
			}else{
				return false;
			}
		}

		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__hora_desde__procesar = function(es_inicial, fila)
		{
			if(!es_inicial){
				this.calcular_total();
			}
		}
		
		{$this->objeto_js}.evt__hora_hasta__procesar = function(es_inicial, fila)
		{
			if(!es_inicial){
				this.calcular_total();
			}
		}
		
		{$this->objeto_js}.evt__valor_hora__procesar = function(es_inicial, fila)
		{
			if(!es_inicial){
				this.calcular_total();
			}
		}
		";
	}

}
?>
<?php
class ci_test_cuadro_calendario extends escuela_ci
{
	protected $s__form;

	function conf(){
		if( !$this->selecciono_sede() ){
			$this->evento('exportar_excel')->ocultar();
			$this->evento('exportar_pdf')->ocultar();			
		}
		if( !$this->selecciono_clase() ){
			$this->evento('generar_clase')->ocultar();
		}
	}
	function selecciono_sede(){
		return isset($this->s__form['id_sede']);
	}
	function selecciono_clase(){
		return $this->dep('calendario')->esta_cargada();
	}

	function evt__generar_clase(){
		$calendario = $this->dep('calendario')->get();
		$this->dep('generacion_clase')->set_calendario($calendario['id']);
		$this->set_pantalla('pant_edicion');
	}
	function evt__guardar(){
		$this->dep('generacion_clase')->guardar();
		toba::notificacion()->info("Se genero la clase");
		$this->dep('generacion_clase')->resetear();
		$this->set_pantalla('pant_inicial');
	}
	function evt__volver(){
		$this->dep('generacion_clase')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(form_js $form)
	{
		if(isset($this->s__form))
			return $this->s__form;
	}

	function evt__form__modificacion($datos)
	{
		$this->s__form = $datos;
		if(isset($datos['id_clase'])){
			$this->dep('calendario')->cargar(array('id'=>$datos['id_clase']));
		}else{
			if($this->dep('calendario')->esta_cargada()){
				$this->dep('calendario')->resetear();
			}
		}
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(escuela_ei_cuadro $cuadro)
	{
		if(isset($this->s__form)){
			$id_sede = $this->s__form['id_sede'];
			$calendario = toba::consulta_php('cursos')->get_calendario_semanal($id_sede, 'true');	//con html
			$cuadro->set_datos($calendario);
		}		
	}
	//-----------------------------------------------------------------------------------
	//---- form_abm ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_abm(escuela_ei_formulario $form)
	{
		if($this->dep('calendario')->esta_cargada())
			return $this->dep('calendario')->get();
	}

	function evt__form_abm__alta($datos)
	{
		$this->dep('calendario')->set($datos);
		$this->dep('calendario')->sincronizar();
		$this->dep('calendario')->resetear();
	}

	function evt__form_abm__baja()
	{
		$this->dep('calendario')->eliminar_todo();
		$this->dep('calendario')->sincronizar();
		$this->dep('calendario')->resetear();
	}

	function evt__form_abm__modificacion($datos)
	{
		$this->dep('calendario')->set($datos);
		$this->dep('calendario')->sincronizar();
		$this->dep('calendario')->resetear();	
	}

	function evt__form_abm__cancelar()
	{
		$this->dep('calendario')->resetear();
	}

	function vista_excel(toba_vista_excel $salida){
        ob_clean();
        $id_sede = $this->s__form['id_sede'];
        
        //configuracion general
        $salida->get_excel()->getActiveSheet()->getDefaultColumnDimension()->setWidth(25);
		$salida->get_excel()->getActiveSheet()->getDefaultRowDimension()->setRowHeight(35);
		$salida->get_excel()->getDefaultStyle()->getAlignment()->setWrapText(true);
		$salida->get_excel()->getDefaultStyle()->getFont()->setName('Arial');
		$salida->get_excel()->getDefaultStyle()->getFont()->setSize(10);

        $sede = toba::consulta_php('sedes')->get_sedes("id=$id_sede");
        $salida->titulo("HARI OM INTERNACIONAL ESCUELA DE YOGA Y AYURVEDA",7);
        $salida->titulo("Clases Practicas y Meditaciones - Sede ".$sede[0]['nombre'],7);
        //$salida->texto("Clases Practicas y Meditaciones - Sede ".$sede[0]['nombre'],array(),7);
        $titulo_tabla = array_column($this->dep('cuadro')->get_columnas(),"titulo");

        $calendario = toba::consulta_php('cursos')->get_calendario_semanal($id_sede, 'false'); //no tiene html   
        $datos_tabla = $calendario;
        $salida->tabla($datos_tabla,$titulo_tabla);                                
     
        $salida->set_hoja_nombre('Calendario');
        $salida->set_nombre_archivo('calendario'.$sede[0]['nombre'].'.xls');        
    }
	function vista_pdf(toba_vista_pdf $salida){
        ob_clean();
        $id_sede = $this->s__form['id_sede'];
        $sede = toba::consulta_php('sedes')->get_sedes("id=$id_sede");
        $salida->titulo("HARI OM INTERNACIONAL ESCUELA DE YOGA Y AYURVEDA");
        $salida->titulo("Clases Practicas y Meditaciones - Sede ".$sede[0]['nombre']);

        //copio el cuadro para usar su vista_excel para sacar la exportacion sin el thml
        $cuadro_aux = clone($this->dep('cuadro'));
        $calendario = toba::consulta_php('cursos')->get_calendario_semanal($id_sede, 'false'); //no tiene html
        $cuadro_aux->set_datos($calendario);
        $cuadro_aux->vista_pdf($salida);
        unset($cuadro_aux);	

        $salida->set_nombre_archivo('calendario'.$sede[0]['nombre'].'.pdf');        
    }


	function extender_objeto_js(){
		if($this->get_id_pantalla()=='pant_inicial'){
			if( $this->selecciono_sede() ){
				echo "{$this->dep('form_abm')->objeto_js}.mostrar();";
			}else{
				echo "{$this->dep('form_abm')->objeto_js}.ocultar();";
			}

			if( $this->selecciono_clase() ){
				//echo "document.getElementById('cuerpo_js_form_2731_form_abm').scrollIntoView();";
				echo "$('html, body').animate({
					        scrollTop: $('#cuerpo_js_form_2731_form_abm').offset().top
					  }, 1500);";
			}

			echo "
			$(document).ready(function(){

				//Eventos
				$('.clase_practica').click(function(){
					{$this->dep('form')->objeto_js}.ef('id_clase').set_estado($(this).attr('id'));
					{$this->dep('form')->objeto_js}.set_evento(new evento_ei('modificacion',true,''));
				});

				//CSS
				$('.clase_practica').css({'cursor':'pointer'});
				$('.clase_practica').hover( function(){ $(this).css('color','red');} , function(){ $(this).css('color','black');});
				$('#cuerpo_js_form_2731_form_abm').css('background-color','rgb(194, 194, 194)');
			});

			";	
		}
		
	}

	/*
	function vista_excel_asdasd(toba_vista_excel $salida){
        ob_clean();
        $id_sede = $this->s__form['id_sede'];

        $sede = toba::consulta_php('sedes')->get_sedes("id=$id_sede");
        $salida->titulo("HARI OM INTERNACIONAL ESCUELA DE YOGA Y AYURVEDA",7);
        $salida->texto("Clases Practicas y Meditaciones - Sede ".$sede[0]['nombre'],7);

        //copio el cuadro para usar su vista_excel para sacar la exportacion sin el thml
        $cuadro_aux = clone($this->dep('cuadro'));
        $calendario = toba::consulta_php('cursos')->get_calendario_semanal($id_sede, 'false'); //no tiene html
        $cuadro_aux->set_datos($calendario);
        $cuadro_aux->vista_excel($salida);
        unset($cuadro_aux);	

        $salida->set_hoja_nombre('Calendario');
        $salida->set_nombre_archivo('calendario.xls');        
    }
    */
}
?>
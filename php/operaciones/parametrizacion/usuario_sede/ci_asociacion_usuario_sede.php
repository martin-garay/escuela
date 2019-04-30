<?php
class ci_asociacion_usuario_sede extends escuela_ci
{
	protected $s__seleccion;
	protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->dep('usuario_sede')->resetear();
	    $this->set_pantalla('pant_inicial');
	}

	function evt__procesar(){
		try {
			$this->dep('usuario_sede')->sincronizar();
	        $this->dep('usuario_sede')->resetear();
	        $this->set_pantalla('pant_inicial');	
		} catch (toba_error_db $e) {
			toba::notificacion()->error('Error al grabar los datos');
		}
        
    }
    //-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(escuela_ei_filtro $filtro)
	{
		if(isset($this->s__filtro))
			return $this->s__filtro;
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__filtro);
	}


	//---------------------------------------------------
    //Cuadro---------------------------------------------
    //---------------------------------------------------
    function conf__cuadro(escuela_ei_cuadro $cuadro){
        /* Si se le pasa la sede busco en la base de negocio. Sino uso la de toba*/
		        
		if(isset($this->s__filtro)){
			if(isset($this->s__filtro['id_sede'])){
				$clausulas=$this->dep('filtro')->get_sql_clausulas();				
				
				$clausulas['id_sede'] = $this->s__filtro['id_sede']['valor'] . ' IN (SELECT get_sedes_usuario(usuario))';				
				$where =  $this->dep('filtro')->get_sql_where("AND",$clausulas);	
				$sql = "SELECT usuario,nombre from usuario_sede us WHERE $where";			
				return toba::db()->consultar($sql);
			}else{
				$sql = "SELECT usuario,nombre from apex_usuario WHERE ".$this->dep('filtro')->get_sql_where();         		
				return toba::db('toba')->consultar($sql);
			}        	
         }else{
         	$sql = "SELECT usuario,nombre from apex_usuario";
         	return toba::db('toba')->consultar($sql);
         }
         
    }
    function evt__cuadro__seleccion($seleccion){
        $this->s__seleccion = $seleccion;
        $this->dep('usuario_sede')->cargar(array('usuario'=>$seleccion['usuario']));
        $this->set_pantalla('pant_edicion');
    }

	function conf__pant_edicion(toba_ei_pantalla $pantalla){
        $descripcion = '<b>Usuario : ' . $this->s__seleccion['usuario'] . '<br>Nombre : ' .$this->s__seleccion['nombre'].'</b>';
        $pantalla->set_descripcion($descripcion);
    }

	//-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(escuela_ei_formulario $form)
	{
		if($this->dep('usuario_sede')->esta_cargada())
			$form->set_datos($this->dep('usuario_sede')->get());
		else
			$form->ef('usuario')->set_estado($this->s__seleccion['usuario']);
	}

	function evt__form__modificacion($datos)
	{
		$datos['nombre'] = $this->s__seleccion['nombre'];		
		$this->dep('usuario_sede')->set($datos);
	}

	/*
	//-----------------------------------------------------------------------------------
	//---- cuadro_sedes -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_sedes(escuela_ei_cuadro $cuadro)
	{
		$titulo = "Sedes <div style='float:right'>Seleccionar Todos <input type='checkbox' id='seleccionar_todos'/></div>";
		$cuadro->set_titulo($titulo);
		return toba::consulta_php('sedes')->get_sedes();
	}

	function evt__cuadro_sedes__seleccionar($datos)
	{
		$sedes = implode(',',$datos);
		ei_arbol($datos);
		$this->dep('usuario_sede')->set_columna_valor('sedes',$sedes);
	}

	function conf_evt__cuadro_sedes__seleccionar(toba_evento_usuario $evento, $fila)
	{
		$datos = $this->dep('cuadro_sedes')->get_datos();
		$id_sede = $datos[$fila]['id'];
		$sedes = $this->dep('usuario_sede')->get_columna('sedes');

		$array_sedes = explode(',',$sedes);
		if(count($array_sedes>0)){
			if(in_array($array_sedes, $id_sede)){
			$evento->set_check_activo(true);
			}else{
				$evento->set_check_activo(false);
			}	
		}	
	}

	function extender_objeto_js(){
		if($this->get_id_pantalla()=='pant_edicion'){
			echo "
			$('.ei-cuadro-barra-sup').css('height','25px');
			$('#seleccionar_todos').click(function(){
				if($('#seleccionar_todos').is(':checked')){
					{$this->dep('cuadro_sedes')->objeto_js}.seleccionar_todos('seleccionar');
				}else{
					{$this->dep('cuadro_sedes')->objeto_js}.deseleccionar_todos('seleccionar');
				}
			});
			";	
		}
		
	}
*/
}
?>
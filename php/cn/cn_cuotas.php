<?php
class cn_cuotas extends escuela_cn
{
	function desactivar_transaccion(){
		$this->relacion()->persistidor()->desactivar_transaccion(true);
	}
	function relacion(){
		return $this->dep('relacion');
	}
	function tabla($nombre){
		return $this->relacion()->tabla($nombre);
	}

	/*
	array(anio,mes,id_curso,id_cursada,id_sede,id_modulo,id_medio_pago,importe_cuota,fecha_operacion,observaciones);
	*/
	function generar(){
		
		toba::db()->abrir_transaccion();
		try {
			$datos = $this->tabla('cuotas')->get();
			$alumnos = $this->tabla('cuotas_detalle')->get_filas();

			$modulo = toba::consulta_php('cursos')->get_modulos_cursadas("id=".$datos['id_modulo']);
			$datos['anio'] = $modulo[0]['anio'];
			$datos['mes'] = $modulo[0]['mes'];

			$datos['usuario'] = toba::usuario()->get_id();
			$this->tabla('cuotas')->set($datos);

			/*Datos para caja operaciones diarias*/
			$datos_cod['id_comprobante'] = 2; 					//CUOTA CURSO
			$datos_cod['id_medio_pago'] = 5;					//CUENTA CORRIENTE
			$datos_cod['id_movimiento'] = 21; 					//COBRANZA CUOTA CURSO		
			$datos_cod['importe'] = $datos['importe_cuota'];	//Los descuentos se aplican al momento de la cobranza
			$datos_cod['fecha_operacion'] = $datos['fecha_operacion'];
			$datos_cod['id_sede'] = $datos['id_sede'];
			$datos_cod['usuario'] = $datos['usuario'];
			$datos_cod['periodo'] = $datos['anio'].'-'.$datos['mes'].'-01';
			
			//grabar en caja operaciones diarias
			foreach ($alumnos as $key => $alumno) {				
				$datos_cod['id_titular'] = $alumno['id_alumno'];
				$datos_cod['id_inscripcion'] = toba::consulta_php('alumnos')->get_numero_inscripcion($alumno['id_alumno'], $datos['id_cursada']); //cursadas_alumnos.id
				toba::cn('cn_operaciones_diarias')->desactivar_transaccion();
				$numero_operacion = toba::cn('cn_operaciones_diarias')->grabar($datos_cod);
				ei_arbol($numero_operacion);

				//Guardo el id de caja_operaciones_diarias en el detalle de la cuota
				$id_cursor = $alumno['x_dbr_clave'];
				$this->tabla('cuotas_detalle')->set_cursor($id_cursor);
				$cuota_detalle = $this->tabla('cuotas_detalle')->get();
				$cuota_detalle['numero_operacion'] = $numero_operacion;
				$this->tabla('cuotas_detalle')->set($cuota_detalle);		//asocio la cuota con la generacion en cod
			}
			
			$this->relacion()->sincronizar();
			toba::db()->cerrar_transaccion();
	
		} catch (toba_error_db $e) {
			toba::notificacion()->error('Error al generar');
			toba::db()->abortar_transaccion();		
		}
	}


}

?>
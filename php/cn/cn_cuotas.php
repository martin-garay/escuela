<?php
class cn_cuotas extends escuela_cn
{

	/*
	array(anio,mes,id_curso,id_cursada,id_sede,id_modulo,id_medio_pago,importe_cuota,fecha_operacion,observaciones);
	*/
	function generar($datos,$alumnos){
		
		/*Datos para caja operaciones diarias*/
		$datos_cod['id_comprobante'] = 2; 					//CUOTA CURSO
		$datos_cod['id_medio_pago'] = 5;					//CUENTA CORRIENTE
		$datos_cod['id_movimiento'] = 21; 					//COBRANZA CUOTA CURSO		
		$datos_cod['importe'] = $datos['importe_cuota'];	//Los descuentos se aplican al momento de la cobranza
		$datos_cod['fecha'] = $datos['fecha_operacion'];
		$datos_cod['id_sede'] = $datos['id_sede'];
		$datos_cod['periodo'] = $datos['anio'].'-'.$datos['mes'].'-01';
		$datos_cod['numero_operacion'] = toba::consulta_php('caja')->get_numero_nueva_operacion();
		
		//grabar en caja operaciones diarias
		foreach ($alumnos as $key => $id_alumno) {
			$datos_cod['id_titular'] = $id_alumno;
			$datos['id_inscripcion'] = toba::consulta_php('alumnos')->get_numero_inscripcion($id_alumno, $id_cursada); //cursadas_alumnos.id
			toba::cn('cn_operaciones_diarias')->grabar($datos_cod);
		}
		$datos['numero_operacion'] = $datos_cod['numero_operacion']; //asocio la cuota con la generacion en cod
		$this->dep('cuotas')->set($datos);
		$this->dep('cuotas')->sincronizar($datos);
	}


}

?>
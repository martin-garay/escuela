<?php 
include_once 'comunes.php';

class cuotas extends comunes
{
	function get_cuotas_generadas($where=null, $order_by=null){
		return $this->get_generico('v_cuotas',$where,$order_by);
	}
	function get_alumnos_cuota_generada($where=null, $order_by=null){

	}
	function get_alumnos_modulo_sin_cuota($id_modulo){
		$sql = "SELECT id_alumno, 'A' as apex_ei_analisis_fila FROM cursadas_modulos_alumnos cma WHERE id_modulo=$id_modulo AND
				not exists (select * from cuotas_detalle cd inner join cuotas c ON c.id=cd.id_cuota where id_alumno=cma.id_alumno and id_modulo=$id_modulo)";
		return toba::db()->consultar($sql);
	}
	function generar_cuota_curso($anio,$mes,$id_curso,$id_cursada,$id_sede,$id_modulo,$importe_cuota,$fecha_operacion,$observaciones){

	}

	function generar_cuotas($id_modulo,$alumnos){
		//inserto en caja operaciones diarias (cod)
//		$parametrizaciones = toba::consulta_php('caja')->get_parametrizacion();
//		$numero_operacion = toba::consulta_php('caja')->get_numero_nueva_operacion();
//
//		$modulo = toba::consulta_php('cursos')->get_modulos_cursadas("id=$id_modulo");
//
//		$cuota['anio']
//		$cuota['mes']
//		$cuota['id_curso']
//		$cuota['id_cursada']
//		$cuota['id_modulo']
//		$cuota['importe_cuota']
//		$cuota['numero_operacion']
//		$cuota['fecha_operacion'] = ;
		//
//
//		foreach ($parametrizaciones as $key => $parametrizacion) {
//			foreach ($alumnos as $key => $id_alumno) {
//
//
					//
//				}	
//		}

		//guardo el id_movimiento de cod y lo asocio a la cuota
		
		
	}
	
}
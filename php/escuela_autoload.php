<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class escuela_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'FB' => '3ros/fb.php',
		'CrearUsuario' => 'clases/CrearUsuario.php',
		'escuela_autoload' => 'escuela_autoload.php',
		'escuela_ci' => 'extension_toba/componentes/escuela_ci.php',
		'escuela_cn' => 'extension_toba/componentes/escuela_cn.php',
		'escuela_datos_relacion' => 'extension_toba/componentes/escuela_datos_relacion.php',
		'escuela_datos_tabla' => 'extension_toba/componentes/escuela_datos_tabla.php',
		'escuela_ei_arbol' => 'extension_toba/componentes/escuela_ei_arbol.php',
		'escuela_ei_archivos' => 'extension_toba/componentes/escuela_ei_archivos.php',
		'escuela_ei_calendario' => 'extension_toba/componentes/escuela_ei_calendario.php',
		'escuela_ei_codigo' => 'extension_toba/componentes/escuela_ei_codigo.php',
		'escuela_ei_cuadro' => 'extension_toba/componentes/escuela_ei_cuadro.php',
		'escuela_ei_esquema' => 'extension_toba/componentes/escuela_ei_esquema.php',
		'escuela_ei_filtro' => 'extension_toba/componentes/escuela_ei_filtro.php',
		'escuela_ei_firma' => 'extension_toba/componentes/escuela_ei_firma.php',
		'escuela_ei_formulario' => 'extension_toba/componentes/escuela_ei_formulario.php',
		'escuela_ei_formulario_ml' => 'extension_toba/componentes/escuela_ei_formulario_ml.php',
		'escuela_ei_grafico' => 'extension_toba/componentes/escuela_ei_grafico.php',
		'escuela_ei_mapa' => 'extension_toba/componentes/escuela_ei_mapa.php',
		'escuela_servicio_web' => 'extension_toba/componentes/escuela_servicio_web.php',
		'escuela_comando' => 'extension_toba/escuela_comando.php',
		'escuela_modelo' => 'extension_toba/escuela_modelo.php',
		'alumnos' => 'lib/alumnos.php',
		'ciudades' => 'lib/ciudades.php',
		'combo_editable' => 'lib/combo_editable.php',
		'comunes' => 'lib/comunes.php',
		'parametrizacion' => 'lib/parametrizacion.php',
		'personas' => 'lib/personas.php',
		'sedes' => 'lib/sedes.php',
		'ci_login' => 'login/ci_login.php',
		'cuadro_autologin' => 'login/cuadro_autologin.php',
		'pant_login' => 'login/pant_login.php',
		'ci_seleccion_alumno' => 'operaciones/alumnos/ci_seleccion_alumno.php',
		'ci_datos_alumno' => 'operaciones/alumnos/datos_alumno/ci_datos_alumno.php',
		'ci_generico' => 'operaciones/ci_generico.php',
		'ci_amb_personas' => 'operaciones/personas/ci_amb_personas.php',
		'ci_datos_persona' => 'operaciones/personas/datos_persona/ci_datos_persona.php',
		'form_datos_actuales_js' => 'operaciones/personas/datos_persona/form_datos_actuales_js.php',
		'ci_abm_sedes' => 'operaciones/sedes/abm_sedes/ci_abm_sedes.php',
		'form_js' => 'operaciones/sedes/abm_sedes/form_js.php',
		'ci_alquiler_sede' => 'operaciones/sedes/alquiler_sede/ci_alquiler_sede.php',
		'form' => 'operaciones/sedes/alquiler_sede/form.php',
		'form_ml_js' => 'operaciones/sedes/alquiler_sede/form_ml_js.php',
		'ci_datos_sede' => 'operaciones/sedes/datos_sede/ci_datos_sede.php',
		'zona_alumno' => 'zonas/zona_alumno.php',
	);
}
?>
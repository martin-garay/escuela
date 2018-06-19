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
	);
}
?>
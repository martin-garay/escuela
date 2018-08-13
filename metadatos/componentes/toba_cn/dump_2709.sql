------------------------------------------------------------
--[2709]--  cn_operaciones_diarias 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'escuela', --proyecto
	'2709', --objeto
	NULL, --anterior
	'cn_operaciones_diarias', --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_cn', --clase
	'15', --punto_montaje
	'cn_operaciones_diarias', --subclase
	'cn/cn_operaciones_diarias.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'cn_operaciones_diarias', --nombre
	NULL, --titulo
	'0', --colapsable
	NULL, --descripcion
	'escuela', --fuente_datos_proyecto
	'escuela', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2018-08-05 23:56:18', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'1588', --dep_id
	'2709', --objeto_consumidor
	'18000517', --objeto_proveedor
	'datos', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_dep_consumo
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dep_consumo (proyecto, consumo_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar) VALUES (
	'escuela', --proyecto
	'2', --consumo_id
	'2709', --objeto_consumidor
	'2708', --objeto_proveedor
	'cn_operaciones_diarias', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL  --inicializar
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
--[18000479]--  datos_cursada - relacion 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 18
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'escuela', --proyecto
	'18000479', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_relacion', --clase
	'15', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'datos_cursada - relacion', --nombre
	NULL, --titulo
	NULL, --colapsable
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
	'2018-06-22 10:49:55', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 18

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'escuela', --proyecto
	'18000479', --objeto
	'0', --debug
	NULL, --clave
	'2', --ap
	'15', --punto_montaje
	NULL, --ap_clase
	NULL, --ap_archivo
	'0', --sinc_susp_constraints
	'1', --sinc_orden_automatico
	'1'  --sinc_lock_optimista
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 18
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'18000510', --dep_id
	'18000479', --objeto_consumidor
	'2624', --objeto_proveedor
	'cursadas', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'18000512', --dep_id
	'18000479', --objeto_consumidor
	'18000472', --objeto_proveedor
	'cursadas_alumnos', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'3'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'18000511', --dep_id
	'18000479', --objeto_consumidor
	'2626', --objeto_proveedor
	'cursadas_profesores', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
--- FIN Grupo de desarrollo 18

------------------------------------------------------------
-- apex_objeto_datos_rel_asoc
------------------------------------------------------------

--- INICIO Grupo de desarrollo 18
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'escuela', --proyecto
	'18000479', --objeto
	'18000104', --asoc_id
	NULL, --identificador
	'escuela', --padre_proyecto
	'2624', --padre_objeto
	'cursadas', --padre_id
	NULL, --padre_clave
	'escuela', --hijo_proyecto
	'2626', --hijo_objeto
	'cursadas_profesores', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'1'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'escuela', --proyecto
	'18000479', --objeto
	'18000105', --asoc_id
	NULL, --identificador
	'escuela', --padre_proyecto
	'2624', --padre_objeto
	'cursadas', --padre_id
	NULL, --padre_clave
	'escuela', --hijo_proyecto
	'18000472', --hijo_objeto
	'cursadas_alumnos', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'2'  --orden
);
--- FIN Grupo de desarrollo 18

------------------------------------------------------------
-- apex_objeto_rel_columnas_asoc
------------------------------------------------------------
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'escuela', --proyecto
	'18000479', --objeto
	'18000104', --asoc_id
	'2624', --padre_objeto
	'1202', --padre_clave
	'2626', --hijo_objeto
	'1208'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'escuela', --proyecto
	'18000479', --objeto
	'18000105', --asoc_id
	'2624', --padre_objeto
	'1202', --padre_clave
	'18000472', --hijo_objeto
	'18000535'  --hijo_clave
);

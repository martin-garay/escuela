------------------------------------------------------------
--[2548]--  Datos Alumnos - relacion 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'escuela', --proyecto
	'2548', --objeto
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
	'Datos Alumnos - relacion', --nombre
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
	'2018-06-13 20:14:19', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'escuela', --proyecto
	'2548', --objeto
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

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'1412', --dep_id
	'2548', --objeto_consumidor
	'2543', --objeto_proveedor
	'datos_academicos', --identificador
	NULL, --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'1413', --dep_id
	'2548', --objeto_consumidor
	'2544', --objeto_proveedor
	'datos_actuales', --identificador
	NULL, --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'3'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'1414', --dep_id
	'2548', --objeto_consumidor
	'2545', --objeto_proveedor
	'datos_laborales', --identificador
	NULL, --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'4'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'1415', --dep_id
	'2548', --objeto_consumidor
	'2546', --objeto_proveedor
	'datos_salud', --identificador
	NULL, --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'5'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'escuela', --proyecto
	'1411', --dep_id
	'2548', --objeto_consumidor
	'2542', --objeto_proveedor
	'personas', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_datos_rel_asoc
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'69', --asoc_id
	NULL, --identificador
	'escuela', --padre_proyecto
	'2542', --padre_objeto
	'personas', --padre_id
	NULL, --padre_clave
	'escuela', --hijo_proyecto
	'2543', --hijo_objeto
	'datos_academicos', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'1'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'70', --asoc_id
	NULL, --identificador
	'escuela', --padre_proyecto
	'2542', --padre_objeto
	'personas', --padre_id
	NULL, --padre_clave
	'escuela', --hijo_proyecto
	'2544', --hijo_objeto
	'datos_actuales', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'2'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'71', --asoc_id
	NULL, --identificador
	'escuela', --padre_proyecto
	'2542', --padre_objeto
	'personas', --padre_id
	NULL, --padre_clave
	'escuela', --hijo_proyecto
	'2545', --hijo_objeto
	'datos_laborales', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'3'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'72', --asoc_id
	NULL, --identificador
	'escuela', --padre_proyecto
	'2542', --padre_objeto
	'personas', --padre_id
	NULL, --padre_clave
	'escuela', --hijo_proyecto
	'2546', --hijo_objeto
	'datos_salud', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'4'  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_rel_columnas_asoc
------------------------------------------------------------
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'69', --asoc_id
	'2542', --padre_objeto
	'1145', --padre_clave
	'2543', --hijo_objeto
	'1090'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'70', --asoc_id
	'2542', --padre_objeto
	'1145', --padre_clave
	'2544', --hijo_objeto
	'1103'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'71', --asoc_id
	'2542', --padre_objeto
	'1145', --padre_clave
	'2545', --hijo_objeto
	'1110'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'escuela', --proyecto
	'2548', --objeto
	'72', --asoc_id
	'2542', --padre_objeto
	'1145', --padre_clave
	'2546', --hijo_objeto
	'1117'  --hijo_clave
);

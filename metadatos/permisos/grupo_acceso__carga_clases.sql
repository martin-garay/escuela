
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	'carga_clases_basico', --nombre
	NULL, --nivel_acceso
	'Cargar Clases Basico', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'0', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	NULL, --item_id
	'3559'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	NULL, --item_id
	'3563'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	NULL, --item_id
	'3565'  --item
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 18
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	NULL, --item_id
	'18000079'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'carga_clases', --usuario_grupo_acc
	NULL, --item_id
	'18000117'  --item
);
--- FIN Grupo de desarrollo 18

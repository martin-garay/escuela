
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'escuela', --proyecto
	'profesor_abm_usuario', --usuario_grupo_acc
	'profesor_abm_usuario', --nombre
	NULL, --nivel_acceso
	'abm personas', --descripcion
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
	'profesor_abm_usuario', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'profesor_abm_usuario', --usuario_grupo_acc
	NULL, --item_id
	'3513'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'profesor_abm_usuario', --usuario_grupo_acc
	NULL, --item_id
	'3515'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'profesor_abm_usuario', --usuario_grupo_acc
	NULL, --item_id
	'3520'  --item
);
--- FIN Grupo de desarrollo 0

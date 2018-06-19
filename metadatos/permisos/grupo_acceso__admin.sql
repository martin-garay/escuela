
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	'Administrador', --nombre
	'0', --nivel_acceso
	'Accede a toda la funcionalidad', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'1', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3513'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3514'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3515'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3516'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3517'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3518'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3519'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3520'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3521'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3523'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'escuela', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'3524'  --item
);
--- FIN Grupo de desarrollo 0

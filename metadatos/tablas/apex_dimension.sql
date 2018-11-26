
------------------------------------------------------------
-- apex_dimension
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, fuente_datos_proyecto, fuente_datos) VALUES (
	'escuela', --proyecto
	'17', --dimension
	'cursadas', --nombre
	NULL, --descripcion
	NULL, --schema
	'cursadas', --tabla
	'id', --col_id
	'nombre_perfil', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	'escuela', --fuente_datos_proyecto
	'escuela'  --fuente_datos
);
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, fuente_datos_proyecto, fuente_datos) VALUES (
	'escuela', --proyecto
	'18', --dimension
	'cursos', --nombre
	NULL, --descripcion
	NULL, --schema
	'cursos', --tabla
	'id', --col_id
	'nombre', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	'escuela', --fuente_datos_proyecto
	'escuela'  --fuente_datos
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 18
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, fuente_datos_proyecto, fuente_datos) VALUES (
	'escuela', --proyecto
	'18000001', --dimension
	'sedes', --nombre
	NULL, --descripcion
	NULL, --schema
	'v_sedes', --tabla
	'id', --col_id
	'nombre', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	'escuela', --fuente_datos_proyecto
	'escuela'  --fuente_datos
);
--- FIN Grupo de desarrollo 18


------------------------------------------------------------
-- apex_dimension_gatillo
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'escuela', --proyecto
	'17', --dimension
	'22', --gatillo
	'directo', --tipo
	'1', --orden
	'cursadas', --tabla_rel_dim
	'id', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'escuela', --proyecto
	'18', --dimension
	'23', --gatillo
	'directo', --tipo
	'1', --orden
	'cursos', --tabla_rel_dim
	'id', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'escuela', --proyecto
	'18', --dimension
	'24', --gatillo
	'directo', --tipo
	'2', --orden
	'cursadas', --tabla_rel_dim
	'id_curso', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'escuela', --proyecto
	'17', --dimension
	'25', --gatillo
	'directo', --tipo
	'2', --orden
	'cursos', --tabla_rel_dim
	'id_curso', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'escuela', --proyecto
	'17', --dimension
	'26', --gatillo
	'directo', --tipo
	'3', --orden
	'sedes', --tabla_rel_dim
	'id_sede', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 18
INSERT INTO apex_dimension_gatillo (proyecto, dimension, gatillo, tipo, orden, tabla_rel_dim, columnas_rel_dim, tabla_gatillo, ruta_tabla_rel_dim) VALUES (
	'escuela', --proyecto
	'18000001', --dimension
	'18000001', --gatillo
	'directo', --tipo
	'1', --orden
	'v_sedes', --tabla_rel_dim
	'id', --columnas_rel_dim
	NULL, --tabla_gatillo
	NULL  --ruta_tabla_rel_dim
);
--- FIN Grupo de desarrollo 18

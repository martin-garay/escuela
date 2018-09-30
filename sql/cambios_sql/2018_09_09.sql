CREATE OR REPLACE VIEW public.v_clases AS 
SELECT c.id,
	c.descripcion AS clase_descripcion,
	c.fecha,
	c.hora_inicio,
	c.hora_fin,
	c.id_tipo_clase,
	tc.descripcion AS tipo_clase,
	c.id_modulo,
	cm.nombre AS nombre_modulo,
	cm.descripcion AS descripcion_modulo,
	cm.mes AS mes_modulo,
	cm.anio AS anio_modulo,
	c.id_cursada,
	cu.descripcion AS cursada_descripcion,
	cu.fecha_inicio AS fecha_inicio_cursada,
	cu.fecha_fin AS fecha_fin_cursada,
	cursos.id AS id_curso,
	cursos.nombre AS nombre_curso,
	cursos.descripcion AS curso_descripcion,
	cursos.duracion AS duracion_curso,
	cursos.cant_minimo_alumnos,
	cursos.cant_maxima_alumnos,
	cursos.cant_modulos,
	cursos.activo,
	cursos.certificado_incluido,
	cursos.monto_certificado,
	cu.id_sede,
	s.nombre as sede
FROM clases c
LEFT JOIN cursadas cu ON cu.id = c.id_cursada
LEFT JOIN cursadas_modulos cm ON cm.id = c.id_modulo
LEFT JOIN cursos ON cursos.id = cu.id_curso
LEFT JOIN aulas au ON au.id = c.id_aula
LEFT JOIN tipo_clase tc ON tc.id = c.id_tipo_clase
LEFT JOIN sedes s ON s.id=cu.id_sede;
ALTER TABLE public.nivel_alerta ADD COLUMN sql_personas character varying;
ALTER TABLE public.nivel_alerta ALTER COLUMN sql_personas SET NOT NULL;

ALTER TABLE public.nivel_alerta ADD COLUMN opciones boolean;
ALTER TABLE public.nivel_alerta ADD COLUMN sql_opciones character varying;
ALTER TABLE public.alertas_niveles ADD COLUMN opciones character varying;


CREATE OR REPLACE VIEW public.v_alertas_niveles AS 
SELECT a.id,
		a.titulo,
		a.descripcion,
		a.id_tipo_alerta,
		a.fecha_desde,
		a.fecha_hasta,
		a.activo,
		a.fecha,
		a.tipo_alerta,
		an.id_nivel_alerta,
		na.descripcion AS nivel_alerta,
		an.opciones as opciones_nivel
FROM v_alertas a
JOIN alertas_niveles an ON an.id_alerta = a.id
JOIN nivel_alerta na ON na.id = an.id_nivel_alerta;


INSERT INTO public.nivel_alerta VALUES (6, 'ADEUDA CUOTAS', NULL, NULL, NULL);
INSERT INTO public.nivel_alerta VALUES (2, 'TODOS', 'select id from personas', NULL, NULL);
INSERT INTO public.nivel_alerta VALUES (4, 'SEDE', 'select distinct(id_alumno) as id
from cursadas_alumnos 
where id_cursada in (select id from cursadas where id_sede IN ($opciones))', true, 'select id,nombre as descripcion from sedes where activo order by nombre');
INSERT INTO public.nivel_alerta VALUES (7, 'CONDICION ALUMNO', 'select distinct(id_alumno) 
from cursadas_alumnos 
where id_condicion_alumno IN ($opciones)', true, 'select id, descripcion from condiciones_alumno');
INSERT INTO public.nivel_alerta VALUES (5, 'CURSADA', 'select distinct(id_alumno) as id
from cursadas_alumnos 
where id_cursada IN ($opciones)', true, 'select id, descripcion || '' (''||curso||'')'' as descripcion 
from v_cursadas 
where cursada_vigente 
order by curso,descripcion');
INSERT INTO public.nivel_alerta VALUES (3, 'CURSO', 'select id_alumno from cursadas_alumnos where id_curso in ($opciones)', true, 'select id,nombre as descripcion from cursos where activo');
SELECT pg_catalog.setval('public.nivel_alerta_id_seq', 7, true);

INSERT INTO public.tipo_alerta VALUES (1, 'NOTIFICACION');
INSERT INTO public.tipo_alerta VALUES (2, 'NOVEDADES');
INSERT INTO public.tipo_alerta VALUES (3, 'INFORMACION');
SELECT pg_catalog.setval('public.tipo_alerta_id_seq', 3, true);
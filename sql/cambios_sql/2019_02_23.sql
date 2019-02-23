CREATE OR REPLACE VIEW public.v_cursadas AS 
 SELECT cu.id,
    cu.descripcion,
    cu.fecha_inicio,
    cu.fecha_fin,
    cu.id_curso,
    c.nombre AS curso,
    c.descripcion AS descripcion_curso,
    c.duracion AS duracion_curso,
    c.porcentaje_correlativa,
    c.cant_minimo_alumnos,
    c.cant_maxima_alumnos,
    c.cant_modulos,
    c.activo,
    cu.id_sede,
    s.nombre AS sede,
    s.sede_descripcion,
    cu.anio,
    now()::date >= cu.fecha_inicio AND now()::date <= cu.fecha_fin AS cursada_vigente,
    cu.id_tipo_cursada,
    tc.descripcion AS tipo_cursada,
    cu.descripcion ||' ('|| TO_CHAR(fecha_inicio, 'YYYY/MM/DD')||' - '|| TO_CHAR(fecha_fin, 'YYYY/MM/DD')||')' descripcion_con_fecha
   FROM cursadas cu
     JOIN cursos c ON c.id = cu.id_curso
     JOIN v_sedes s ON s.id = cu.id_sede
     LEFT JOIN tipo_cursada tc ON tc.id = cu.id_tipo_cursada;


CREATE OR REPLACE VIEW public.v_cursadas_modulos AS 
 SELECT cm.id,
    cm.descripcion,
    cm.mes,
    cm.observaciones,
    cm.nombre,
    cm.id_cursada,
    cm.anio,
    (((cm.anio || '-'::text) || cm.mes) || '-01'::text)::date AS periodo,
    ((((cm.anio || '-'::text) || cm.mes) || '-01'::text)::date) >= (((((date_part('year'::text, now()) || '-'::text) || date_part('month'::text, now())) || '-'::text) || date_part('day'::text, now()))::date) AS modulo_vigente,
    c.descripcion AS cursada,
    c.id_curso,
    c.curso,
    c.descripcion_curso,
    c.duracion_curso,
    cm.orden,
    c.id_sede,
    c.sede,
    cm.nro_modulo,
    cm.fecha_inicio,
    cm.fecha_fin,
    cm.paga_cuota,
    cm.importe_cuota,
    c.id_tipo_cursada,
    c.tipo_cursada,
    --(cm.nombre::text || ' - '::text) || upper(to_char(to_timestamp(cm.mes::text, 'MM'::text), 'TMmon'::text)) AS nombre_mes
    cm.nombre::text || ' ('||cm.anio||'-'||lpad(cm.mes::text, 2, '0')||')' as nombre_mes
   FROM cursadas_modulos cm
     JOIN v_cursadas c ON c.id = cm.id_cursada;
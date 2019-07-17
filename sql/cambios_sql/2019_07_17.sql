DROP VIEW public.v_clases_practicas_alumnos;
DROP VIEW public.v_asistencia_clases_practicas;
DROP VIEW public.v_clases_practicas_profesores;
DROP VIEW public.v_clases_practicas;

alter table clases_practicas_profesores ALTER  column horas  TYPE numeric(10,2);
alter table clases_practicas ALTER  column horas  TYPE numeric(10,2);

CREATE OR REPLACE VIEW public.v_clases_practicas AS 
 SELECT c.id,
    c.id_tipo_clase,
    c.fecha,
    c.hora_inicio,
    c.hora_fin,
    c.id_tipo_alumno,
    c.id_sede,
    c.descripcion,
    c.horas,
    tcp.descripcion AS tipo_clase_practica,
    s.nombre AS sede,
    ta.descripcion AS tipo_alumno,
    date_part('year'::text, c.fecha) AS anio_clase,
    date_part('month'::text, c.fecha) AS mes_clase,
    (date_part('year'::text, c.fecha) || '-'::text) || date_part('month'::text, c.fecha) AS periodo_clase
   FROM clases_practicas c
     JOIN sedes s ON s.id = c.id_sede
     JOIN tipos_clases_practicas tcp ON tcp.id = c.id_tipo_clase
     LEFT JOIN tipos_alumnos ta ON ta.id = c.id_tipo_alumno;

CREATE OR REPLACE VIEW public.v_asistencia_clases_practicas AS 
 SELECT cpa.id,
    cpa.id_clase,
    cpa.id_cursada_alumno,
    cp.descripcion AS descripcion_clase,
    cp.fecha AS fecha_clase,
    cp.hora_inicio,
    cp.hora_fin,
    cp.horas AS cantidad_horas,
    cp.id_sede AS id_sede_clase,
    cp.sede AS sede_clase,
    ca.id_alumno,
    ca.id_cursada,
    ca.cursada AS cursada_alumno,
    ca.id_condicion_alumno,
    ca.sede AS sede_alumno,
    ca.nombre_alumno,
    ca.apellido_alumno,
    ca.dni,
    ca.legajo,
    ca.email,
    ca.curso,
    cp.tipo_clase_practica,
    cp.id_tipo_clase,
    cp.id_tipo_alumno,
    cp.tipo_alumno,
    cp.anio_clase,
    cp.mes_clase,
    cp.periodo_clase
   FROM clases_practicas_asistencia cpa
     JOIN v_cursadas_alumnos ca ON cpa.id_cursada_alumno = ca.id
     JOIN v_clases_practicas cp ON cp.id = cpa.id_clase;




CREATE OR REPLACE VIEW public.v_clases_practicas_profesores AS 
 SELECT cpp.id,
    cpp.id_profesor,
    cpp.id_clase_practica,
    cpp.horas,
    cpp.valor_hora,
    cpp.liquidada,
    cpp.horas::numeric * cpp.valor_hora AS importe,
    cpp.fecha_liquidacion,
    c.id_tipo_clase,
    c.fecha,
    c.hora_inicio,
    c.hora_fin,
    c.id_tipo_alumno,
    c.id_sede,
    c.descripcion,
    c.tipo_clase_practica,
    c.sede,
    c.tipo_alumno,
    p.nombre,
    p.apellido,
    p.dni
   FROM clases_practicas_profesores cpp
     JOIN v_clases_practicas c ON cpp.id_clase_practica = c.id
     JOIN personas p ON p.id = cpp.id_profesor;

CREATE OR REPLACE VIEW public.v_clases_practicas_alumnos AS 
 SELECT cpa.id,
    cpa.id_alumno,
    cpa.id_clase_practica,
    c.id_tipo_clase,
    c.fecha,
    c.hora_inicio,
    c.hora_fin,
    c.id_tipo_alumno,
    c.id_sede,
    c.descripcion,
    c.horas,
    c.tipo_clase_practica,
    c.sede,
    c.tipo_alumno,
    p.nombre,
    p.apellido,
    p.dni,
    c.mes_clase,
    c.anio_clase,
    c.periodo_clase
   FROM clases_practicas_alumnos cpa
     JOIN v_clases_practicas c ON cpa.id_clase_practica = c.id
     JOIN personas p ON p.id = cpa.id_alumno;


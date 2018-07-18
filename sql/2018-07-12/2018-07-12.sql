CREATE OR REPLACE VIEW v_cursadas_modulos AS 
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
    c.sede
   FROM cursadas_modulos cm
     JOIN v_cursadas c ON c.id = cm.id_cursada;


     create view v_cursadas_modulos_alumnos as 
select cma.*,
    cm.descripcion as modulo_descripcion, cm.mes as mes_modulo,cm.nombre as modulo_nombre,
    cm.id_cursada, cm.cursada,cm.anio as anio_cursada, cm.periodo as periodo_cursada, cm.modulo_vigente,fecha_inicio_cursada,fecha_fin_cursada,
    cm.id_curso,cm.curso,cm.id_sede,cm.sede,ca.sede_descripcion,
    id_condicion_alumno,fecha_inscripcion,
    nombre_alumno,apellido_alumno,dni,legajo,telefono_celular,telefono_mensaje,email,apto_curso,certificado_medico
from cursadas_modulos_alumnos cma
left join v_cursadas_modulos cm ON cm.id=cma.id_modulo
left join v_cursadas_alumnos ca ON ca.id=cma.id_cursadas_alumnos

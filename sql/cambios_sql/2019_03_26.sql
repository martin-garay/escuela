/*
CREATE OR REPLACE VIEW public.v_clases_practicas_cursos AS 
 SELECT c.id,
    c.id_clase,
    c.id_tipo_alumno,
    tcp.descripcion AS clase,
    ta.descripcion AS tipo_alumno,
    ( SELECT string_agg(cursos.nombre::text, ','::text ORDER BY (cursos.nombre::text)) AS string_agg
           FROM clases_practicas_cursos_detalle d
             JOIN cursos ON cursos.id = d.id_curso
          WHERE d.id_cabecera = c.id
          GROUP BY d.id_cabecera) AS cursos
   FROM clases_practicas_cursos c
     JOIN tipos_clases_practicas tcp ON c.id_clase = tcp.id
     LEFT JOIN tipos_alumnos ta ON ta.id = c.id_tipo_alumno;
*/
drop view v_clases_practicas_cursos;
drop table clases_practicas_cursos_detalle  ;
drop table clases_practicas_cursos ;


CREATE TABLE par_clases_practicas_cursos
(
  id serial NOT NULL,
  id_tipo_clase integer NOT NULL,
  id_curso integer NOT NULL,
  CONSTRAINT pk_par_clases_practicas_cursos PRIMARY KEY (id),
  CONSTRAINT fk_clases_practicas_cursos__tipos_clases_practicas FOREIGN KEY (id_tipo_clase)
  REFERENCES public.tipos_clases_practicas (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_clases_practicas_cursos__curso FOREIGN KEY (id_curso)
  REFERENCES public.cursos (id) MATCH SIMPLE
  ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

create or replace view v_par_clases_practicas_cursos as 
select p.* ,tcp.descripcion as tipo_clase ,c.nombre as curso
from par_clases_practicas_cursos p
inner join tipos_clases_practicas tcp ON p.id_tipo_clase=tcp.id
inner join cursos c ON c.id=p.id_curso;


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
    extract(year from c.fecha) as anio_clase,
    extract(month from c.fecha) as mes_clase,
    extract(year from c.fecha) ||'-'||extract(month from c.fecha) as periodo_clase
   FROM clases_practicas c
     JOIN sedes s ON s.id = c.id_sede
     JOIN tipos_clases_practicas tcp ON tcp.id = c.id_tipo_clase
     LEFT JOIN tipos_alumnos ta ON ta.id = c.id_tipo_alumno;


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


CREATE OR REPLACE VIEW public.v_cursadas_modulos_alumnos AS 
 SELECT cma.id,
    cma.id_modulo,
    cma.id_cursadas_alumnos,
    cma.orden,
    cm.descripcion AS modulo_descripcion,
    cm.mes AS mes_modulo,
    cm.anio AS anio_modulo,
    cm.nombre AS modulo_nombre,
    cm.id_cursada,
    cm.cursada,
    cm.anio AS anio_cursada,
    cm.periodo AS periodo_cursada,
    cm.modulo_vigente,
    ca.fecha_inicio_cursada,
    ca.fecha_fin_cursada,
    cm.id_curso,
    cm.curso,
    cm.id_sede,
    cm.sede,
    ca.sede_descripcion,
    ca.id_alumno,
    ca.id_condicion_alumno,
    ca.fecha_inscripcion,
    ca.nombre_alumno,
    ca.apellido_alumno,
    ca.dni,
    ca.legajo,
    ca.telefono_celular,
    ca.telefono_mensaje,
    ca.email,
    ca.apto_curso,
    ca.certificado_medico,
    cm.fecha_inicio as fecha_inicio_modulo,
    cm.fecha_fin as fecha_fin_modulo
   FROM cursadas_modulos_alumnos cma
     LEFT JOIN v_cursadas_modulos cm ON cm.id = cma.id_modulo
     LEFT JOIN v_cursadas_alumnos ca ON ca.id = cma.id_cursadas_alumnos;

CREATE OR REPLACE VIEW public.v_cursadas_alumnos AS 
 SELECT ca.id,
    ca.id_cursada,
    ca.id_alumno,
    ca.id_condicion_alumno,
    ca.modulo_inicio,
    ca.abono_matricula,
    ca.fecha_inscripcion,
    c.id_curso,
    c.curso,
    c.descripcion_curso,
    c.descripcion AS cursada,
    c.fecha_inicio AS fecha_inicio_cursada,
    c.fecha_fin AS fecha_fin_cursada,
    c.sede,
    c.sede_descripcion,
    p.nombre AS nombre_alumno,
    p.apellido AS apellido_alumno,
    p.dni,
    p.legajo,
    p.telefono_celular,
    p.telefono_mensaje,
    p.email,
    p.apto_curso,
    p.certificado_medico,
    cm.descripcion AS descripcion_modulo_inicio,
    ( select fecha_inicio from cursadas_modulos_alumnos cma1 inner join cursadas_modulos mc1 ON mc1.id=cma1.id_modulo 
     where cma1.id_cursadas_alumnos=ca.id order by anio asc, mes asc limit 1) AS fecha_inicio_primer_modulo,
    ( select fecha_fin from cursadas_modulos_alumnos cma2 inner join cursadas_modulos mc2 ON mc2.id=cma2.id_modulo 
     where cma2.id_cursadas_alumnos=ca.id order by anio desc, mes desc limit 1) AS fecha_fin_ultimo_modulo
   FROM cursadas_alumnos ca
     JOIN v_cursadas c ON c.id = ca.id_cursada
     JOIN v_personas p ON p.id = ca.id_alumno
     JOIN condiciones_alumno cond ON cond.id = ca.id_condicion_alumno
     JOIN cursadas_modulos cm ON cm.id = ca.modulo_inicio;

alter table clases_asistencia RENAME to clases_teoricas_asistencia;

CREATE TABLE public.clases_practicas_asistencia
(
  id serial NOT NULL,
  id_clase integer NOT NULL,
  id_cursada_alumno integer NOT NULL,
  CONSTRAINT pk_clases_practicas_asistencia PRIMARY KEY (id),
  CONSTRAINT fk_clases_practicas_asistencia__cursadas_alumnos FOREIGN KEY (id_cursada_alumno)
      REFERENCES public.cursadas_alumnos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_clases_practicas_asistencia__clase FOREIGN KEY (id_clase)
      REFERENCES public.clases_practicas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);



--graba la asistencia a una cursada para sumar horas practicas
CREATE OR REPLACE FUNCTION public.sp_trg_ai_clases_practicas_alumnos() RETURNS trigger AS
$BODY$
DECLARE
  _id_tipo_clase integer;
  _fecha date;
BEGIN
  SELECT id_tipo_clase,fecha into _id_tipo_clase,_fecha  FROM clases_practicas WHERE id=NEW.id_clase_practica;  --tipo de clase practica

  --suma las horas si la fecha de la clase esta entre la fecha de inicio del primer modulo y la fecha de fin del ultimo.
  INSERT INTO clases_practicas_asistencia(id_cursada_alumno,id_clase)
  SELECT id as id_cursada_alumno, NEW.id_clase_practica as id_clase FROM v_cursadas_alumnos 
  WHERE id_alumno = NEW.id_alumno AND 
    id_curso in (SELECT id_curso FROM par_clases_practicas_cursos where id_tipo_clase =_id_tipo_clase) AND
    _fecha BETWEEN fecha_inicio_primer_modulo AND fecha_fin_ultimo_modulo;
  RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

CREATE TRIGGER trg_ai_clases_practicas_alumnos
  AFTER INSERT
  ON public.clases_practicas_alumnos
  FOR EACH ROW
  EXECUTE PROCEDURE public.sp_trg_ai_clases_practicas_alumnos();

--si se borra la asistencia la borro de las cursadas donde alla sumado horas
  CREATE OR REPLACE FUNCTION public.sp_trg_ad_clases_practicas_alumnos() RETURNS trigger AS
$BODY$
DECLARE
  _id_tipo_clase integer;
  _fecha date;
BEGIN
  --borro las asistencias de las cursadas del alumno
  delete from clases_practicas_asistencia cpa where cpa.id_clase=OLD.id_clase_practica and OLD.id_alumno=(SELECT id_alumno FROM cursadas_alumnos ca where ca.id=cpa.id_cursada_alumno);
  RETURN OLD;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

CREATE TRIGGER trg_ad_clases_practicas_alumnos
  AFTER DELETE
  ON public.clases_practicas_alumnos
  FOR EACH ROW
  EXECUTE PROCEDURE public.sp_trg_ad_clases_practicas_alumnos();


create view v_asistencia_clases_practicas as
select cpa.*, cp.descripcion as descripcion_clase,cp.fecha as fecha_clase,cp.hora_inicio,cp.hora_fin,horas as cantidad_horas,
  cp.id_sede as id_sede_clase,cp.sede as sede_clase,
  ca.id_alumno,ca.id_cursada,ca.cursada as cursada_alumno,ca.id_condicion_alumno,ca.sede as sede_alumno,ca.nombre_alumno,ca.apellido_alumno,ca.dni,ca.legajo,
  ca.email,ca.curso,tipo_clase_practica,id_tipo_clase,id_tipo_alumno,tipo_alumno,anio_clase,mes_clase,periodo_clase
from clases_practicas_asistencia cpa
inner join v_cursadas_alumnos ca ON cpa.id_cursada_alumno=ca.id
inner join v_clases_practicas cp ON cp.id=cpa.id_clase
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
    cm.descripcion as descripcion_modulo_inicio
FROM cursadas_alumnos ca
JOIN v_cursadas c ON c.id = ca.id_cursada
JOIN v_personas p ON p.id = ca.id_alumno
JOIN condiciones_alumno cond ON cond.id = ca.id_condicion_alumno
join cursadas_modulos cm ON cm.id=ca.modulo_inicio;

ALTER TABLE public.titulos
ADD CONSTRAINT fk_titulos__tipo_titulo FOREIGN KEY (id_tipo_titulo)
REFERENCES public.tipo_titulo (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION;

CREATE TABLE public.titulos_alumnos
(
  id serial NOT NULL,
  id_titulo integer NOT NULL,
  id_alumno integer NOT NULL,
  observaciones character varying(500) NOT NULL,
  fecha date NOT NULL DEFAULT now(),
  id_cursada_alumno integer,
  id_curso integer NOT NULL,
  id_sede integer NOT NULL,
  CONSTRAINT pk_titulos_alumnos PRIMARY KEY (id),
  CONSTRAINT fk_titulos_alumnos__cursadas_alumnos FOREIGN KEY (id_cursada_alumno)
      REFERENCES public.cursadas_alumnos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_titulos_alumnos__cursos FOREIGN KEY (id_curso)
      REFERENCES public.cursos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_titulos_alumnos__personas FOREIGN KEY (id_alumno)
      REFERENCES public.personas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_titulos_alumnos__titulos FOREIGN KEY (id_titulo)
      REFERENCES public.titulos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_titulos_alumnos__sedes FOREIGN KEY (id_sede)
      REFERENCES public.sedes (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
create view v_titulos_alumnos as
select ta.*,
    p.nombre as nombre_alumno,p.apellido as apellido_alumno,p.dni,p.id_ciudad as id_ciudad_alumno,
    t.nombre as nombre_titulo, t.descripcion as descripcion_titulo,t.id_tipo_titulo, t.tipo_titulo,
    c.nombre as nombre_curso,c.descripcion as descripcion_curso,c.duracion as duracion_curso,
    s.nombre as sede,
    cu.descripcion as cursada
from titulos_alumnos ta
inner join v_personas p ON p.id=ta.id_alumno
inner join v_titulos t ON t.id=ta.id_titulo
inner join cursos c ON c.id=ta.id_curso
inner join sedes s ON s.id=ta.id_sede
left join cursadas_alumnos ca ON ca.id=ta.id_cursada_alumno
left join cursadas cu ON cu.id=ca.id_cursada;

ALTER TABLE public.cursos_titulos ADD COLUMN importe numeric(10,2);

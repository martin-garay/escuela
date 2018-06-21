CREATE TABLE cursos
(
  id serial NOT NULL,
  nombre character varying(100) NOT NULL,
  descripcion character varying(255) NOT NULL,
  duracion integer NOT NULL,
  porcentaje_correlativa numeric(10,2) NOT NULL DEFAULT 100, -- porcentaje necesario para poder cursar los siguientes cursos que son correlativos
  cant_minimo_alumnos integer,
  cant_maxima_alumnos integer,
  cant_modulos integer NOT NULL,
  activo boolean NOT NULL DEFAULT true,
  cant_clases_practicas integer,
  cant_clases_teoricas integer,
  certificado_incluido boolean NOT NULL, -- Si el certificado esta incluido o se paga aparte
  monto_certificado numeric(10,2),
  CONSTRAINT pk_cursos PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE cursos
  OWNER TO postgres;
COMMENT ON COLUMN cursos.porcentaje_correlativa IS 'porcentaje necesario para poder cursar los siguientes cursos que son correlativos';
COMMENT ON COLUMN cursos.certificado_incluido IS 'Si el certificado esta incluido o se paga aparte';

CREATE TABLE cursos_correlatividad
(
  id serial NOT NULL,
  id_curso integer NOT NULL,
  id_curso_previo integer NOT NULL,
  CONSTRAINT pk_cursos_correlatividad PRIMARY KEY (id),
  CONSTRAINT fk_cursos_correlatividad__cursos FOREIGN KEY (id_curso)
      REFERENCES cursos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_cursos_correlatividad__cursos_previos FOREIGN KEY (id_curso_previo)
      REFERENCES cursos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT uk_cursos_correlatividad UNIQUE (id_curso, id_curso_previo)
)
WITH (
  OIDS=FALSE
);
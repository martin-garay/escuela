CREATE TABLE tipo_persona_perfiles
(
  id serial NOT NULL,
  id_tipo_persona integer NOT NULL,
  perfil character varying(60),
  CONSTRAINT pk_tipo_persona_perfiles PRIMARY KEY (id),
  CONSTRAINT fk_tipo_persona_perfiles__tipo_persona FOREIGN KEY (id_tipo_persona)
      REFERENCES tipo_persona (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE tipo_persona_perfiles
  OWNER TO postgres;
COMMENT ON TABLE tipo_persona_perfiles
  IS 'Perfiles a asignar cuando se crea un usuario';
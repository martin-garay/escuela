CREATE TABLE cuotas_detalle
(
  id serial NOT NULL,
  id_alumno integer NOT NULL,
  id_caja integer,
  id_cuota integer NOT NULL,
  CONSTRAINT pk_cuotas_detalle PRIMARY KEY (id),
  CONSTRAINT fk_cuotas_detalle__caja_operaciones_diarias FOREIGN KEY (id_caja)
      REFERENCES caja_operaciones_diarias (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_cutoas_detalle__cuotas FOREIGN KEY (id_cuota)
      REFERENCES cuotas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
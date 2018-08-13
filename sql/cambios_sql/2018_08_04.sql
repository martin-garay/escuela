ALTER TABLE public.cursos_modulos ADD COLUMN importe_cuota numeric(10,2);
ALTER TABLE public.cursos_modulos ALTER COLUMN importe_cuota SET NOT NULL;
ALTER TABLE public.cursos_modulos ALTER COLUMN importe_cuota SET DEFAULT 0;

ALTER TABLE public.cursadas_modulos ADD COLUMN importe_cuota numeric(10,2);
ALTER TABLE public.cursadas_modulos ALTER COLUMN importe_cuota SET NOT NULL;
ALTER TABLE public.cursadas_modulos ALTER COLUMN importe_cuota SET DEFAULT 0;

ALTER TABLE public.cursos_modulos ADD COLUMN paga_cuota boolean;
ALTER TABLE public.cursos_modulos ALTER COLUMN paga_cuota SET NOT NULL;
ALTER TABLE public.cursos_modulos ALTER COLUMN paga_cuota SET DEFAULT true;

ALTER TABLE public.cursadas_modulos ADD COLUMN paga_cuota boolean;
ALTER TABLE public.cursadas_modulos ALTER COLUMN paga_cuota SET NOT NULL;
ALTER TABLE public.cursadas_modulos ALTER COLUMN paga_cuota SET DEFAULT true;


CREATE TABLE public.cuotas
(
  id serial NOT NULL,
  mes integer NOT NULL,
  anio integer NOT NULL,
  id_curso integer NOT NULL,
  id_cursada integer NOT NULL,
  id_modulo integer NOT NULL,
  importe_cuota numeric(10,2) NOT NULL,
  id_movimiento integer NOT NULL, -- id_movimiento de caja operaciones diarias. Se les pega el mismo id_movimiento a todas las cuotas de la generacion
  observaciones character varying(255),
  id_sede integer NOT NULL,
  fecha timestamp without time zone NOT NULL DEFAULT now(),
  fecha_operacion date NOT NULL,
  CONSTRAINT pk_cuotas PRIMARY KEY (id),
  CONSTRAINT fk_cuotas__cursadas FOREIGN KEY (id_cursada)
      REFERENCES public.cursadas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_cuotas__cursos FOREIGN KEY (id_curso)
      REFERENCES public.cursos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_cuotas__modulos FOREIGN KEY (id_modulo)
      REFERENCES public.cursadas_modulos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_cuotas__sedes FOREIGN KEY (id_sede)
      REFERENCES public.sedes (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.cuotas
  OWNER TO postgres;
COMMENT ON COLUMN public.cuotas.id_movimiento IS 'id_movimiento de caja operaciones diarias. Se les pega el mismo id_movimiento a todas las cuotas de la generacion';

ALTER TABLE public.cuotas ADD COLUMN usuario character varying(50);
ALTER TABLE public.cuotas ALTER COLUMN usuario SET NOT NULL;


create view v_cuotas as 
select c.*,cu.descripcion as cursada,cu.curso,cu.sede,cu.cursada_vigente,cu.tipo_cursada,
	cm.descripcion as modulo,cm.nro_modulo
from cuotas c
inner join v_cursadas cu ON cu.id=c.id_cursada
inner join cursadas_modulos cm ON cm.id=c.id_modulo;


--agrego los nuevos campos al trigger que genera los modulos de la cursada
CREATE OR REPLACE FUNCTION public.sp_trg_ai_cursadas()
  RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
	/* Se realiza una copia de los modulos del curso para la cursada */
	insert into cursadas_modulos(descripcion,mes,anio,observaciones,nombre,id_cursada,orden,nro_modulo,fecha_inicio,fecha_fin,paga_cuota,importe_cuota)
	select descripcion,mes,new.anio,observaciones,nombre,NEW.id,orden,nro_modulo,(new.anio||'-'||mes||'-01')::date,
	(new.anio||'-'||mes||'-01')::date + '1month'::interval- '1day'::interval,paga_cuota,importe_cuota
	from cursos_modulos where id_curso=NEW.id_curso order by orden;
	RETURN NULL;
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

ALTER TABLE public.caja_operaciones_diarias ADD COLUMN numero_operacion integer;
ALTER TABLE public.caja_operaciones_diarias ALTER COLUMN numero_operacion SET NOT NULL;
COMMENT ON COLUMN public.caja_operaciones_diarias.numero_operacion IS 'Numero para agrupar toda una operacion';

alter table cuotas rename column id_movimiento to numero_operacion;

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
	cm.nro_modulo,cm.fecha_inicio,cm.fecha_fin,cm.paga_cuota,cm.importe_cuota  
FROM cursadas_modulos cm
JOIN v_cursadas c ON c.id = cm.id_cursada;

ALTER TABLE public.caja_comprobantes ADD COLUMN identificador character varying(100);

ALTER TABLE public.personas DROP CONSTRAINT uk_alumnos_legajo;

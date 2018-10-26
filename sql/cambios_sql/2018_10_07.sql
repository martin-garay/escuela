begin transaction;
create table tipos_liquidaciones(
	id serial not null,
	descripcion character varying (100) not null,
	tabla character varying (100),
	constraint pk_tipos_liquidaciones primary key(id)
);

insert into tipos_liquidaciones(descripcion,tabla) values('LIQUIDACION CLASES PRACTICAS','clases_practicas_profesores'),('LIQUIDACION SUELDOS',null);

create table con_liquidacion(
	id serial not null,
	fecha date not null default now(),
	id_tipo_liquidacion integer not null,
	usuario character varying (60) not null,
	numero_operacion_cod integer, /* agrupa todo una operacion en cod*/
	constraint pk_con_liquidacion primary key(id),
	constraint kf_con_liquidacion__tipo foreign key (id_tipo_liquidacion) references tipos_liquidaciones(id)
);

--faltaba el campo en cod
alter table caja_operaciones_diarias add column id_inscripcion integer;
ALTER TABLE public.caja_operaciones_diarias ALTER COLUMN periodo SET DEFAULT date_trunc('month'::text, (('now'::text)::date)::timestamp with time zone);

CREATE OR REPLACE FUNCTION public.sp_trg_bu_clases_practicas_profesores()
  RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
  IF OLD.liquidada OR OLD.id_liquidacion IS NOT NULL THEN
    RAISE EXCEPTION 'NO SE PUEDE MODIFICAR UNA CLASE LIQUIDADA';
  END IF;
  
  IF OLD.id_liquidacion is NULL AND NEW.id_liquidacion IS NOT NULL THEN
    NEW.fecha_liquidacion = NOW();
    NEW.liquidada=TRUE;
  END IF; 
  RETURN NEW;
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

  alter table caja_operaciones_diarias add column id_bloque integer; --para asociar todo un proceso con un id
/*
La escuela entrega libreta de formación una vez que el estudiante cumple con los requisitos de ingreso.
Tiene un plazo de 2 meses para presentarlos. Caso contrario no puede continuar cursando y practicando 
(avisar por mail a  estudiante y formador a cargo), tampoco pueden descargar materiales
*/
ALTER TABLE public.cursadas_alumnos ADD COLUMN cumple_requisitos boolean;
ALTER TABLE public.cursadas_alumnos ALTER COLUMN cumple_requisitos SET NOT NULL;
ALTER TABLE public.cursadas_alumnos ALTER COLUMN cumple_requisitos SET DEFAULT false;


/*
Algunas de las formaciones tienen la modalidad regular o intensiva
*/
create table tipo_cursada(
	id serial not null,
	descripcion character varying(60) not null,
	constraint pk_tipo_cursada primary key (id)
);
insert into tipo_cursada(id,descripcion)values (1,'REGULAR');
insert into tipo_cursada(id,descripcion)values (2,'INTENSIVA');

ALTER TABLE public.cursadas ADD COLUMN id_tipo_cursada integer;
ALTER TABLE public.cursadas ALTER COLUMN id_tipo_cursada SET NOT NULL;
ALTER TABLE public.cursadas ADD CONSTRAINT fk_cursadas__tipo_cursada FOREIGN KEY (id_tipo_cursada)
REFERENCES public.tipo_cursada (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;


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
	tc.descripcion as tipo_cursada
FROM cursadas cu
JOIN cursos c ON c.id = cu.id_curso
JOIN v_sedes s ON s.id = cu.id_sede
LEFT JOIN tipo_cursada tc ON tc.id=cu.id_tipo_cursada;

CREATE OR REPLACE FUNCTION public.sp_trg_ai_cursadas()
  RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
	/* Se realiza una copia de los modulos del curso para la cursada */
	insert into cursadas_modulos(descripcion,mes,anio,observaciones,nombre,id_cursada,orden,nro_modulo,fecha_inicio,fecha_fin)
	select descripcion,mes,new.anio,observaciones,nombre,NEW.id,orden,nro_modulo,(new.anio||'-'||mes||'-01')::date,
	(new.anio||'-'||mes||'-01')::date + '1month'::interval- '1day'::interval	
	from cursos_modulos where id_curso=NEW.id_curso order by orden;
	RETURN NULL;
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

ALTER TABLE public.cursadas_modulos DROP CONSTRAINT uk_cursadas_modulos;
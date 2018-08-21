ALTER TABLE public.cursos ADD COLUMN importe_cuota numeric(10,2);

ALTER TABLE public.cursadas_alumnos ADD COLUMN id_sede integer;

ALTER TABLE public.personas DROP CONSTRAINT uk_alumnos_legajo;

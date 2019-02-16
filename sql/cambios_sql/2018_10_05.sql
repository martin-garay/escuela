ALTER TABLE public.clases_practicas_profesores ADD COLUMN id_liquidacion integer;
COMMENT ON COLUMN public.clases_practicas_profesores.id_liquidacion IS 'Para asociar la clase a una liquidacion';

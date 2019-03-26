ALTER TABLE public.cursadas_modulos_alumnos
  ADD CONSTRAINT fk_cursadas_modulos_alumnos__cursadas_alumnos FOREIGN KEY (id_cursadas_alumnos)
      REFERENCES public.cursadas_alumnos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

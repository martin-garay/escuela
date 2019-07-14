CREATE OR REPLACE FUNCTION public.sp_trg_incrementar_numero_registro()
  RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
	--Si el nuevo numero de registro es mayor al de la parametrizacion, seteo la paramtrizacion con este nuevo nro
	IF(NEW.nro_registro>(SELECT nro_registro FROM ultimo_nro_registro))THEN
		UPDATE ultimo_nro_registro SET nro_registro = NEW.nro_registro;
	END IF;
	RETURN NULL;
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

CREATE TRIGGER trg_ai_registro_alumos
  AFTER INSERT
  ON public.registro_alumnos
  FOR EACH ROW
  EXECUTE PROCEDURE public.sp_trg_incrementar_numero_registro();

CREATE OR REPLACE FUNCTION public.sp_trg_incrementar_numero_registro()
  RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
	--Si el nuevo numero de registro es mayor al de la parametrizacion, seteo la paramtrizacion con este nuevo nro
	IF(NEW.nro_registro>(SELECT nro_registro FROM ultimo_nro_registro))THEN
		UPDATE ultimo_nro_registro SET nro_registro = NEW.nro_registro;
	END IF;
	RETURN NULL;
  END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

  CREATE TRIGGER trg_au_registro_alumos
  AFTER UPDATE
  ON public.registro_alumnos
  FOR EACH ROW
  EXECUTE PROCEDURE public.sp_trg_incrementar_numero_registro();

alter table clases_practicas_profesores add column horas integer not null default 1;
alter table clases_practicas_profesores add column valor_hora numeric(10,2) not null;
alter table clases_practicas_profesores add column liquidada boolean not null default false;
alter table clases_practicas_profesores add column fecha_liquidacion timestamp without time zone;


CREATE OR REPLACE FUNCTION public.get_valor_hora_profesor(id_profesor integer)
  RETURNS numeric(10,2) AS
$BODY$
DECLARE    
BEGIN
return 1.00;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

/* cuando inserto en clases_practicas_profesores calculo lo que le tengo que pagar*/
CREATE OR REPLACE FUNCTION public.sp_trg_bi_clases_practicas_profesores()
  RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
	--busco la cantidad de horas de la clase y el valor de la hora al momento de liquidar
	SELECT horas INTO NEW.horas FROM clases_practicas WHERE id=NEW.id_clase_practica;
	NEW.valor_hora = get_valor_hora_profesor(NEW.id_profesor);
	RETURN NEW;
  END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

CREATE TRIGGER trg_bi_clases_practicas_profesores
  BEFORE INSERT
  ON public.clases_practicas_profesores
  FOR EACH ROW
  EXECUTE PROCEDURE public.sp_trg_bi_clases_practicas_profesores();

DROP VIEW IF EXISTS public.v_clases_practicas_profesores;

CREATE OR REPLACE VIEW public.v_clases_practicas_profesores AS 
 SELECT cpp.id,
        cpp.id_profesor,
        cpp.id_clase_practica,
        cpp.horas,
        cpp.valor_hora,
        cpp.liquidada,
        (cpp.horas * cpp.valor_hora) as importe,
        fecha_liquidacion,
        c.id_tipo_clase,
        c.fecha,
        c.hora_inicio,
        c.hora_fin,
        c.id_tipo_alumno,
        c.id_sede,
        c.descripcion,
        c.tipo_clase_practica,
        c.sede,
        c.tipo_alumno,
        p.nombre,
        p.apellido,
        p.dni
FROM clases_practicas_profesores cpp
JOIN v_clases_practicas c ON cpp.id_clase_practica = c.id
JOIN personas p ON p.id = cpp.id_profesor;

CREATE OR REPLACE FUNCTION public.sp_trg_bu_clases_practicas_profesores()
RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
  IF OLD.liquidada THEN
    RAISE EXCEPTION 'NO SE PUEDE MODIFICAR UNA CLASE LIQUIDADA';
  END IF;
  
  IF NOT OLD.liquidada AND NEW.liquidada THEN
    NEW.fecha_liquidacion = NOW();
  END IF; 
  RETURN NEW;
  END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

CREATE TRIGGER trg_bu_clases_practicas_profesores
BEFORE UPDATE
ON public.clases_practicas_profesores
FOR EACH ROW
EXECUTE PROCEDURE public.sp_trg_bu_clases_practicas_profesores();


CREATE OR REPLACE FUNCTION public.sp_trg_bd_clases_practicas_profesores()
RETURNS trigger AS
$BODY$
DECLARE    
BEGIN
  IF OLD.liquidada THEN
    RAISE EXCEPTION 'NO SE PUEDE ELIMINAR UNA CLASE LIQUIDADA';
  END IF;
  RETURN NULL;
  END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;

CREATE TRIGGER trg_bd_clases_practicas_profesores
BEFORE DELETE
ON public.clases_practicas_profesores
FOR EACH ROW
EXECUTE PROCEDURE public.sp_trg_bd_clases_practicas_profesores();
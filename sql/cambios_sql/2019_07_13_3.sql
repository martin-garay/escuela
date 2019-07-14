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


CREATE OR REPLACE VIEW public.v_titulos_alumnos AS 
 SELECT ta.id,
    ta.id_titulo,
    ta.id_alumno,
    ta.observaciones,
    ta.fecha,
    ta.id_cursada_alumno,
    ta.id_curso,
    ta.id_sede,
    p.nombre AS nombre_alumno,
    p.apellido AS apellido_alumno,
    p.dni,
    p.id_ciudad AS id_ciudad_alumno,
    t.nombre AS nombre_titulo,
    t.descripcion AS descripcion_titulo,
    t.id_tipo_titulo,
    t.tipo_titulo,
    c.nombre AS nombre_curso,
    c.descripcion AS descripcion_curso,
    c.duracion AS duracion_curso,
    s.nombre AS sede,
    cu.descripcion AS cursada,
    ra.nro_registro,
    ra.anio_registro,
    ra.fecha AS fecha_registro,
    --(ra.nro_registro || '-'::text) || ra.anio_registro AS nro_registro_completo
    (to_char(ra.nro_registro, 'fm000'::text) || '-'::text) || substr(ra.anio_registro::text, 3, 4) AS nro_registro_completo
   FROM titulos_alumnos ta
     JOIN v_personas p ON p.id = ta.id_alumno
     JOIN v_titulos t ON t.id = ta.id_titulo
     JOIN cursos c ON c.id = ta.id_curso
     JOIN sedes s ON s.id = ta.id_sede
     LEFT JOIN cursadas_alumnos ca ON ca.id = ta.id_cursada_alumno
     LEFT JOIN cursadas cu ON cu.id = ca.id_cursada
     LEFT JOIN registro_alumnos ra ON ra.id_alumno = ta.id_alumno;


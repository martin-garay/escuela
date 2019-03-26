CREATE OR REPLACE FUNCTION es_practicante(_id_persona integer)
  RETURNS boolean AS
$BODY$
  SELECT exists (SELECT 1 FROM personas_tipo WHERE id_persona=_id_persona and id_tipo_persona=3);
$BODY$
  LANGUAGE sql VOLATILE
  COST 100;
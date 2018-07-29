ALTER TABLE public.nivel_alerta ADD COLUMN sql_personas character varying;
ALTER TABLE public.nivel_alerta ALTER COLUMN sql_personas SET NOT NULL;

ALTER TABLE public.nivel_alerta ADD COLUMN opciones boolean;
ALTER TABLE public.nivel_alerta ADD COLUMN sql_opciones character varying;
ALTER TABLE public.alertas_niveles ADD COLUMN opciones character varying;


CREATE OR REPLACE VIEW public.v_alertas_niveles AS 
SELECT a.id,
		a.titulo,
		a.descripcion,
		a.id_tipo_alerta,
		a.fecha_desde,
		a.fecha_hasta,
		a.activo,
		a.fecha,
		a.tipo_alerta,
		an.id_nivel_alerta,
		na.descripcion AS nivel_alerta,
		an.opciones as opciones_nivel
FROM v_alertas a
JOIN alertas_niveles an ON an.id_alerta = a.id
JOIN nivel_alerta na ON na.id = an.id_nivel_alerta;




/*
--view v_titulos_alumnos depends on view v_personas
--view v_cursadas_alumnos depends on view v_personas
--view v_clases_alumnos depends on view v_cursadas_alumnos
--view v_asistencia_clases_teoricas depends on view v_cursadas_alumnos
---view v_cursadas_modulos_alumnos depends on view v_cursadas_alumnos
--view v_asistencia_clases_practicas depends on view v_cursadas_alumnos
view v_registros_alumnos depends on view v_personas
*/

begin transaction;
----------------------------------------------------------------------------------	
--agrego la sede
----------------------------------------------------------------------------------
alter table personas add column id_sede integer;
alter table personas add constraint fk_personas_sede foreign key (id_sede) references sedes(id);

----------------------------------------------------------------------------------
--agrego el tilde jubilado
----------------------------------------------------------------------------------
alter table personas add column jubilado boolean default false;

----------------------------------------------------------------------------------
--OTROS DOCUMENTOS
----------------------------------------------------------------------------------
	--agrego el tipo de documento para validar dni u otros
	alter table personas add column id_tipo_documento integer not null default 1;


	--borro las vistas para poder cambiar dni a character
	DROP VIEW public.v_clases_practicas_profesores;
	DROP VIEW public.v_clases_practicas_alumnos;
	DROP VIEW public.v_registros_alumnos;
	DROP VIEW public.v_asistencia_clases_practicas;
	DROP VIEW public.v_cursadas_modulos_alumnos;
	DROP VIEW public.v_asistencia_clases_teoricas;
	DROP VIEW public.v_clases_alumnos;
	DROP VIEW public.v_cursadas_alumnos;
	DROP VIEW public.v_titulos_alumnos;
	DROP VIEW public.v_clases_teoricas_profesores;
	DROP VIEW public.v_personas;
	
	--cambio el campo
	alter table personas alter column dni TYPE CHARACTER VARYING(15);

	--creo las vistas de nuevo	
	CREATE OR REPLACE VIEW public.v_personas AS 
	 SELECT a.id,
	    a.nombre,
	    a.apellido,
	    a.fecha_nacimiento,
	    a.dni,
	    a.foto_dni,
	    a.legajo,
	    a.id_tipo_persona,
	    tp.descripcion AS tipo_persona,
	    aca.id_nivel_estudio,
	    ne.descripcion AS nivel_estudio,
	    aca.estudia_actualmente,
	    aca.institucion_estudia,
	    aca.dias,
	    aca.horas,
	    act.calle,
	    act.altura,
	    act.piso,
	    act.id_ciudad,
	    ciu.nombre AS ciudad,
	    ciu.cp,
	    ciu.id_provincia,
	    pro.nombre AS provincia,
	    pro.id_pais,
	    pai.nombre AS pais,
	    act.telefono_particular,
	    act.telefono_celular,
	    act.telefono_mensaje,
	    act.email,
	    dl.id_profesion,
	    p.descripcion AS profesion,
	    dl.empresa_trabaja,
	    dl.domicilio_trabaja,
	    dl.telefono_laboral,
	    dl.email_laboral,
	    ds.cobertura_medica,
	    ds.apto_curso,
	    ds.observaciones_medicas,
	    ds.certificado_medico,
	    ds.id_grupo_sanguineo,
	    gs.descripcion AS grupo_sanguineo,
	    (((a.dni || ' - '::text) || a.apellido::text) || ' '::text) || a.nombre::text AS descripcion,
	    a.libreta_impresa,
	    jubilado,
	    id_tipo_documento,	    
	    id_sede,
	    s.nombre as sede,
	    case when id_tipo_documento = 1 then 'DNI' else 'Otro Documento' end as tipo_documento
	   FROM personas a
	     LEFT JOIN tipo_persona tp ON tp.id = a.id_tipo_persona
	     LEFT JOIN datos_academicos aca ON a.id = aca.id_persona
	     LEFT JOIN datos_actuales act ON a.id = act.id_persona
	     LEFT JOIN datos_laborales dl ON a.id = dl.id_persona
	     LEFT JOIN datos_salud ds ON a.id = ds.id_persona
	     LEFT JOIN grupos_sanguineos gs ON ds.id_grupo_sanguineo = gs.id
	     LEFT JOIN niveles_estudios ne ON aca.id_nivel_estudio = ne.id
	     LEFT JOIN profesiones p ON dl.id_profesion = p.id
	     LEFT JOIN ciudades ciu ON ciu.id = act.id_ciudad
	     LEFT JOIN provincias pro ON pro.id = ciu.id_provincia
	     LEFT JOIN paises pai ON pai.id = pro.id_pais
	     LEFT JOIN sedes s ON s.id=a.id_sede;

	CREATE OR REPLACE VIEW public.v_clases_teoricas_profesores AS 
	 SELECT cp.id,
	    c.id AS id_clase,
	    c.clase_descripcion,
	    c.fecha,
	    c.hora_inicio,
	    c.hora_fin,
	    c.id_sede,
	    c.sede,
	    cp.id_profesor,
	    p.apellido,
	    p.nombre,
	    p.dni,
	    c.id_curso,
	    c.nombre_curso,
	    c.id_cursada,
	    c.cursada_descripcion,
	    c.id_modulo,
	    c.nombre_modulo,
	    c.mes_modulo,
	    c.anio_modulo,
	    date_part('epoch'::text, c.hora_fin - c.hora_inicio) / 3600::double precision AS horas
	   FROM v_clases c
	     JOIN clases_profesores cp ON cp.id_clase = c.id
	     JOIN personas p ON p.id = cp.id_profesor;
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
	    cu.descripcion AS cursada
	   FROM titulos_alumnos ta
	     JOIN v_personas p ON p.id = ta.id_alumno
	     JOIN v_titulos t ON t.id = ta.id_titulo
	     JOIN cursos c ON c.id = ta.id_curso
	     JOIN sedes s ON s.id = ta.id_sede
	     LEFT JOIN cursadas_alumnos ca ON ca.id = ta.id_cursada_alumno
	     LEFT JOIN cursadas cu ON cu.id = ca.id_cursada;

	CREATE OR REPLACE VIEW public.v_cursadas_alumnos AS 
	 SELECT ca.id,
	    ca.id_cursada,
	    ca.id_alumno,
	    ca.id_condicion_alumno,
	    ca.modulo_inicio,
	    ca.abono_matricula,
	    ca.fecha_inscripcion,
	    c.id_curso,
	    c.curso,
	    c.descripcion_curso,
	    c.descripcion AS cursada,
	    c.fecha_inicio AS fecha_inicio_cursada,
	    c.fecha_fin AS fecha_fin_cursada,
	    c.sede,
	    c.sede_descripcion,
	    p.nombre AS nombre_alumno,
	    p.apellido AS apellido_alumno,
	    p.dni,
	    p.legajo,
	    p.telefono_celular,
	    p.telefono_mensaje,
	    p.email,
	    p.apto_curso,
	    p.certificado_medico,
	    cm.descripcion AS descripcion_modulo_inicio,
	    ( SELECT mc1.fecha_inicio
		   FROM cursadas_modulos_alumnos cma1
		     JOIN cursadas_modulos mc1 ON mc1.id = cma1.id_modulo
		  WHERE cma1.id_cursadas_alumnos = ca.id
		  ORDER BY mc1.anio, mc1.mes
		 LIMIT 1) AS fecha_inicio_primer_modulo,
	    ( SELECT mc2.fecha_fin
		   FROM cursadas_modulos_alumnos cma2
		     JOIN cursadas_modulos mc2 ON mc2.id = cma2.id_modulo
		  WHERE cma2.id_cursadas_alumnos = ca.id
		  ORDER BY mc2.anio DESC, mc2.mes DESC
		 LIMIT 1) AS fecha_fin_ultimo_modulo,
	    cm.nro_modulo
	   FROM cursadas_alumnos ca
	     JOIN v_cursadas c ON c.id = ca.id_cursada
	     JOIN v_personas p ON p.id = ca.id_alumno
	     JOIN condiciones_alumno cond ON cond.id = ca.id_condicion_alumno
	     JOIN cursadas_modulos cm ON cm.id = ca.modulo_inicio;

	CREATE OR REPLACE VIEW public.v_clases_alumnos AS 
	 SELECT c.id AS id_clase,
	    c.clase_descripcion,
	    c.fecha AS fecha_clase,
	    c.hora_inicio AS hora_inicio_clase,
	    c.hora_fin AS hora_fin_clase,
	    c.id_tipo_clase,
	    c.tipo_clase,
	    c.id_modulo,
	    c.nombre_modulo,
	    c.descripcion_modulo,
	    cm.nro_modulo,
	    c.mes_modulo,
	    c.anio_modulo,
	    c.activo AS curso_activo,
	    cm.modulo_vigente,
	    ca.id_alumno,
	    ca.id_condicion_alumno,
	    ca.nombre_alumno,
	    ca.apellido_alumno,
	    ca.dni,
	    ca.legajo,
	    ca.telefono_celular,
	    ca.telefono_mensaje,
	    ca.email,
	    ca.modulo_inicio,
	    ca.abono_matricula,
	    ca.fecha_inscripcion,
	    ca.id_curso,
	    ca.curso,
	    ca.descripcion_curso,
	    cm.id_cursada,
	    cm.cursada,
	    cm.periodo,
	    cm.id_sede,
	    cm.sede,
	    cm.orden AS orden_modulos
	   FROM v_clases c
	     JOIN cursadas_modulos_alumnos cma ON cma.id_modulo = c.id_modulo
	     LEFT JOIN v_cursadas_alumnos ca ON ca.id = cma.id_cursadas_alumnos
	     LEFT JOIN v_cursadas_modulos cm ON cm.id = cma.id_modulo;

	CREATE OR REPLACE VIEW public.v_asistencia_clases_teoricas AS 
	 SELECT a.id,
	    a.id_clase,
	    a.presente,
	    a.id_cursada_alumno,
	    cla.descripcion AS descripcion_clase,
	    cla.id_cursada AS id_cursada_clase,
	    cla.id_modulo AS id_modulo_clase,
	    cla.fecha AS fecha_clase,
	    cla.hora_inicio,
	    cla.hora_fin,
	    date_part('epoch'::text, cla.hora_fin - cla.hora_inicio) / 3600::double precision AS cantidad_horas,
	    ca.id_alumno,
	    ca.id_cursada,
	    ca.cursada AS cursada_alumno,
	    ca.id_condicion_alumno,
	    ca.sede,
	    ca.nombre_alumno,
	    ca.apellido_alumno,
	    ca.dni,
	    ca.legajo,
	    ca.email,
	    ca.curso,
	    cm.nro_modulo,
	    cm.mes AS mes_modulo,
	    cm.anio AS anio_modulo,
	    cu.descripcion AS cursada_clase,
	    cu.id_sede AS id_sede_clase,
	    cu.sede AS sede_clase
	   FROM clases_teoricas_asistencia a
	     JOIN clases cla ON a.id_clase = cla.id
	     JOIN v_cursadas cu ON cu.id = cla.id_cursada
	     JOIN v_cursadas_alumnos ca ON ca.id = a.id_cursada_alumno
	     JOIN cursadas_modulos cm ON cm.id = cla.id_modulo;

	CREATE OR REPLACE VIEW public.v_cursadas_modulos_alumnos AS 
	 SELECT cma.id,
	    cma.id_modulo,
	    cma.id_cursadas_alumnos,
	    cma.orden,
	    cm.descripcion AS modulo_descripcion,
	    cm.mes AS mes_modulo,
	    cm.anio AS anio_modulo,
	    cm.nombre AS modulo_nombre,
	    cm.id_cursada,
	    cm.cursada,
	    cm.anio AS anio_cursada,
	    cm.periodo AS periodo_cursada,
	    cm.modulo_vigente,
	    ca.fecha_inicio_cursada,
	    ca.fecha_fin_cursada,
	    cm.id_curso,
	    cm.curso,
	    cm.id_sede,
	    cm.sede,
	    ca.sede_descripcion,
	    ca.id_alumno,
	    ca.id_condicion_alumno,
	    ca.fecha_inscripcion,
	    ca.nombre_alumno,
	    ca.apellido_alumno,
	    ca.dni,
	    ca.legajo,
	    ca.telefono_celular,
	    ca.telefono_mensaje,
	    ca.email,
	    ca.apto_curso,
	    ca.certificado_medico,
	    cm.fecha_inicio AS fecha_inicio_modulo,
	    cm.fecha_fin AS fecha_fin_modulo
	   FROM cursadas_modulos_alumnos cma
	     LEFT JOIN v_cursadas_modulos cm ON cm.id = cma.id_modulo
	     LEFT JOIN v_cursadas_alumnos ca ON ca.id = cma.id_cursadas_alumnos;

	CREATE OR REPLACE VIEW public.v_asistencia_clases_practicas AS 
	 SELECT cpa.id,
	    cpa.id_clase,
	    cpa.id_cursada_alumno,
	    cp.descripcion AS descripcion_clase,
	    cp.fecha AS fecha_clase,
	    cp.hora_inicio,
	    cp.hora_fin,
	    cp.horas AS cantidad_horas,
	    cp.id_sede AS id_sede_clase,
	    cp.sede AS sede_clase,
	    ca.id_alumno,
	    ca.id_cursada,
	    ca.cursada AS cursada_alumno,
	    ca.id_condicion_alumno,
	    ca.sede AS sede_alumno,
	    ca.nombre_alumno,
	    ca.apellido_alumno,
	    ca.dni,
	    ca.legajo,
	    ca.email,
	    ca.curso,
	    cp.tipo_clase_practica,
	    cp.id_tipo_clase,
	    cp.id_tipo_alumno,
	    cp.tipo_alumno,
	    cp.anio_clase,
	    cp.mes_clase,
	    cp.periodo_clase
	   FROM clases_practicas_asistencia cpa
	     JOIN v_cursadas_alumnos ca ON cpa.id_cursada_alumno = ca.id
	     JOIN v_clases_practicas cp ON cp.id = cpa.id_clase;

     CREATE OR REPLACE VIEW public.v_registros_alumnos AS 
	 SELECT r.id,
	    r.id_titulo AS id_titulo_alumno,
	    r.id_alumno,
	    r.nro_registro,
	    r.anio_registro,
	    (to_char(r.nro_registro, 'fm0000'::text) || '-'::text) || substr(r.anio_registro::text, 3, 4) AS nro_registro_completo,
	    r.fecha AS fecha_alta_registro,
	    p.nombre,
	    p.apellido,
	    p.dni
	   FROM registro_alumnos r
	     JOIN v_personas p ON r.id_alumno = p.id;

	ALTER TABLE public.v_registros_alumnos
	  OWNER TO postgres;

	CREATE OR REPLACE VIEW public.v_clases_practicas_alumnos AS 
	 SELECT cpa.id,
	    cpa.id_alumno,
	    cpa.id_clase_practica,
	    c.id_tipo_clase,
	    c.fecha,
	    c.hora_inicio,
	    c.hora_fin,
	    c.id_tipo_alumno,
	    c.id_sede,
	    c.descripcion,
	    c.horas,
	    c.tipo_clase_practica,
	    c.sede,
	    c.tipo_alumno,
	    p.nombre,
	    p.apellido,
	    p.dni,
	    c.mes_clase,
	    c.anio_clase,
	    c.periodo_clase
	   FROM clases_practicas_alumnos cpa
	     JOIN v_clases_practicas c ON cpa.id_clase_practica = c.id
	     JOIN personas p ON p.id = cpa.id_alumno;

	CREATE OR REPLACE VIEW public.v_clases_practicas_profesores AS 
	 SELECT cpp.id,
	    cpp.id_profesor,
	    cpp.id_clase_practica,
	    cpp.horas,
	    cpp.valor_hora,
	    cpp.liquidada,
	    cpp.horas::numeric * cpp.valor_hora AS importe,
	    cpp.fecha_liquidacion,
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



--rollback
--commit
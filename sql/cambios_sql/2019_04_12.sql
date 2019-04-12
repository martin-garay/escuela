alter table personas add column libreta_impresa boolean not null default false;

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
    libreta_impresa
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
     LEFT JOIN paises pai ON pai.id = pro.id_pais;

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

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
    (((a.dni::text || ' - '::text) || a.apellido::text) || ' '::text) || a.nombre::text || COALESCE(' - '||s.nombre,'') AS descripcion,
    a.libreta_impresa,
    a.jubilado,
    a.id_tipo_documento,
    a.id_sede,
    s.nombre AS sede,
        CASE
            WHEN a.id_tipo_documento = 1 THEN 'DNI'::text
            ELSE 'Otro Documento'::text
        END AS tipo_documento
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
     LEFT JOIN sedes s ON s.id = a.id_sede;


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
    nro_registro,anio_registro,ra.fecha as fecha_registro,nro_registro||'-'||anio_registro as nro_registro_completo
   FROM titulos_alumnos ta
     JOIN v_personas p ON p.id = ta.id_alumno
     JOIN v_titulos t ON t.id = ta.id_titulo
     JOIN cursos c ON c.id = ta.id_curso
     JOIN sedes s ON s.id = ta.id_sede
     LEFT JOIN cursadas_alumnos ca ON ca.id = ta.id_cursada_alumno
     LEFT JOIN cursadas cu ON cu.id = ca.id_cursada
     LEFT JOIN registro_alumnos ra ON ra.id_alumno=ta.id_alumno;



 alter table titulos_alumnos add column id_tipo_titulo integer not null default 1;
 alter table titulos_alumnos add constraint fk_titulos_alumnos__tipo_titulo foreign key (id_tipo_titulo) references tipo_titulo(id);
--drop view v_personas_detallado; 
CREATE OR REPLACE VIEW public.v_personas_detallado AS 
 SELECT a.id,
    a.nombre,
    a.apellido,
    a.fecha_nacimiento,
    a.dni,
    a.foto_dni,
    a.legajo,
    a.id_tipo_persona,
    tp.descripcion as tipo_persona,
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
    gs.descripcion AS grupo_sanguineo
   FROM personas a
   LEFT JOIN tipo_persona tp ON tp.id=a.id_tipo_persona
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


--drop view v_sedes 
create or replace view v_sedes as 
select s.*,c.nombre as ciudad, pr.nombre as provincia, p.nombre as pais,(s.nombre|| ', Direccion: '||c.nombre||', '||pr.nombre||', '||p.nombre) as sede_descripcion
from sedes s 
left join ciudades c ON c.id=s.id_ciudad
left join provincias pr ON pr.id=c.id_provincia
left join paises p ON p.id=pr.id_pais;
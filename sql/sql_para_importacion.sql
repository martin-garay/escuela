BEGIN TRANSACTION; 
--ROLLBACK
/* personas */
--consulta para cargar personas
--insert into personas  : select * from personas --nombre,apellido,fecha_nacimiento,dni,foto_dni,legajo,id_tipo_persona,cuil
insert into personas(id,nombre,apellido,fecha_nacimiento,dni,foto_dni,legajo,id_tipo_persona,cuil)
select * from 
(select id,nombre,apellido,COALESCE(fecha_nacimiento,'1900-01-01')::date,replace(dni,'.','')::int as dni,
(COALESCE(upper(foto_dni),'NO')='SI') as foto_dni,legajo,1 as id_tipo_persona,cuil from temp_personas ) as s
where dni not in (select replace(dni,'.','')::int from temp_personas where length(replace(dni,'.','')::text)>8)
and dni not in(select replace(dni,'.','')::int from temp_personas where dni is not null group by replace(dni,'.','')::int having count(1)>1 )
and dni is not null


/* datos_actuales */
--select * from datos_actuales --calle,altura,piso,id_ciudad,telefono_particular,telefono_celular,telefono_mensaje,email,id_persona
insert into datos_actuales(calle,altura2,piso,id_ciudad,telefono_particular,telefono_celular,telefono_mensaje,email,id_persona) 
select calle,numero,piso::int,(select id from ciudades c where p.codigo_postal=c.cp limit 1) as id_ciudad, tel_particular,tel_celular,tel_mensaje,email,id
from temp_personas p where id in (select id from personas)

/* datos_laborales */
--select * from datos_laborales --id_profesion,empresa_trabaja,domicilio_trabaja,telefono_laboral,email_laboral,id_persona,profesion
insert into datos_laborales(empresa_trabaja,domicilio_trabaja,telefono_laboral,email_laboral,id_persona,profesion)
select empresa,domicilio,tel_laboral,email_laboral,id as id_persona, profesion from temp_personas  p where id in (select id from personas)

/* datos_salud */
--select * from datos_salud --cobertura_medica, apto_curso,observaciones_medicas,certificado_medico,id_persona,id_grupo_sanguineo
insert into datos_salud(cobertura_medica, apto_curso,observaciones_medicas,certificado_medico,id_persona,id_grupo_sanguineo)
select cobertura_medica,case when apto_curso='SI' then true else null end,observaciones,
case when cert_medico='SI' then true when 'NO' then false else null end as certificado_medico,
p.id as id_persona,g.id as id_grupo_sanguineo from temp_personas p
left join grupos_sanguineos g ON p.grupo_sang=g.descripcion
where p.id in (select id from personas)
--select distinct(trim(apto_curso)) from temp_personas --update temp_personas set apto_curso='SI' where trim(apto_curso) in ('A','SI','S','s')

/* datos_academicos */
--select * from datos_academicos --id_nivel_estudio,titulo,estudia_actualmente,estudia_descripcion,institucion_estudia,dias,horas,id_persona
INSERT INTO datos_academicos(id_nivel_estudio,titulo,estudia_actualmente,estudia_descripcion,institucion_estudia,dias,horas,id_persona)
select case when terciario<>'INCOMPLETO' and terciario is not null then 3
	when secundario='COMPLETO' then 2
	when primario ='COMPLETO' then 1 end as id_nivel_estudio,
	coalesce('Terciario: '||terciario,'') as titulo,
	(case when estudia ='SI' then true else false end) as estudia_actualmente,
	estudia as estudia_descripcion,
	institucion,null as dias ,null as horas,id as id_persona
from temp_personas
where id IN (select id from personas )

commit;
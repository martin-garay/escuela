
drop table temp_personas2;
create table temp_personas2(
	legajo integer,
	sede character varying(100),
	apellido character varying(100),
	nombre character varying(100),
	fecha_nacimiento character varying(100),
	nacionalidad character varying(100),
	dni character varying(100),
	cuil character varying(100),
	calle character varying(100),
	numero character varying(100),
	piso character varying(100),
	codigo_postal integer,
	ciudad character varying(100),
	provincia character varying(100),
	pais character varying(100),
	tel_particular character varying(100),
	tel_celular character varying(100),
	tel_mensaje character varying(100),
	email character varying(100),
	grupo_sang character varying(100),
	cobertura_medica character varying(100),
	apto_curso character varying(10),
	observaciones character varying(500),
	primario character varying(100),
	secundario character varying(100),
	terciario character varying(100),
	estudia character varying(100),
	institucion character varying(100),	
	profesion character varying(100),
	empresa character varying(100),
	domicilio character varying(500),
	tel_laboral character varying(100),
	email_laboral character varying(100),
	foto character varying(100),
	foto_dni character varying(100),
	cert_medico character varying(100),
	reglamento character varying(100),
	activo character varying(100),
	fecha_egreso character varying(100),
	libreta character varying(100),
	fecha_inicio character varying(100),
	curso1 character varying(100)
);

COPY temp_personas2 FROM '/home/martin/Escritorio/escuela/archivos/alumnos.csv' DELIMITERS ';' CSV QUOTE E'\"';

drop table temp_personas;
create table temp_personas(
	id serial not null,
	legajo integer,
sede character varying(100),
apellido character varying(100),
nombre character varying(100),
fecha_nacimiento character varying(100),
nacionalidad character varying(100),
dni character varying(100),
cuil character varying(100),
calle character varying(100),
numero character varying(100),
piso character varying(100),
codigo_postal integer,
ciudad character varying(100),
provincia character varying(100),
pais character varying(100),
tel_particular character varying(100),
tel_celular character varying(100),
tel_mensaje character varying(100),
email character varying(100),
grupo_sang character varying(100),
cobertura_medica character varying(100),
apto_curso character varying(10),
observaciones character varying(500),
primario character varying(100),
secundario character varying(100),
terciario character varying(100),
estudia character varying(100),
institucion character varying(100),	
profesion character varying(100),
empresa character varying(100),
domicilio character varying(500),
tel_laboral character varying(100),
email_laboral character varying(100),
foto character varying(100),
foto_dni character varying(100),
cert_medico character varying(100),
reglamento character varying(100),
activo character varying(100),
fecha_egreso character varying(100),
libreta character varying(100),
fecha_inicio character varying(100),
curso1 character varying(100),
constraint pk_temp_personas PRIMARY KEY(id)
);

insert into temp_personas(legajo,sede,apellido,nombre,fecha_nacimiento,nacionalidad,dni,cuil,calle,numero,piso,codigo_postal,ciudad,provincia,pais,tel_particular,tel_celular,tel_mensaje,email,grupo_sang,cobertura_medica,apto_curso,observaciones,primario,secundario,terciario,estudia,institucion,profesion,empresa,domicilio,tel_laboral,email_laboral,foto,foto_dni,cert_medico,reglamento,activo,fecha_egreso,libreta,fecha_inicio,curso1)
select * from temp_personas2;	









select distinct(nacionalidad) from temp_personas where nacionalidad ilike '%arg%'

select * from paises 

/* personas */
--consulta para cargar personas
--insert into personas  : select * from personas --nombre,apellido,fecha_nacimiento,dni,foto_dni,legajo,id_tipo_persona,cuil
insert into personas(nombre,apellido,fecha_nacimiento,dni,foto_dni,legajo,id_tipo_persona,cuil)
select id,nombre,apellido,fecha_nacimiento,replace(dni,'.','') as dni,
(COALESCE(upper(foto_dni),'NO')='SI') as foto_dni,legajo,1 as id_tipo_persona,cuil from temp_personas 

/* datos_actuales */
select * from datos_actuales --calle,altura,piso,id_ciudad,telefono_particular,telefono_celular,telefono_mensaje,email,id_persona
insert into datos_actuales(calle,altura,piso,id_ciudad,telefono_particular,telefono_celular,telefono_mensaje,email,id_persona) 
select calle,altura,piso,(select id from ciudades c where p.codigo_postal=c.cp limit 1) as id_ciudad, tel_particular,tel_celular,tel_mensaje,email,id
from temp_personas p

/* datos_laborales */
select * from datos_laborales --id_profesion,empresa_trabaja,domicilio_trabaja,telefono_laboral,email_laboral,id_persona,profesion
insert into datos_laborales(empresa_trabaja,domicilio_trabaja,telefono_laboral,email_laboral,id_persona,profesion)
select empresa,domicilio,tel_laboral,email_laboral,id as id_persona, profesion from temp_personas  p

/* datos_salud */
select * from datos_salud --cobertura_medica, apto_curso,observaciones_medicas,certificado_medico,id_persona,id_grupo_sanguineo
insert into datos_salud(cobertura_medica, apto_curso,observaciones_medicas,certificado_medico,id_persona,id_grupo_sanguineo)
select cobertura_medica,apto_curso,observaciones,id as id_persona, from temp_personas 

select distinct(grupo_sang) from temp_personas


create table temp_ciudades(
id serial not null,
ciudad character varying(200),
id_localidad integer,
constraint pk_temp_ciudades primary key (id));

insert into temp_ciudades(ciudad)
select distinct ciudad from temp_personas where ciudad is not null


select * from v_ciudades where cp='C1000-14xx'
select * from temp_personas where ciudad ilike '%CABA%' 
select * from temp_ciudades


select *,(select id from ciudades c where p.codigo_postal=c.cp limit 1) as id_ciudad
from temp_personas p 

select cp,count(1) from ciudades group by cp having count(1)>1
select * from v_ciudades where cp=3565
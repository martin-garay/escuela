create table registro_alumnos(
	id serial not null,
	id_titulo integer, 
	id_alumno integer not null,
	nro_registro integer not null,
	anio_registro integer not null,
	fecha date not null default now(),
	constraint pk_registro_alumnos primary key(id),
	constraint fk_registro_alumnos__titulos foreign key (id_titulo) references titulos_alumnos(id),
	constraint fk_registro_alumnos__alumnos foreign key (id_alumno) references personas(id),
	constraint uk_registro_alumnos UNIQUE (nro_registro),
	constraint uk_registro_alumnos2 UNIQUE (id_alumno)
);
create table ultimo_nro_registro(
	id serial not null,
	nro_registro integer not null,
	constraint pk_par_nro_registro primary key(id)
);
insert into ultimo_nro_registro(id,nro_registro) values (1,1);

create or replace view v_registros_alumnos as 
select r.id,r.id_titulo as id_titulo_alumno,r.id_alumno,r.nro_registro,r.anio_registro, to_char(r.nro_registro, 'fm0000')||'-'||substr(r.anio_registro::text,3,4) as nro_registro_completo,
	fecha as fecha_alta_registro,p.nombre,p.apellido,p.dni
from registro_alumnos r
inner join v_personas p ON r.id_alumno=p.id;


create view v_clases_teoricas_profesores as 
select cp.id,c.id as id_clase,clase_descripcion,c.fecha,hora_inicio,hora_fin,id_sede,sede, cp.id_profesor, p.apellido,p.nombre,p.dni,id_curso,nombre_curso,id_cursada,cursada_descripcion,id_modulo,nombre_modulo,mes_modulo,anio_modulo,
date_part('epoch'::text, c.hora_fin - c.hora_inicio) / 3600::double precision AS horas
from v_clases c
inner join clases_profesores cp ON cp.id_clase=c.id
inner join personas p ON p.id=cp.id_profesor;


create table usuario_sede(
	id serial not null,
	usuario character varying(60) not null,
	nombre text,	
	sedes text,
	constraint pk_usuario_sede primary key(id),
	constraint  uk_usuario_sede UNIQUE(usuario)
);

CREATE OR REPLACE FUNCTION public.get_sedes_usuario(_usuario character varying(60))
  RETURNS SETOF integer AS
$BODY$  
	SELECT id_sede::int FROM (SELECT UNNEST(regexp_split_to_array(sedes,',')) as id_sede from usuario_sede WHERE usuario=_usuario) as s  
$BODY$
LANGUAGE sql VOLATILE
COST 100
ROWS 1000;

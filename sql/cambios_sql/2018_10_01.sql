create table clases_practicas_cursos(
	id serial not null,
	id_clase integer not null,
	id_tipo_alumno integer,
	constraint pk_clases_practicas_cursos PRIMARY KEY (id),
	constraint fk_clases_practicas_cursos__tipos_clases_practicas FOREIGN KEY (id_clase) REFERENCES tipos_clases_practicas(id),
	constraint fk_clases_practicas_cursos__tipos_alumnos FOREIGN KEY (id_tipo_alumno) REFERENCES tipos_alumnos(id)
);

create table clases_practicas_cursos_detalle(
	id serial not null,
	id_curso integer not null,
	id_cabecera integer not null,
	constraint pk_clases_practicas_cursos_detalle PRIMARY KEY (id),
	constraint fk_clases_practicas_cursos_detalle__curso FOREIGN KEY (id_curso) REFERENCES cursos(id),
	constraint fk_clases_practicas_cursos_detalle__cabecera FOREIGN KEY (id_cabecera) REFERENCES clases_practicas_cursos(id)
);

create or replace view v_clases_practicas_cursos as 
select c.*, tcp.descripcion as clase,ta.descripcion as tipo_alumno,
	(select string_agg(cursos.nombre,',' order by cursos.nombre) from clases_practicas_cursos_detalle d inner join cursos ON cursos.id=d.id_curso WHERE id_cabecera=c.id GROUP BY id_cabecera ) as cursos
from clases_practicas_cursos c 
inner join tipos_clases_practicas tcp ON c.id_clase=tcp.id
left join tipos_alumnos ta ON ta.id=c.id_tipo_alumno;


DROP VIEW v_clases_practicas;
alter table calendario_clases_practicas add column horas numeric(10,2) not null default 1;

CREATE OR REPLACE VIEW v_calendario_clases_practicas AS 
 SELECT cp.id,
    cp.id_dia,
    cp.id_rango_horario,
    cp.hora_inicio,
    cp.hora_fin,
    cp.id_tipo_clase,
    cp.descripcion,
    cp.id_tipo_alumno,
    d.descripcion AS dia,
    tcp.descripcion AS tipo_clase,
    ta.descripcion AS tipo_alumno,
    cp.id_sede,
    cp.horas
   FROM calendario_clases_practicas cp
     JOIN dias d ON d.id = cp.id_dia
     JOIN tipos_clases_practicas tcp ON tcp.id = cp.id_tipo_clase
     LEFT JOIN tipos_alumnos ta ON ta.id = cp.id_tipo_alumno;

 create table clases_practicas(
	id serial not null,
	id_clase integer not null,
	fecha date not null,
	hora_inicio time without time zone not null,
	hora_fin time without time zone not null,
	id_tipo_alumno integer,
	id_sede integer not null,
	descripcion character varying (60),
	constraint pk_clases_practicas2 PRIMARY KEY (id),
	constraint fk_clases_practicas__tipos_clases FOREIGN KEY (id_clase) REFERENCES tipos_clases_practicas(id),
	constraint fk_clases_practicas__sede FOREIGN KEY (id_sede) REFERENCES sedes(id),
	constraint fk_clases_practicas__tipos_alumnos FOREIGN KEY (id_tipo_alumno) REFERENCES tipos_alumnos(id)
);
create table clases_practicas_profesores(
	id serial not null,
	id_profesor integer not null,
	id_clase_practica integer not null,
	constraint pk_clases_practicas_profesores PRIMARY KEY (id),
	constraint fk_clases_practicas_profesores__personas FOREIGN KEY (id_profesor) REFERENCES personas(id),
	constraint fk_clases_practicas_profesores__clases_practicas FOREIGN KEY (id_clase_practica) REFERENCES clases_practicas(id)
);
create table clases_practicas_alumnos(
	id serial not null,
	id_alumno integer not null,
	id_clase_practica integer not null,
	constraint pk_clases_practicas_alumnos PRIMARY KEY (id),
	constraint fk_clases_practicas_alumnos__personas FOREIGN KEY (id_alumno) REFERENCES personas(id),
	constraint fk_clases_practicas_alumnos__clases_practicas FOREIGN KEY (id_clase_practica) REFERENCES clases_practicas(id)
);

alter table clases_practicas add column horas integer not null default 1; --las horas que debe sumar por la clase
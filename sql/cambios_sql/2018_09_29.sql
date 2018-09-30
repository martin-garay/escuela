create table dias(
	id serial not null,
	descripcion character varying (10) not null,
	constraint pk_dias primary key(id)
);

create table rango_horario(
	id serial not null,
	hora_desde time without time zone NOT NULL,
	hora_hasta time without time zone NOT NULL,
	activo boolean not null default true,
	constraint pk_rango_horario primary key (id)
); 
create table tipos_alumnos(
	id serial not null,
	descripcion character varying (100),
	constraint pk_tipos_alumnos primary key (id)
);

create table tipos_clases_practicas(
	id serial not null,
	descripcion character varying (100) not null,
	constraint pk_tipos_clases_practicas primary key (id)
);

create table clases_practicas(
	id serial not null,
	id_dia integer not null,
	id_rango_horario integer not null,
	hora_inicio time without time zone NOT NULL,
	hora_fin time without time zone NOT NULL,
	id_tipo_clase integer not null,
	descripcion character varying (60),
	id_tipo_alumno integer,
	id_sede integer not null,
	constraint pk_clases_practicas primary key (id),
	constraint fk_clases_practicas__dias foreign key (id_dia) references dias(id),
	constraint fk_clases_practicas__rango_horario foreign key (id_rango_horario) references rango_horario(id),
	constraint fk_clases_practicas__tipos_alumnos foreign key (id_tipo_alumno) references tipos_alumnos(id)
);

insert into dias (id, descripcion) values (1,'LUNES');
insert into dias (id, descripcion) values (2,'MARTES');
insert into dias (id, descripcion) values (3,'MIERCOLES');
insert into dias (id, descripcion) values (4,'JUEVES');
insert into dias (id, descripcion) values (5,'VIERNES');
insert into dias (id, descripcion) values (6,'SABADO');
insert into dias (id, descripcion) values (7,'DOMINGO');


insert into rango_horario(id,hora_desde,hora_hasta) values(1,'8:00','9:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(2,'9:00','10:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(3,'10:00','11:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(4,'11:00','12:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(5,'15:00','16:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(6,'16:00','17:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(7,'18:00','19:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(8,'19:00','20:00');
insert into rango_horario(id,hora_desde,hora_hasta) values(9,'20:00','21:00');

insert into tipos_alumnos(descripcion) values('Alumnos Profesorado');
insert into tipos_alumnos(descripcion) values('Practicantes');

insert into tipos_clases_practicas(id,descripcion) values (1,'Purna Yoga');
insert into tipos_clases_practicas(id,descripcion) values (2,'Yoga Sandhya');
insert into tipos_clases_practicas(id,descripcion) values (3,'Yogaterapia');
insert into tipos_clases_practicas(id,descripcion) values (4,'Yoga Kurunta');
insert into tipos_clases_practicas(id,descripcion) values (5,'Yoga Dinamico');
insert into tipos_clases_practicas(id,descripcion) values (6,'Pranayamas');
insert into tipos_clases_practicas(id,descripcion) values (7,'Swara Yoga');
insert into tipos_clases_practicas(id,descripcion) values (8,'Yogaterapia Adultos Mayores');
insert into tipos_clases_practicas(id,descripcion) values (9,'Yoga');
insert into tipos_clases_practicas(id,descripcion) values (10,'Pranic B. Yoga');
insert into tipos_clases_practicas(id,descripcion) values (11,'MEDITACION');
insert into tipos_clases_practicas(id,descripcion) values (12,'Yoga Nidra');
insert into tipos_clases_practicas(id,descripcion) values (13,'TAI CHI');
insert into tipos_clases_practicas(id,descripcion) values (14,'Pranayamas y Swara Yoga');


----8 a 9
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (4, 1, '8:00', '9:00', 1, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (6, 1, '8:00', '9:00', 2, '1° y 2° sabado del mes', null,9);
--9 a 10
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (1, 2, '9:00', '10:00', 3, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (2, 2, '9:00', '10:00', 1, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (3, 2, '9:00', '10:00', 1, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (5, 2, '9:00', '10:00', 4, null, null,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (5, 2, '9:00', '10:00', 2, null, null,9);
--10 a 11
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (1, 3, '10:00', '11:00', 5, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (2, 3, '9:00', '10:00', 14, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (3, 3, '10:00', '11:00', 7, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (5, 3, '10:00', '11:00', 8, null, null,9);
--11 a 12
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (1, 4, '11:00', '12:00', 1, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (4, 4, '11:00', '12:00', 9, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (5, 4, '11:00', '12:00', 10, null, 2,9);
--15 a 16
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (2, 5, '15:00', '16:00', 4, 'Con elementos', null,9);
--16 a 17
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (2, 6, '16:00', '17:00', 8, null, null,9);
--18 a 19
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (1, 7, '18:00', '19:00', 11, null, null,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (2, 7, '18:00', '19:00', 12, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (3, 7, '18:00', '19:00', 1, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (4, 7, '18:00', '19:00', 1, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (4, 7, '18:00', '19:00', 13, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (5, 7, '18:00', '19:00', 3, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (6, 7, '18:00', '19:00', 1, null, 1,9);
--19 a 20
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (1, 8, '19:00', '20:00', 5, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (2, 8, '19:00', '20:00', 10, null, 2,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (3, 8, '19:00', '20:00', 5, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (5, 8, '19:00', '20:00', 11, null, null,9);
--20 a 21
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (1, 9, '20:00', '21:00', 7, null, 1,9);
INSERT INTO public.clases_practicas(id_dia, id_rango_horario, hora_inicio, hora_fin, id_tipo_clase, descripcion, id_tipo_alumno,id_sede)
VALUES (3, 8, '20:00', '21:00', 3, null, 2,9);


CREATE OR REPLACE VIEW public.v_clases_practicas AS 
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
    cp.id_sede
   FROM clases_practicas cp
     JOIN dias d ON d.id = cp.id_dia
     JOIN tipos_clases_practicas tcp ON tcp.id = cp.id_tipo_clase
     LEFT JOIN tipos_alumnos ta ON ta.id = cp.id_tipo_alumno;

--drop function generar_html_clase_practica(integer,integer)
CREATE OR REPLACE FUNCTION public.generar_string_clase_practica(
    _id_dia integer,
    _id_rango_horario integer,
    _id_sede integer,
    _html boolean)
  RETURNS text AS
$BODY$
DECLARE 	
	r record;
	salida_html text;
BEGIN   
	salida_html = '';
	for r in SELECT * FROM v_clases_practicas v WHERE v.id_rango_horario=_id_rango_horario and id_dia=_id_dia and id_sede=_id_sede ORDER  BY 1,id_dia
	loop
		IF _html THEN      
			salida_html = salida_html || '<table class="tabla_clase_practica"><tr><td><span class="clase_practica" id="'||r.id||'">';
			salida_html = salida_html || r.hora_inicio || ' ' || r.tipo_clase || COALESCE( '('||r.tipo_alumno||')', '')||COALESCE( ' '||r.descripcion, '');
			salida_html = salida_html || '</span></td></tr></table>' ;
		ELSE
			salida_html = salida_html || r.hora_inicio || ' ' || r.tipo_clase || COALESCE( '('||r.tipo_alumno||')', '')||COALESCE( ' '||r.descripcion, '')||' |';
		END IF;
	end loop;
	IF not _html THEN
		salida_html = substr(salida_html, 0, length(salida_html)); --le saco el ultimo separador si no es html la salida
	END IF;
	return salida_html;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


create view v_rango_horario as
select extract( hour from hora_desde)|| ' a '|| extract( hour from hora_hasta) as descripcion,* from rango_horario;
alter table clases_asistencia add column id_cursada_alumno integer not null;
alter table clases_asistencia add constraint fk_clases_asistencia__cursadas_alumnos foreign key(id_cursada_alumno) references cursadas_alumnos(id);
ALTER TABLE public.clases_asistencia DROP COLUMN id_alumno;

create or replace view v_asistencia_clases_teoricas as 
select a.*,
	cla.descripcion as descripcion_clase,cla.id_cursada as id_cursada_clase,cla.id_modulo as id_modulo_clase,
	cla.fecha as fecha_clase,cla.hora_inicio,cla.hora_fin, EXTRACT(epoch FROM hora_fin-hora_inicio )/3600 as cantidad_horas, --cla.hora_fin-cla.hora_inicio cantidad_horas,	
	ca.id_alumno,ca.id_cursada as id_cursada,ca.cursada as cursada_alumno,ca.id_condicion_alumno,ca.sede,
	ca.nombre_alumno,ca.apellido_alumno,ca.dni,ca.legajo,ca.email,ca.curso,cm.nro_modulo,cm.mes as mes_modulo,cm.anio as anio_modulo,
	cu.descripcion as cursada_clase,cu.id_sede as id_sede_clase,cu.sede as sede_clase
from clases_asistencia a
inner join clases cla ON a.id_clase=cla.id
inner join v_cursadas cu ON cu.id=cla.id_cursada
inner join v_cursadas_alumnos ca ON ca.id=a.id_cursada_alumno
inner join cursadas_modulos cm ON cm.id=cla.id_modulo;

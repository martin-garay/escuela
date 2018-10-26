
drop view if exists v_clases_practicas;
create view v_clases_practicas as 
select c.*,tcp.descripcion as tipo_clase_practica,s.nombre as sede, ta.descripcion as tipo_alumno
from clases_practicas c
inner join sedes s ON s.id=c.id_sede
inner join tipos_clases_practicas tcp ON tcp.id=c.id_tipo_clase
left join tipos_alumnos ta ON ta.id=c.id_tipo_alumno;

CREATE OR REPLACE VIEW v_clases_practicas_profesores AS 
 SELECT cpp.*,
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
		p.nombre,p.apellido,p.dni
FROM clases_practicas_profesores cpp
 JOIN v_clases_practicas c ON cpp.id_clase_practica = c.id
 JOIN personas p ON p.id=cpp.id_profesor;

 CREATE OR REPLACE VIEW v_clases_practicas_alumnos AS 
 SELECT cpa.*,
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
    p.nombre,p.apellido,p.dni
   FROM clases_practicas_alumnos cpa
     JOIN v_clases_practicas c ON cpa.id_clase_practica = c.id
     JOIN personas p ON p.id=cpa.id_alumno;

alter table par_clases_practicas_cursos add constraint uk_par_clases_practicas_cursos unique(id_tipo_clase,id_curso);



/*
--PROCESO PARA CALCULAR HORAS
begin transaction;
--guardo en temporal
select * into temp_clases_practicas_alumnos from clases_practicas_alumnos  
--select * from temp_clases_practicas_alumnos;

--borro tabla
delete from clases_practicas_alumnos;

--inserto para que el trigger calcule la asistencia
insert into clases_practicas_alumnos(id,id_alumno,id_clase_practica)
select id,id_alumno,id_clase_practica from temp_clases_practicas_alumnos 

--rollback
--commit
drop table temp_clases_practicas_alumnos;

*/
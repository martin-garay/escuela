CREATE OR REPLACE VIEW public.v_cursadas AS 
SELECT cu.id,
cu.descripcion,
cu.fecha_inicio,
cu.fecha_fin,
cu.id_curso,
c.nombre AS curso,
c.descripcion AS descripcion_curso,
c.duracion AS duracion_curso,
c.porcentaje_correlativa,
c.cant_minimo_alumnos,
c.cant_maxima_alumnos,
c.cant_modulos,
c.activo,
cu.id_sede,
s.nombre AS sede,
s.sede_descripcion,
cu.anio,
now()::date between fecha_inicio and fecha_fin as cursada_vigente    
FROM cursadas cu
 JOIN cursos c ON c.id = cu.id_curso
 JOIN v_sedes s ON s.id = cu.id_sede;
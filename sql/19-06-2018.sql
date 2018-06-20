CREATE TABLE tipo_persona_perfiles
(
  id serial NOT NULL,
  id_tipo_persona integer NOT NULL,
  perfil character varying(60),
  CONSTRAINT pk_tipo_persona_perfiles PRIMARY KEY (id),
  CONSTRAINT fk_tipo_persona_perfiles__tipo_persona FOREIGN KEY (id_tipo_persona)
      REFERENCES tipo_persona (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE tipo_persona_perfiles
  OWNER TO postgres;
COMMENT ON TABLE tipo_persona_perfiles
  IS 'Perfiles a asignar cuando se crea un usuario';

ALTER TABLE public.tipo_persona_perfiles
  ADD CONSTRAINT uk_tipo_persona_perfil UNIQUE(id_tipo_persona, perfil);

create view v_tipo_persona_perfiles as 
select tpp.id, id_tipo_persona,tp.descripcion as tipo_persona,perfil
from tipo_persona_perfiles tpp
inner join tipo_persona tp ON tp.id=tpp.id_tipo_persona;

CREATE TABLE public.perfiles
(
  perfil character varying(60) NOT NULL,
  CONSTRAINT pk_perfil PRIMARY KEY (perfil)
)
WITH (
  OIDS=FALSE
);

ALTER TABLE public.tipo_persona_perfiles
  ADD CONSTRAINT fk_tipo_persona_perfiles__perfil FOREIGN KEY (perfil)
      REFERENCES public.perfiles (perfil) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

create view v_ciudades as 
SELECT * FROM 
(SELECT c.*, pr.nombre as provincia, pr.id_pais, p.nombre as pais
FROM ciudades c 
INNER JOIN provincias pr ON c.id_provincia=pr.id
INNER JOIN paises p ON p.id=pr.id_pais) as s;

create view v_provincias as 
select pr.*, p.nombre as pais,p.nacionalidad
from provincias pr 
left join paises p ON p.id=pr.id_pais;
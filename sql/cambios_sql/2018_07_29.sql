create table tipo_alerta(
	id serial not null,
	descripcion character varying(255) not null,
	constraint pk_tipo_alerta primary key(id)
);
create table nivel_alerta(
	id serial not null,
	descripcion character varying(255) not null,
	constraint pk_tipo_nivel_alerta primary key(id)	
);
create table alertas(
	id serial not null,
	titulo character varying(60),
	descripcion character varying(255),
	id_tipo_alerta integer not null,	
	fecha_desde date,
	fecha_hasta date,
	activo boolean not null default true,
	fecha date not null default now(),
	constraint pk_alertas primary key(id),
	constraint fk_alertas__tipo_alerta foreign key(id_tipo_alerta) references tipo_alerta(id)
);
create table alertas_niveles(
	id serial not null,
	id_alerta integer not null,
	id_nivel_alerta integer not null,
	constraint pk_alertas_niveles primary key(id),
	constraint fk_alertas_niveles__alertas foreign key(id_alerta) references alertas(id),
	constraint fk_alertas_niveles__niveles foreign key(id_nivel_alerta) references nivel_alerta(id)
);

create view v_alertas as 
select a.*,ta.descripcion as tipo_alerta 
from alertas a
join tipo_alerta ta ON ta.id=a.id_tipo_alerta;
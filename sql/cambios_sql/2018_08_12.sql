CREATE OR REPLACE VIEW public.v_cuotas AS 
 SELECT c.id,
    c.mes,
    c.anio,
    c.id_curso,
    c.id_cursada,
    c.id_modulo,
    c.importe_cuota,
    c.observaciones,
    c.id_sede,
    c.fecha,
    c.fecha_operacion,
    c.usuario,
    cu.descripcion AS cursada,
    cu.curso,
    cu.sede,
    cu.cursada_vigente,
    cu.tipo_cursada,
    cm.descripcion AS modulo,
    cm.nro_modulo,
    date_part('year',fecha_operacion)||'-'||date_part('Month',fecha_operacion) as periodo
   FROM cuotas c
     JOIN v_cursadas cu ON cu.id = c.id_cursada
     JOIN cursadas_modulos cm ON cm.id = c.id_modulo;

ALTER TABLE public.caja_operaciones_diarias ALTER COLUMN fecha SET DEFAULT now();

-- View: public.v_caja_parametrizacion

-- DROP VIEW public.v_caja_parametrizacion;

CREATE OR REPLACE VIEW public.v_caja_parametrizacion AS 
 SELECT cp.id,
    cp.id_comprobante,
    cp.id_medio_pago,
    cp.id_movimiento,
    cp.id_cuenta,
    cp.id_subcuenta,
    cp.id_tipo_titular,
    cp.signo,
    cp.impacta_original,
    cp.envia_sub_cta,
    c.descripcion AS comprobante,
    c.id_tipo_comprobante,
    c.tipo_comprobante,
    c.activo AS comprobante_activo,
    c.dias_vencimiento,
    c.es_cancelatorio,
    mp.descripcion AS medio_pago,
    m.descripcion AS movimiento,
    m.activo AS movimiento_activo,
    m.id_operacion,
    m.operacion,
    m.operacion_activo,
    m.id_tipo_operacion,
    m.tipo_operacion,
    m.tipo_operacion_activo,
    cu.descripcion AS cuenta,
    cu.activo AS cuenta_activo,
    su.descripcion AS subcuenta,
    su.activo AS subcuenta_activo,
    tt.descripcion AS tipo_titular,
    tt.activo AS tipo_titular_activo,
        CASE
            WHEN cp.signo = 1 THEN '+'::text
            ELSE '-'::text
        END AS signo_str
   FROM caja_parametrizacion cp
     LEFT JOIN v_caja_comprobantes c ON c.id = cp.id_comprobante
     LEFT JOIN caja_medios_pagos mp ON mp.id = cp.id_medio_pago
     LEFT JOIN v_caja_movimientos m ON m.id = cp.id_movimiento
     LEFT JOIN caja_cuentas cu ON cu.id = cp.id_cuenta
     LEFT JOIN caja_subcuentas su ON su.id = cp.id_subcuenta
     LEFT JOIN caja_tipo_titulares tt ON tt.id = cp.id_tipo_titular;

ALTER TABLE public.v_caja_parametrizacion
  OWNER TO postgres;


ALTER TABLE public.clases ADD CONSTRAINT uk_clases UNIQUE(id_modulo, fecha, hora_inicio, hora_fin);

CREATE OR REPLACE VIEW public.v_cursadas_modulos AS 
 SELECT cm.id,
    cm.descripcion,
    cm.mes,
    cm.observaciones,
    cm.nombre,
    cm.id_cursada,
    cm.anio,
    (((cm.anio || '-'::text) || cm.mes) || '-01'::text)::date AS periodo,
    ((((cm.anio || '-'::text) || cm.mes) || '-01'::text)::date) >= (((((date_part('year'::text, now()) || '-'::text) || date_part('month'::text, now())) || '-'::text) || date_part('day'::text, now()))::date) AS modulo_vigente,
    c.descripcion AS cursada,
    c.id_curso,
    c.curso,
    c.descripcion_curso,
    c.duracion_curso,
    cm.orden,
    c.id_sede,
    c.sede,
    cm.nro_modulo,
    cm.fecha_inicio,
    cm.fecha_fin,
    cm.paga_cuota,
    cm.importe_cuota, c.id_tipo_cursada,c.tipo_cursada
   FROM cursadas_modulos cm
     JOIN v_cursadas c ON c.id = cm.id_cursada;

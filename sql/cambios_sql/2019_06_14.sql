
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
        END AS signo_str,
        CASE
            WHEN cp.signo = 1 THEN '<span style="color:green"><strong>SUMA</strong></span>'::text
            ELSE '<span style="color:red"><strong>RESTA</strong></span>'::text
        END AS signo_html
   FROM caja_parametrizacion cp
     LEFT JOIN v_caja_comprobantes c ON c.id = cp.id_comprobante
     LEFT JOIN caja_medios_pagos mp ON mp.id = cp.id_medio_pago
     LEFT JOIN v_caja_movimientos m ON m.id = cp.id_movimiento
     LEFT JOIN caja_cuentas cu ON cu.id = cp.id_cuenta
     LEFT JOIN caja_subcuentas su ON su.id = cp.id_subcuenta
     LEFT JOIN caja_tipo_titulares tt ON tt.id = cp.id_tipo_titular;


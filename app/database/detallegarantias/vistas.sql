DROP VIEW IF EXISTS v_listado_contratos_activos;
CREATE VIEW v_listado_contratos_activos AS
SELECT
    c.idcontrato,
    p.nombres AS inversionista_nombres,
    p.apellidos AS inversionista_apellidos,
    p.numdocumento AS inversionista_dni,
    c.capital AS monto_invertido,
    DATE_FORMAT(c.fechainicio, '%d-%m-%Y') AS fecha_inicio_contrato,
    DATE_FORMAT(c.fechafin, '%d-%m-%Y') AS fecha_fin_contrato,
    c.interes AS interes_contrato
FROM
    contratos c
JOIN
    inversionistas inv ON c.idinversionista = inv.idinversionista
JOIN
    personas p ON inv.idpersona = p.idpersona
WHERE
    c.estado = 'Vigente'
ORDER BY
    c.fechainicio DESC
LIMIT 10;

DROP VIEW IF EXISTS v_listado_proximos_pagos_pendientes;
CREATE VIEW v_listado_proximos_pagos_pendientes AS
SELECT
    cp.idcronogramapago,
    p.nombres AS inversionista_nombres,
    p.apellidos AS inversionista_apellidos,
    p.numdocumento AS inversionista_dni,
    cp.numcuota,
    cp.totalneto AS monto_cuota,
    DATE_FORMAT(cp.fechavencimiento, '%d-%m-%Y') AS fecha_vencimiento_cuota
FROM
    cronogramapagos cp
JOIN
    contratos c ON cp.idcontrato = c.idcontrato
JOIN
    inversionistas inv ON c.idinversionista = inv.idinversionista
JOIN
    personas p ON inv.idpersona = p.idpersona
WHERE
    cp.estado = 'Pendiente'
    AND cp.fechavencimiento >= CURDATE()
    AND c.estado = 'Vigente'
ORDER BY
    cp.fechavencimiento ASC
LIMIT 10;

DROP VIEW IF EXISTS v_listado_leads_en_proceso;
CREATE VIEW v_listado_leads_en_proceso AS
SELECT
    l.idlead,
    p.nombres AS lead_nombres,
    p.apellidos AS lead_apellidos,
    p.telprincipal AS lead_telefono,
    l.prioridad,
    l.estado AS estado_lead,
    CONCAT(u_p.nombres, ' ', u_p.apellidos) AS asesor_asignado
FROM
    leads l
JOIN
    personas p ON l.idpersona = p.idpersona
LEFT JOIN
    usuarios u ON l.idasesor = u.idusuario
LEFT JOIN
    colaboradores col ON u.idcolaborador = col.idcolaborador
LEFT JOIN
    personas u_p ON col.idpersona = u_p.idpersona
WHERE
    l.estado IN ('Nuevo contacto', 'En proceso')
ORDER BY
    l.fecharegistro DESC
LIMIT 10;

DROP VIEW IF EXISTS v_listado_contratos_por_vencer;
CREATE VIEW v_listado_contratos_por_vencer AS
SELECT
    c.idcontrato,
    p.nombres AS inversionista_nombres,
    p.apellidos AS inversionista_apellidos,
    p.numdocumento AS inversionista_dni,
    DATE_FORMAT(c.fechafin, '%d-%m-%Y') AS fecha_fin_contrato,
    c.capital AS monto_invertido
FROM
    contratos c
JOIN
    inversionistas inv ON c.idinversionista = inv.idinversionista
JOIN
    personas p ON inv.idpersona = p.idpersona
WHERE
    c.fechafin IS NOT NULL
    AND c.fechafin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 60 DAY)
    AND c.estado = 'Vigente'
ORDER BY
    c.fechafin ASC
LIMIT 10;

DROP VIEW IF EXISTS v_listado_colaboradores_activos;
CREATE VIEW v_listado_colaboradores_activos AS
SELECT
    col.idcolaborador,
    p.nombres AS colaborador_nombres,
    p.apellidos AS colaborador_apellidos,
    p.numdocumento AS colaborador_dni,
    r.rol AS rol_colaborador
FROM
    colaboradores col
JOIN
    personas p ON col.idpersona = p.idpersona
JOIN
    roles r ON col.idrol = r.idrol
WHERE
    p.estado = 'Activo'
ORDER BY
    p.apellidos ASC
LIMIT 10;



DROP VIEW IF EXISTS v_pagos_realizados_hoy;
CREATE VIEW v_pagos_realizados_hoy AS
SELECT
    dp.iddetallepago, -- Usamos iddetallepago como el identificador del pago
    p.nombres AS inversionista_nombres,
    p.apellidos AS inversionista_apellidos,
    p.numdocumento AS inversionista_dni,
    dp.monto AS monto_pagado,
    DATE_FORMAT(dp.fechahora, '%d-%m-%Y %H:%i') AS fecha_hora_pago
FROM
    detallepagos dp
JOIN
    cronogramapagos cp ON dp.idcronogramapago = cp.idcronogramapago
JOIN
    contratos c ON cp.idcontrato = c.idcontrato
JOIN
    inversionistas inv ON c.idinversionista = inv.idinversionista
JOIN
    personas p ON inv.idpersona = p.idpersona
WHERE
    DATE(dp.fechahora) = CURDATE() -- Filtrar por la fecha actual en la columna fechahora de detallepagos
ORDER BY
    dp.fechahora DESC;
















DROP VIEW IF EXISTS v_total_contratos_activos;
CREATE VIEW v_total_contratos_activos AS
SELECT COUNT(*) AS contratos_activos
FROM contratos
WHERE estado = 'Vigente';

DROP VIEW IF EXISTS v_monto_total_invertido;
CREATE VIEW v_monto_total_invertido AS
SELECT SUM(capital) AS monto_total_invertido
FROM contratos
WHERE estado = 'Vigente';

DROP VIEW IF EXISTS v_proximos_pagos_cantidad_30d;
CREATE VIEW v_proximos_pagos_cantidad_30d AS
SELECT COUNT(*) AS proximos_pagos_cantidad
FROM cronogramapagos cp
JOIN contratos c ON cp.idcontrato = c.idcontrato
WHERE cp.estado != 'Pagado'
AND cp.fechavencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
AND c.estado = 'Vigente';

DROP VIEW IF EXISTS v_proximo_pago_fecha_cercana;
CREATE VIEW v_proximo_pago_fecha_cercana AS
SELECT MIN(cp.fechavencimiento) AS proximo_pago_fecha
FROM cronogramapagos cp
JOIN contratos c ON cp.idcontrato = c.idcontrato
WHERE cp.estado != 'Pagado'
AND cp.fechavencimiento >= CURDATE()
AND c.estado = 'Vigente';

DROP VIEW IF EXISTS v_total_leads_en_proceso;
CREATE VIEW v_total_leads_en_proceso AS
SELECT COUNT(*) AS leads_en_proceso
FROM leads
WHERE estado IN ('Nuevo contacto', 'En proceso');

SELECT * FROM v_total_leads_en_proceso;
DROP VIEW IF EXISTS v_total_contratos_por_vencer_60d;
CREATE VIEW v_total_contratos_por_vencer_60d AS
SELECT COUNT(*) AS contratos_por_vencer
FROM contratos
WHERE fechafin IS NOT NULL
AND fechafin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 60 DAY)
AND estado = 'Vigente';

DROP VIEW IF EXISTS v_total_colaboradores_activos;
CREATE VIEW v_total_colaboradores_activos AS
SELECT COUNT(col.idcolaborador) AS colaboradores_activos
FROM colaboradores col
JOIN personas p ON col.idpersona = p.idpersona
WHERE p.estado = 'Activo';


DROP VIEW IF EXISTS v_total_pagos_realizados_hoy;
CREATE VIEW v_total_pagos_realizados_hoy AS
SELECT COUNT(iddetallepago) AS total_pagos_hoy
FROM detallepagos
WHERE DATE(fechahora) = CURDATE();

SELECT * FROM v_total_pagos_realizados_hoy









CREATE VIEW v_garantias_asociadas AS
SELECT
    dg.iddetallegarantia,        
    g.tipogarantia,                
    dg.porcentaje,
    dg.observaciones,  
    c.idcontrato,  
	CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo_inversionista, 
    c.capital  ,
     c.fechainicio,
    c.fechafin
                   


FROM
    detallegarantias AS dg
JOIN
    garantias AS g ON dg.idgarantia = g.idgarantia
JOIN
    contratos AS c ON dg.idcontrato = c.idcontrato
JOIN
    inversionistas AS i ON c.idinversionista = i.idinversionista
JOIN
    personas AS p ON i.idpersona = p.idpersona;
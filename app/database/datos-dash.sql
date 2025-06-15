USE financiera;

-- Vista para listar contratos activos (limitado a 10)
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
    c.fechainicio DESC;

-- Vista para listar próximos pagos pendientes (intervalo de 60 días)
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
    AND cp.fechavencimiento <= DATE_ADD(CURDATE(), INTERVAL 60 DAY)
    AND c.estado = 'Vigente'
ORDER BY
    cp.fechavencimiento ASC;

SELECT * FROM v_listado_proximos_pagos_pendientes;

-- Vista para listar leads en proceso (limitado a 10)
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
    l.fecharegistro DESC;

-- Vista para listar contratos por vencer (limitado a 10, próximos 60 días)
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
    c.fechafin ASC;

-- Vista para listar colaboradores activos (limitado a 10)
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
    p.apellidos ASC;

-- Vista para listar pagos realizados hoy
DROP VIEW IF EXISTS v_pagos_realizados_hoy;
CREATE VIEW v_pagos_realizados_hoy AS
SELECT
    dp.iddetallepago,
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
    DATE(dp.fechahora) = CURDATE()
ORDER BY
    dp.fechahora DESC;
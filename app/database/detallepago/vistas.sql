
USE financiera;
CREATE VIEW v_detalle_pagos AS

SELECT
    dp.iddetallepago AS iddetalle,
    dp.idnumcuenta AS idnumcuenta,
    CONCAT(pi.nombres, ' ', pi.apellidos) AS inversionsita,
    pi.numdocumento AS dni,
    nc.numcuenta AS cuentadepositada,
    ent.entidad AS entidad,
    dp.numtransaccion AS ntransaccion,
    dp.monto AS montopagado,
    dp.observaciones AS observaciones,
    cp.numcuota AS ncuota,
    cp.totalneto AS totalcuota,
    -- Aquí calculamos el estado de la cuota dinámicamente
    CASE
        -- Primero, verifica si la suma de pagos para esta cuota es >= al total de la cuota
        WHEN (SELECT SUM(dp2.monto)
              FROM detallepagos dp2
              JOIN cronogramapagos cp2 ON dp2.idcronogramapago = cp2.idcronogramapago
              WHERE cp2.idcronogramapago = cp.idcronogramapago) >= cp.totalneto THEN 'Pagado'
     
        WHEN cp.fechavencimiento < CURDATE() THEN 'Vencido'
        -- Si no está pagada y no ha vencido, es Pendiente
        ELSE 'Pendiente'
    END AS estado_cuota, -- <-- CAMBIO: Estado calculado
    CONCAT(pu.nombres, ' ', pu.apellidos) AS usuario,
    DATE_FORMAT(dp.fechahora, '%d-%m-%Y %H:%i') AS fechapago,
    DATE_FORMAT(cp.fechavencimiento, '%d-%m-%Y') AS fechavencimiento_cuota -- Añadimos la fecha de vencimiento
FROM
    detallepagos dp
JOIN
    cronogramapagos cp ON dp.idcronogramapago = cp.idcronogramapago
JOIN
    numcuentas nc ON dp.idnumcuenta = nc.idnumcuentas
JOIN
    entidades ent ON nc.identidad = ent.identidad
JOIN
    usuarios u ON dp.idusuariopago = u.idusuario
JOIN
    colaboradores col ON u.idcolaborador = col.idcolaborador
JOIN
    personas pu ON col.idpersona = pu.idpersona
JOIN
    contratos c ON cp.idcontrato = c.idcontrato
JOIN
    inversionistas inv ON c.idinversionista = inv.idinversionista
JOIN
    personas pi ON inv.idpersona = pi.idpersona;
    
    
CALL  v_detalle_pagos;
DROP VIEW  v_detalle_pagos;
SELECT * FROM v_detalle_pagos;
SELECT * FROM detallepagos;

SELECT * FROM usuarios;
















CREATE VIEW v_detalle_pagos AS
SELECT
    dp.iddetallepago AS iddetalle,
    dp.idnumcuenta AS idnumcuenta,
    c.idcontrato AS idcontrato, -- Añadido para filtrar por contrato en la vista
    CONCAT(pi.nombres, ' ', pi.apellidos) AS inversionsita,
    pi.numdocumento AS dni,
    nc.numcuenta AS cuentadepositada,
    ent.entidad AS entidad,
    dp.numtransaccion AS ntransaccion,
    dp.monto AS montopagado,
    dp.observaciones AS observaciones,
    cp.numcuota AS ncuota,
    cp.totalneto AS totalcuota,
    -- Aquí calculamos el estado de la cuota dinámicamente
    CASE
        -- Primero, verifica si la suma de pagos para esta cuota es >= al total de la cuota
        WHEN (SELECT SUM(dp2.monto)
              FROM detallepagos dp2
              WHERE dp2.idcronogramapago = cp.idcronogramapago) >= cp.totalneto THEN 'Pagado'
        WHEN cp.fechavencimiento < CURDATE()
            AND (SELECT SUM(dp3.monto) FROM detallepagos dp3 WHERE dp3.idcronogramapago = cp.idcronogramapago) < cp.totalneto THEN 'Vencido'
        -- Si no está pagada y no ha vencido, es Pendiente
        ELSE 'Pendiente'
    END AS estado_cuota,
    CONCAT(pu.nombres, ' ', pu.apellidos) AS usuario,
    DATE_FORMAT(dp.fechahora, '%d-%m-%Y %H:%i') AS fechapago,
    DATE_FORMAT(cp.fechavencimiento, '%d-%m-%Y') AS fechavencimiento_cuota,
    dp.comprobante AS comprobante -- Añadido el campo de comprobante
FROM
    detallepagos dp
JOIN
    cronogramapagos cp ON dp.idcronogramapago = cp.idcronogramapago
JOIN
    numcuentas nc ON dp.idnumcuenta = nc.idnumcuentas
JOIN
    entidades ent ON nc.identidad = ent.identidad
JOIN
    usuarios u ON dp.idusuariopago = u.idusuario
JOIN
    colaboradores col ON u.idcolaborador = col.idcolaborador
JOIN
    personas pu ON col.idpersona = pu.idpersona
JOIN
    contratos c ON cp.idcontrato = c.idcontrato -- Unimos con contratos para obtener idcontrato
JOIN
    inversionistas inv ON c.idinversionista = inv.idinversionista
JOIN
    personas pi ON inv.idpersona = pi.idpersona;
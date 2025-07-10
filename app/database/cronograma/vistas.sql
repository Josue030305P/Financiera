-- VISTA PARA UTILIZAR EN LA VISTA DESPUES DE PAGAR UNA CUOTA DE UN CONTRATO.
USE financiera;

-- CREATE VIEW vista_cronogramapagos AS
-- SELECT 
--     c.idcronogramapago,
--     c.idcontrato,
--     c.numcuota,
--     c.totalbruto,
--     c.totalneto,
--     c.amortizacion,
--     (c.totalneto - c.amortizacion) as restante,
--     c.fechavencimiento,
--     c.estado,
--     c.created_at,
--     c.updated_at
-- FROM cronogramapagos c; 


SELECT * FROM vista_cronogramapagos WHERE idcontrato=16;

DROP VIEW vista_cronogramapagos;


-- VISTA PARA UTILIZAR EN LA VISTA DE CRONOGRAMA DE PAGOS


DROP VIEW IF EXISTS vista_cronogramas_detallado;

CREATE VIEW vista_cronogramas_detallado AS
SELECT
    cp.idcronogramapago,
    cp.idcontrato,
    c.idinversionista,
    i.idpersona AS id_inversionista_persona,
    p.nombres AS nombre_inversionista,
    p.apellidos AS apellido_inversionista,
    p.numdocumento AS dni,
    cp.numcuota,
    DATE_FORMAT(cp.fechavencimiento, '%d-%m-%Y') AS fechavencimiento,
    cp.totalbruto,
    cp.totalneto,
    cp.amortizacion,
    (cp.totalneto - cp.amortizacion) as restante,
    cp.estado AS estado_pago,
    c.moneda AS moneda_contrato,
    DATE_FORMAT(c.fechainicio, '%d-%m-%Y') AS fecha_inicio_contrato,
    DATE_FORMAT(c.fechafin, '%d-%m-%Y') AS fecha_fin_contrato
FROM
    cronogramapagos cp
JOIN
    contratos c ON cp.idcontrato = c.idcontrato
JOIN
    inversionistas i ON c.idinversionista = i.idinversionista
LEFT JOIN
    personas p ON i.idpersona = p.idpersona
    
WHERE
    cp.estado NOT IN ('Eliminado') AND c.estado NOT IN ('Eliminado')





-- CREATE VIEW vista_cronogramas_detallado AS
-- SELECT
--     cp.idcronogramapago,
--     cp.idcontrato,
--     c.idinversionista,
--     i.idpersona AS id_inversionista_persona,
--     p.nombres AS nombre_inversionista,
--     p.apellidos AS apellido_inversionista,
--     p.numdocumento AS dni,
--     cp.numcuota,
--     DATE_FORMAT(cp.fechavencimiento, '%d-%m-%Y') AS fechavencimiento,
--     cp.totalbruto,
--     cp.totalneto,
--     cp.amortizacion,
-- 	(cp.totalneto - cp.amortizacion) as restante,
--     cp.estado AS estado_pago,
--     c.moneda AS moneda_contrato,
-- 	DATE_FORMAT(c.fechainicio, '%d-%m-%Y') AS fecha_inicio_contrato,
--     DATE_FORMAT(c.fechafin, '%d-%m-%Y') AS fecha_fin_contrato
 
-- FROM
--     cronogramapagos cp
-- JOIN
--     contratos c ON cp.idcontrato = c.idcontrato
-- JOIN
--     inversionistas i ON c.idinversionista = i.idinversionista
-- LEFT JOIN
--     personas p ON i.idpersona = p.idpersona;
    
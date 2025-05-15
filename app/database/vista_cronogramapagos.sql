CREATE VIEW vista_cronogramapagos AS
SELECT 
    c.idcronogramapago,
    c.idcontrato,
    c.numcuota,
    c.totalbruto,
    c.totalneto,
    c.amortizacion,
    (c.totalneto - c.amortizacion) as restante,
    c.fechavencimiento,
    c.estado,
    c.created_at,
    c.updated_at
FROM cronogramapagos c; 





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
    personas p ON i.idpersona = p.idpersona;
    
    
SELECT * FROM inversionistas;
SELECT * FROM personas;
DROP VIEW vista_cronogramas_detallado;
SELECT * FROM contratos;




    
    SELECT fecha_inicio_contrato FROM vista_cronogramas_detallado;
    

CREATE VIEW vista_contratos_activos AS
SELECT *
FROM contratos
WHERE estado = 'Vigente'; -- Ajusta el valor del estado si es diferente

-- Para verificar la vista:
SELECT * FROM vista_contratos_activos;





CREATE VIEW vista_contratos_proximos_finalizar AS
SELECT
    vc.idcontrato,
    vc.fechainicio,
    vc.fechafin,
    vc.moneda,
    vc.capital,
    vc.tiporetorno,
    vc.nombreinversionista,
    vc.nombreasesor,
    vc.banco,
    vc.garantia,
    vc.porcentaje_garantia
FROM vista_contratos vc
WHERE vc.fechafin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY);


CREATE VIEW vista_contratos_vigentes AS
SELECT
    vc.idcontrato,
    vc.fechainicio,
    vc.fechafin,
    vc.moneda,
    vc.capital,
    vc.tiporetorno,
    vc.nombreinversionista,
    vc.nombreasesor,
    vc.banco,
    vc.garantia,
    vc.porcentaje_garantia
FROM vista_contratos vc
WHERE vc.estado = 'Vigente';
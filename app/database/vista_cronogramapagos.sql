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
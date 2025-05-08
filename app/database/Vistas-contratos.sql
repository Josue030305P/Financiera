CREATE VIEW vista_contratos_resumida AS
SELECT
    c.idcontrato AS ID_Contrato,
    CONCAT(p_asesor.nombres, ' ', p_asesor.apellidos) AS Asesor,
    IF(i.idpersona IS NOT NULL, CONCAT(p_inver.nombres, ' ', p_inver.apellidos), e_inver.nombrecomercial) AS Inversionista,
    c.fechainicio AS Inicio,
    c.fechafin AS Fin,
    c.moneda AS Moneda,
    c.capital AS Capital,
    c.interes AS Interes_Porcentaje,
    c.periodopago AS Periodo,
    c.estado AS Estado
FROM
    contratos c
JOIN
    usuarios u_asesor ON c.idasesor = u_asesor.idusuario
JOIN
    colaboradores col ON u_asesor.idcolaborador = col.idcolaborador
JOIN
    personas p_asesor ON col.idpersona = p_asesor.idpersona
JOIN
    inversionistas i ON c.idinversionista = i.idinversionista
LEFT JOIN
    personas p_inver ON i.idpersona = p_inver.idpersona
LEFT JOIN
    empresas e_inver ON i.idempresa = e_inver.idempresa;
    
    
    
    
    
    
CREATE VIEW vista_contratos AS
SELECT 
    c.idcontrato,
    c.fechainicio,
    c.fechafin,
    c.moneda,
    c.capital,
    c.tiporetorno,
	CONCAT(p1.nombres , ' ', p1.apellidos ) AS nombreinversionista,
   CONCAT(p2.nombres , ' ', p2.apellidos ) AS nombreasesor,
    ent.entidad  AS banco,
    garant.tipogarantia AS garantia,
    dgarant.porcentaje AS porcentaje_garantia,
    c.estado
FROM contratos c
JOIN inversionistas i ON c.idinversionista = i.idinversionista
JOIN personas p1 ON i.idpersona = p1.idpersona  
JOIN usuarios u ON i.idasesor = u.idusuario
JOIN colaboradores col ON u.idcolaborador = col.idcolaborador
JOIN personas p2 ON col.idpersona = p2.idpersona  
JOIN numcuentas ncuent ON ncuent.idinversionista = i.idinversionista 
JOIN entidades ent ON ncuent.identidad = ent.identidad  
JOIN detallegarantias dgarant ON dgarant.idcontrato = c.idcontrato
JOIN garantias garant ON dgarant.idgarantia = garant.idgarantia 
ORDER BY c.fechainicio DESC;

SELECT * FROM vista_contratos;










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
CREATE VIEW vista_contratos_resumida AS
SELECT
    c.idcontrato AS ID_Contrato,
    CONCAT(p_asesor.nombres, ' ', p_asesor.apellidos) AS Asesor,
    CONCAT(p_asesor.numdocumento) AS dniAsesor,
    IF(i.idpersona IS NOT NULL, CONCAT(p_inver.nombres, ' ', p_inver.apellidos), e_inver.nombrecomercial) AS Inversionista,
    CONCAT(p_inver.numdocumento) AS dniInver,
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
    
    
DROP VIEW vista_contratos_resumida;
    
    
    
    
    
    
    
    
    
    
    
    
    
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


CREATE VIEW vista_contrato_pdf AS
SELECT 
    c.idcontrato,
    -- 1. Datos del Inversionista
    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_inversionista,
    p.numdocumento AS dni_inversionista,
    p.domicilio AS direccion_inversionista,
    -- 4. Ubicación del Inversionista
    CONCAT(d.distrito, ' - ', pr.provincia, ' - ', dep.departamento) AS ubicacion_inversionista,
    -- 5. Capital
    c.capital,
    -- 6. Datos bancarios
    e.entidad AS banco,
    nc.numcuenta,
    nc.cci,
    -- 7. Datos del cónyuge
    CONCAT(pc.nombres, ' ', pc.apellidos) AS nombre_conyuge,
    pc.numdocumento AS dni_conyuge,
    -- 8. Cronograma de pagos
    GROUP_CONCAT(
        CONCAT(
            cp.numcuota, '|',
            cp.fechavencimiento, '|',
            cp.totalbruto, '|',
            cp.totalneto
        )
        ORDER BY cp.numcuota
        SEPARATOR ';'
    ) AS cronograma_pagos
FROM 
    contratos c
    JOIN inversionistas i ON c.idinversionista = i.idinversionista
    JOIN personas p ON i.idpersona = p.idpersona
    LEFT JOIN personas pc ON c.idconyuge = pc.idpersona
    JOIN distritos d ON p.iddistrito = d.iddistrito
    JOIN provincias pr ON d.idprovincia = pr.idprovincia
    JOIN departamentos dep ON pr.iddepartamento = dep.iddepartamento
    LEFT JOIN numcuentas nc ON c.idcontrato = nc.idcontrato
    LEFT JOIN entidades e ON nc.identidad = e.identidad
    LEFT JOIN cronogramapagos cp ON c.idcontrato = cp.idcontrato
GROUP BY 
    c.idcontrato;
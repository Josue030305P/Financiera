
CREATE VIEW vista_contrato_pdf AS
SELECT 
    c.idcontrato,
    c.tiporetorno,
    c.fechainicio,
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
    
USE financiera;
DROP VIEW vista_contratos_resumida;
-- PROCEDIMIENTO PARA LA VISTA DE CONTRATOS

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
    empresas e_inver ON i.idempresa = e_inver.idempresa

    WHERE c.estado NOT IN ('Eliminado');


SELECT * FROM vista_contratos_resumida;
SELECT * FROM contratos;
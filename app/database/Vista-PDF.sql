

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
    
DROP VIEW  vista_contrato_pdf; 
SELECT * FROM contratos;
SELECT * FROM cronogramapagos;
SELECT * FROM usuarios;
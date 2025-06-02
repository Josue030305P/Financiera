
USE financiera;

-- CREATE VIEW lista_leads AS
-- SELECT
--     l.idlead,
--     CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo,
--     p.email,
--     p.telprincipal,
--     c.canal AS canal_contacto,
--     DATE_FORMAT(l.fecharegistro, '%d-%m-%Y %H:%i:%s') AS fecharegistro,
--     l.prioridad,
--     l.estado,
--     CONCAT(pa.nombres, ' ', pa.apellidos) AS asesor 
-- FROM leads l
-- JOIN personas p ON l.idpersona = p.idpersona
-- JOIN canales c ON l.idcanal = c.idcanal
-- LEFT JOIN usuarios u ON l.idasesor = u.idusuario
-- LEFT JOIN colaboradores co ON u.idcolaborador = co.idcolaborador 
-- LEFT JOIN personas pa ON co.idpersona = pa.idpersona 
-- WHERE l.estado NOT IN ('Inactivo', 'Inversionista');

ALTER VIEW lista_leads AS
SELECT
    l.idlead,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo,
    p.email,
    p.telprincipal,
    c.canal AS canal_contacto,
    DATE_FORMAT(l.fecharegistro, '%d-%m-%Y %H:%i:%s') AS fecharegistro,
    l.prioridad,
    l.estado,
    CONCAT(pa.nombres, ' ', pa.apellidos) AS asesor,
    -- NUEVAS COLUMNAS AÑADIDAS:
    COUNT(cont.idcontactibilidad) AS total_contactos,
    CASE
        WHEN COUNT(cont.idcontactibilidad) >= 1 AND l.estado NOT IN ('Inactivo', 'Inversionista') THEN TRUE
        ELSE FALSE
    END AS puede_ser_inversionista
FROM
    leads l
JOIN
    personas p ON l.idpersona = p.idpersona
JOIN
    canales c ON l.idcanal = c.idcanal
LEFT JOIN
    usuarios u ON l.idasesor = u.idusuario
LEFT JOIN
    colaboradores co ON u.idcolaborador = co.idcolaborador
LEFT JOIN
    personas pa ON co.idpersona = pa.idpersona
LEFT JOIN 
    contactibilidad cont ON l.idlead = cont.idlead
WHERE
    l.estado NOT IN ('Inactivo', 'Inversionista')
GROUP BY
    l.idlead,
    nombre_completo, 
    p.email,
    p.telprincipal,
    c.canal,
    l.fecharegistro,
    l.prioridad,
    l.estado,
    asesor 
ORDER BY
    l.idlead;


CREATE VIEW v_lead_to_inversionista AS
SELECT
    l.idlead,
    p.idpersona,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombrecompleto,
    p.tipodocumento,
    p.numdocumento,
    p.domicilio,
    p.referencia,
    p.fechanacimiento,
    p.telprincipal AS telefono,
    u.idusuario AS idasesor,
    CONCAT(p_asesor.nombres, ' ', p_asesor.apellidos) AS nombreasesor,
    l.fecharegistro AS fecharegistrolead
FROM leads l
JOIN personas p ON l.idpersona = p.idpersona
LEFT JOIN usuarios u ON l.idasesor = u.idusuario
LEFT JOIN colaboradores c ON u.idcolaborador = c.idcolaborador
LEFT JOIN personas p_asesor ON c.idpersona = p_asesor.idpersona
LEFT JOIN roles r ON c.idrol = r.idrol
WHERE r.rol = 'Asesor de inversión';


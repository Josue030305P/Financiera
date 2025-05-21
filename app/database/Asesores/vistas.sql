-- Vista para sesores

CREATE VIEW list_asesores AS
SELECT 
	u.idusuario,
	CONCAT(p.nombres, ' ',p.apellidos ) AS nombrecompleto,
    r.rol AS rol_colaborador
FROM 
    colaboradores c
INNER JOIN 
    roles r ON c.idrol = r.idrol
INNER JOIN 
    personas p ON c.idpersona = p.idpersona
INNER JOIN usuarios u  ON c.idcolaborador = u.idcolaborador
WHERE 
    r.rol = 'Asesor de inversión';




CREATE  VIEW v_asesor_lead AS
SELECT 
    l.idlead,
    p.idpersona,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_lead,
    u.idusuario AS idasesor,
    CONCAT(p_asesor.nombres, ' ', p_asesor.apellidos) AS nombreasesor,
    l.fecharegistro AS fecharegistrolead
FROM 
    leads l
INNER JOIN 
    personas p ON l.idpersona = p.idpersona
LEFT JOIN 
    usuarios u ON l.idasesor = u.idusuario
LEFT JOIN 
    colaboradores c ON u.idcolaborador = c.idcolaborador
LEFT JOIN 
    personas p_asesor ON c.idpersona = p_asesor.idpersona
LEFT JOIN 
    roles r ON c.idrol = r.idrol
    WHERE 
    r.rol = 'Asesor de inversión';



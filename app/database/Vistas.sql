-- Vista para contratos;
USE financiera;

SELECT * FROM usuarios;
SELECT * FROM leads;
-- Vista para leads

CREATE VIEW lista_leads AS
SELECT
    l.idlead,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo,
    p.email,
    p.telprincipal,
    c.canal AS canal_contacto,
    DATE_FORMAT(l.fecharegistro, '%d-%m-%Y %H:%i:%s') AS fecharegistro,
    l.prioridad,
    l.estado,
    CONCAT(pa.nombres, ' ', pa.apellidos) AS asesor 
FROM leads l
JOIN personas p ON l.idpersona = p.idpersona
JOIN canales c ON l.idcanal = c.idcanal
LEFT JOIN usuarios u ON l.idasesor = u.idusuario
LEFT JOIN colaboradores co ON u.idcolaborador = co.idcolaborador 
LEFT JOIN personas pa ON co.idpersona = pa.idpersona 
WHERE NOT l.estado = 'Inactivo';


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



CREATE VIEW list_inversionistas AS
SELECT
    inv.idinversionista,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombrecompleto,
    cont.capital,
    GROUP_CONCAT(DISTINCT nc.numcuenta SEPARATOR ', ') AS numeros_cuenta,
    GROUP_CONCAT(DISTINCT nc.cci SEPARATOR ', ') AS cci_cuentas,
    GROUP_CONCAT(DISTINCT ent.tipo SEPARATOR ', ') AS tipos_entidad,
    GROUP_CONCAT(DISTINCT ent.entidad SEPARATOR ', ') AS nombres_entidad,

    CONCAT(p_asesor.nombres, ' ', p_asesor.apellidos) AS nombre_completo_asesor
FROM
    inversionistas inv
LEFT JOIN
    personas p ON inv.idpersona = p.idpersona
LEFT JOIN
    contratos cont ON inv.idinversionista = cont.idinversionista
LEFT JOIN
    numcuentas nc ON cont.idcontrato = nc.idcontrato
LEFT JOIN
    entidades ent ON nc.identidad = ent.identidad
LEFT JOIN
    usuarios u ON inv.idasesor = u.idusuario
LEFT JOIN
    colaboradores col ON u.idcolaborador = col.idcolaborador
LEFT JOIN
    personas p_asesor ON col.idpersona = p_asesor.idpersona 
GROUP BY
    inv.idinversionista,
    p.nombres,
    p.apellidos,
    cont.capital,
   
    p_asesor.nombres,
    p_asesor.apellidos;
    


CREATE VIEW list_contactibilidad AS
	SELECT 
	cont.idcontactibilidad,
	CONCAT(per.nombres, ' ', per.apellidos) AS nombre_completo,
    per.telprincipal AS telefono,
    per.email,
    l.ocupacion,
	DATE_FORMAT(cont.fecha, '%d-%m-%Y') as fecha,
    cont.hora,
    cont.comentarios,
    u.usuario AS asesor,
    cont.estado
    FROM contactibilidad cont
    JOIN leads l ON l.idlead = cont.idlead 
    JOIN personas per ON l.idpersona = per.idpersona
    JOIN usuarios u ON l.idasesor = u.idusuario;
    


SELECT * FROM contactibilidad;


-- ROLES DE USUARIOS

CREATE VIEW vista_usuarios_roles AS
SELECT u.idusuario, u.usuario, r.rol
FROM usuarios u
JOIN colaboradores c ON u.idcolaborador = c.idcolaborador
JOIN roles r ON c.idrol = r.idrol;

SELECT * FROM leads;
SELECT * FROM personas;

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


SELECT * FROM v_lead_to_inversionista WHERE idlead = 2;
SELECT * FROM personas;
SELECT * FROM inversionistas;
SELECT * FROM empresas;
SELECT * FROM contratos;


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






















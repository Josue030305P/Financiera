-- Vista para contratos;

CREATE VIEW vista_contratos AS
SELECT 
    c.idcontrato,
    c.fechainicio,
    c.fechafin,
    c.moneda,
    c.capital,
    c.tiporetorno,
    p1.nombres AS inversionista,
    p1.apellidos AS apellidos_inversionista,
    p2.nombres AS asesor,
    p2.apellidos AS apellidos_asesor,
    ent.entidad  AS banco,
    garant.tipogarantia AS garantia,
    dgarant.porcentaje AS porcentaje_garantia
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

DROP VIEW lista_leads;


SELECT * FROM leads;
-- Vista para leads
CREATE VIEW lista_leads AS
SELECT 
    l.idlead,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo,
    p.email,
    p.telprincipal,
    c.canal AS canal_contacto,
 DATE_FORMAT(l.fecharegistro, '%d-%m-%Y %H:%i:%s') as fecharegistro,
    l.prioridad,
    l.estado,
    u.usuario AS asesor
FROM leads l
JOIN personas p ON l.idpersona = p.idpersona
JOIN canales c ON l.idcanal = c.idcanal
LEFT JOIN usuarios u ON l.idasesor = u.idusuario
WHERE l.estado = 'Nuevo contacto' AND NOT l.estado = 'Inactivo';

SELECT * FROM lista_leads;

SELECT  * FROM personas;
SELECT * FROM leads;
SELECT * FROM  canales;

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
    
SELECT * FROM list_asesores;
DROP VIEW list_asesores ;


    


CREATE VIEW list_inversionistas AS
SELECT
    inv.idinversionista,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombrecompleto,
    cont.capital,
    nc.numcuenta,
    nc.cci,
    ent.tipo,
    ent.entidad,
    u.usuario 

FROM inversionistas inv
LEFT JOIN personas p ON inv.idpersona = p.idpersona
LEFT JOIN numcuentas nc ON inv.idinversionista = nc.idinversionista
LEFT JOIN entidades ent ON nc.identidad = ent.identidad
LEFT JOIN contratos cont ON inv.idinversionista = cont.idinversionista
LEFT JOIN usuarios u ON inv.idasesor = u.idusuario;

SELECT * FROM list_inversionistas ;



SELECT * FROM personas;
SELECT * FROM inversionistas;

SELECT * FROM usuarios;
USE financiera;

SELECT * FROM leads;
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
    

-- DROP VIEW list_contactibilidad;



SELECT * FROM contactibilidad;










































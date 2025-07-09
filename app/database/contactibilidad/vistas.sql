
USE financiera;

DROP VIEW list_contactibilidad ;
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
    JOIN usuarios u ON l.idasesor = u.idusuario
    WHERE cont.estado NOT IN ('Eliminado')
     ORDER BY cont.idcontactibilidad DESC;
    
SELECT * FROM contactibilidad;
select * from usuarios;

SELECT * FROM personas;
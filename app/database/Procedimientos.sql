DELIMITER //

CREATE PROCEDURE sp_update_personas(
	IN idpersona_ INT,
	IN tipodocumento_ ENUM('DNI','PSP','CEX'),
	IN numdocumento_  VARCHAR(12),
	IN idpais_		   INT,
	IN iddistrito_	   INT,
	IN apellidos_	   VARCHAR(70),
	IN nombres_		   VARCHAR(70),
	IN fechanacimiento_ VARCHAR(10),  
	IN email_		   VARCHAR(100),
	IN domicilio_	   VARCHAR(100),
	IN telprincipal_   CHAR(9),
	IN telsecundario_  CHAR(9),
	IN referencia_	   VARCHAR(150)
)
BEGIN
	UPDATE personas
	SET 
		tipodocumento = tipodocumento_,
        numdocumento = numdocumento_,
		idpais = idpais_,
		iddistrito = iddistrito_,
		apellidos = apellidos_,
		nombres = nombres_,
		fechanacimiento = STR_TO_DATE(fechanacimiento_, '%d-%m-%Y'),  
		email = email_,
		domicilio = domicilio_,
		telprincipal = telprincipal_,
		telsecundario = telsecundario_,
		referencia = referencia_
	WHERE idpersona = idpersona_;
END //

DELIMITER ;

CALL sp_update_personas(1, 'DNI', '767282782', 1, 1, 'Meneses Fuentes', 'Paola Manuela', '03-05-2005', 'poala@example.com', 'Grocio Prado - Av Carrizo', '987654851', '985658255', 'Plaza de armas');

UPDATE leads SET estado = 'Nuevo contacto' WHERE idlead = 1;

SELECT * FROM personas;
SELECT * FROM leads;


DELIMITER //

CREATE PROCEDURE sp_buscar_persona_dni(
IN dni_ CHAR(8)
)
BEGIN
		SELECT * FROM personas WHERE tipodocumento = 'DNI' AND numdocumento = dni_;

END //

DELIMITER ;

CALL sp_buscar_persona_dni('58787777');





/* DELIMITER //

CREATE PROCEDURE sp_getByIdLead(
IN idelad INT
)
BEGIN
	SELECT l.*, p.idpais, p.apellidos, p.nombres, p.email, p.telprincipal 
                    FROM leads l 
                    JOIN personas p ON l.idpersona = p.idpersona 
                    WHERE l.idlead = ?
END 

DELIMITER //

*/
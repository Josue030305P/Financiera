DELIMITER //
CREATE PROCEDURE sp_buscar_persona_dni(
IN dni_ CHAR(8)
)
BEGIN
		SELECT * FROM personas WHERE tipodocumento = 'DNI' AND numdocumento = dni_;

END //

DELIMITER ;




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

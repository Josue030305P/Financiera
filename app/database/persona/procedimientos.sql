
DELIMITER //
CREATE PROCEDURE sp_add_conyuge(
IN idpais_		INT,
IN apellidos_	VARCHAR(70),
IN nombres_		VARCHAR(70),
IN tipodocumento_ ENUM('DNI','PSP','CEX'),
IN numdocumento_  VARCHAR(12),
IN email_		VARCHAR(100),
IN telprincipal_ VARCHAR(15),
IN domicilio_ VARCHAR(100)

)
BEGIN

	INSERT INTO personas(idpais,apellidos,nombres,tipodocumento,numdocumento,email,telprincipal,domicilio)
		VALUES(idpais_,apellidos_,nombres_,tipodocumento_,numdocumento_,email_,telprincipal_,domicilio_);
        
		SELECT LAST_INSERT_ID() AS idconyuge;

END //

DELIMITER ;

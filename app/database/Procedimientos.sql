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

CALL sp_buscar_persona_dni('71882015');


-- Agregar Conyuge

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

END //

DELIMITER ;

CALL  sp_add_conyuge(1,'Pilpe Yataco','Isai','DNI','71882016','isai@gmail.com','919482381');


SELECT * FROM personas;


DELIMITER //
CREATE PROCEDURE sp_add_empresa(
IN nombrecomercial_ VARCHAR(100),
IN direccion_		VARCHAR(100),
IN ruc_				CHAR(11),
IN razonsocial_		VARCHAR(300)
)
BEGIN
	INSERT INTO empresas(nombrecomercial, direccion, ruc, razonsocial)
		VALUES(nombrecomercial_, direccion_, ruc_, razonsocial_);
END //
DELIMITER ;

CALL  sp_add_empresa('Pepe el grillo', 'Al frente de la pista', '12345678911', 'Señor Pepe el grillo');
SELECT * FROM empresas;

DELIMITER //

CREATE PROCEDURE sp_add_inversionista(
IN idpersona_ 		INT,
IN idempresa_ 		INT,
IN idasesor_		INT,
IN idusuariocreacion_ INT
)
BEGIN
	INSERT INTO empresas(idpersona, idempresa, idasesor, idusuariocreacion)
		VALUES (idpersona_, idempresa_, idasesor_, idusuariocreacion_);
END //

DELIMITER ;
SELECT * FROM inversionistas;







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
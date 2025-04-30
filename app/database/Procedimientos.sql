USE financiera;

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
        
		SELECT LAST_INSERT_ID() AS idconyuge;

END //

DELIMITER ;

CALL  sp_add_conyuge(1,'Meneses Alvárez','Flor','DNI','85856954','floralvarez@gmail.com','956859858','dsds');

DROP PROCEDURE sp_add_conyuge;
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
             SELECT LAST_INSERT_ID() AS idempresa;
END //
DELIMITER ;


DROP PROCEDURE sp_add_empresa;

CALL  sp_add_empresa('todo yo', 'Al frente de la pista', '56585859854', 'todo yooyoyoyyoy');
SELECT * FROM empresas;
SELECT * FROM usuarios;
SELECT * FROM inversionistas;


DELIMITER //
CREATE PROCEDURE sp_add_inversionista(
IN idpersona_ 		INT,
IN idempresa_ 		INT,
IN idasesor_		INT,
IN idusuariocreacion_ INT
)
BEGIN
	INSERT INTO inversionistas(idpersona, idempresa, idasesor, idusuariocreacion)
		VALUES (idpersona_, idempresa_, idasesor_, idusuariocreacion_);

         SELECT LAST_INSERT_ID() AS idinversionista;
END //
DELIMITER ;

CALL sp_add_inversionista(11,1,1,1);

SELECT * FROM usuarios;

SELECT * FROM inversionistas;

DELIMITER //
CREATE PROCEDURE sp_add_contrato(
IN idversion_		INT,
IN idasesor_		INT,
IN idinversionista_	INT,
IN idconyuge_		INT,   -- ES EL ID DE PERSONA que se agregado.
IN idusuariocreacion_ INT,
IN fechainicio_		DATE,
IN fechafin_		DATE,
IN fecharetornocapital_ DATE,
IN impuestorenta_	DECIMAL(5,2),
IN toleranciadias_  TINYINT,
IN duracionmeses_	TINYINT,
IN moneda_			ENUM('PEN','USD'),
IN diapago_			TINYINT,
IN interes_			DECIMAL(5,2),
IN capital_			DECIMAL(10,2),
IN tiporetorno_		ENUM('Fijo','Variable'),
IN periodopago_		VARCHAR(30) ,
IN observacion_		VARCHAR(100)
)
BEGIN
	INSERT INTO contratos(idversion,idasesor,idinversionista,idconyuge,idusuariocreacion,fechainicio,fechafin,
						fecharetornocapital,impuestorenta,toleranciadias,duracionmeses,moneda,diapago,interes,capital,
                        tiporetorno,periodopago,observacion)
                        VALUES
                        (idversion_,idasesor_,idinversionista_,idconyuge_,idusuariocreacion_,fechainicio_,fechafin_,
						fecharetornocapital_,impuestorenta_,toleranciadias_,duracionmeses_,moneda_,diapago_,interes_,capital_,
                        tiporetorno_,periodopago_,observacion_);
END //
DELIMITER ;

CALL sp_add_contrato(1,2,1,7,1,now(),'2026-23-04',NULL,'5','3','12','PEN','23','5','20000','Fijo','Mensual','Nuevo contrato cerrado');

UPDATE contratos SET
 fechafin = '2026-04-23' 
 WHERE idcontrato = 1;

SELECT * FROM usuarios;
SELECT * FROM contratos;
SELECT * FROM inversionistas;
SELECT * FROM personas;
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
USE financiera;

SELECT * FROM personas;
SELECT * FROM colaboradores;

SELECT * FROM roles;
SELECT * FROM usuarios;
SHOW COLUMNS FROM usuarios;

DELIMITER //
CREATE PROCEDURE sp_add_persona_usuario(
IN idpais_		INT,
IN apellidos_	VARCHAR(70),
IN nombres_		VARCHAR(70),
IN fechanacimiento_  DATE,
IN tipodocumento_ ENUM('DNI','PSP','CEX'),
IN numdocumento_  VARCHAR(12),
IN email_		VARCHAR(100),
IN telprincipal_ VARCHAR(15),
IN domicilio_ VARCHAR(100)

)
BEGIN

	INSERT INTO personas(idpais,apellidos,nombres,fechanacimiento,tipodocumento,numdocumento,email,telprincipal,domicilio, estado)
		VALUES(idpais_,apellidos_,nombres_,fechanacimiento_,tipodocumento_,numdocumento_,email_,telprincipal_,domicilio_,'Usuario');

END //

DELIMITER ;

-- CALL sp_add_persona_usuario(1,'Jiarafales', 'Pedro','1990-06-18','DNI','66777655','pedrojirafe@gmail.com','966585596','AV CARRIZO #554 - GROCIO PRADO - CHINCHA');

DROP PROCEDURE sp_add_colaborador_usuario

DELIMITER //
CREATE PROCEDURE sp_add_colaborador_usuario(
IN idpersona_ INT,
IN idrol_    INT,
IN idusuariocreacion_ INT,
IN fechainicio_ DATE,
IN fechafin_    DATE,
IN observaciones_ VARCHAR(100)
)
BEGIN

	INSERT INTO colaboradores(idpersona,idrol,idusuariocreacion,fechainicio,fechafin,observaciones)
		VALUES(idpersona_,idrol_,idusuariocreacion_,fechainicio_,fechafin_,observaciones_);

END //

DELIMITER ;

-- CALL sp_add_colaborador_usuario(31,1,1,'2025-06-16','2026-06-16','Contrato de un año');



DELIMITER //
CREATE PROCEDURE sp_add_usuario(
IN idcolaborador_  INT,
IN usuario_	VARCHAR(40),
IN passworduser_	VARCHAR(255),
IN fotoperfil_  VARCHAR(140)
)
BEGIN

	INSERT INTO usuarios(idcolaborador, usuario, passworduser, fotoperfil)
                VALUES(idcolaborador_, usuario_, passworduser_, fotoperfil_);
END //

DELIMITER ;
CALL sp_add_usuario(5,'jirafales2025','12345','uploads/perfilusuario/jirafales.jpg');

SELECT * FROM detallepagos; 

-- UPDATE personas SET estado = 'Usuario' WHERE idpersona = 4;



-- idpersona = 1, 2, 3 ,4 , 31

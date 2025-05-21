
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

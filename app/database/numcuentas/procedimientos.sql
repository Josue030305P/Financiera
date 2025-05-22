
USE financiera;
DELIMITER //
CREATE PROCEDURE sp_numcuenta_contrato(
IN idcontrato_ INT,
IN identidad_	INT,
IN idusuariocreacion_ INT,
IN numcuenta_	VARCHAR(30),
IN cci_         VARCHAR(30) ,
IN observaciones_ VARCHAR(100) 
)
BEGIN

	INSERT INTO numcuentas(idcontrato,identidad,idusuariocreacion,numcuenta,cci,observaciones)
		VALUES (idcontrato_,identidad_,idusuariocreacion_,numcuenta_,cci_,observaciones_);


END //

DELIMITER $

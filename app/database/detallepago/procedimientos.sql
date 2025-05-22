
USE financiera;
DELIMITER //


CREATE PROCEDURE sp_add_detallepago_cronograma(
IN idcronogramapago_ INT,
IN idusuariopago_   INT,
IN idnumcuenta_      INT,
IN numtransaccion_ VARCHAR(30),
IN fechahora_    DATETIME,
IN monto_    DECIMAL(10,2),
IN observaciones_ VARCHAR(180)

)
BEGIN
  INSERT INTO detallepagos(idcronogramapago, idusuariopago, idnumcuenta, numtransaccion, fechahora, monto, observaciones)
    VALUES(idcronogramapago_,idusuariopago_,idnumcuenta_, numtransaccion_, fechahora_, monto_,observaciones_ );

END //

DELIMITER ;

SELECT * FROM detallepagos;
DROP PROCEDURE  sp_add_detallepago_cronograma;

SELECT * FROM numcuentas;
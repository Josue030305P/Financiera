USE financiera;

DELIMITER / /

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

DELIMITER;

DELIMITER / /

CREATE PROCEDURE sp_numcuenta_by_idcontrato(
IN idcontrato_ INT
)
BEGIN

  SELECT numcuenta FROM numcuentas WHERE idcontrato = idcontrato_;

END //

DELIMITER;

SELECT * FROM detallepagos;

SELECT numcuenta FROM numcuentas WHERE idcontrato = 2;
DROP PROCEDURE sp_add_detallepago_cronograma;

SELECT * FROM numcuentas;
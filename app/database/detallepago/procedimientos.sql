
USE financiera;

DELIMITER / /

CREATE PROCEDURE sp_add_detallepago_cronograma(
IN idcronogramapago_ INT,
IN idusuariopago_   INT,
IN idnumcuenta_      INT,
IN numtransaccion_ VARCHAR(30),
IN fechahora_    DATETIME,
IN monto_    DECIMAL(10,2),
IN observaciones_ VARCHAR(180),
IN comprobante_ TEXT

)
BEGIN
  INSERT INTO detallepagos(idcronogramapago, idusuariopago, idnumcuenta, numtransaccion, fechahora, monto, observaciones,comprobante)
    VALUES(idcronogramapago_,idusuariopago_,idnumcuenta_, numtransaccion_, fechahora_, monto_,observaciones_,comprobante_ );

END //

DELIMITER;

-- USE financiera;

-- DELIMITER / /

-- CREATE PROCEDURE sp_add_detallepago_cronograma(
-- IN idcronogramapago_ INT,
-- IN idusuariopago_   INT,
-- IN idnumcuenta_      INT,
-- IN numtransaccion_ VARCHAR(30),
-- IN fechahora_    DATETIME,
-- IN monto_    DECIMAL(10,2),
-- IN observaciones_ VARCHAR(180)

-- )
-- BEGIN
--   INSERT INTO detallepagos(idcronogramapago, idusuariopago, idnumcuenta, numtransaccion, fechahora, monto, observaciones)
--     VALUES(idcronogramapago_,idusuariopago_,idnumcuenta_, numtransaccion_, fechahora_, monto_,observaciones_ );

-- END //

-- DELIMITER;

DROP PROCEDURE sp_add_detallepago_cronograma

DELIMITER / /

DELIMITER //

CREATE PROCEDURE sp_numcuenta_by_idcontrato(
    IN idcontrato_ INT
)
BEGIN

    SELECT idnumcuentas, numcuenta FROM numcuentas WHERE idcontrato = idcontrato_;

END //

DELIMITER ;

    DROP PROCEDURE sp_numcuenta_by_idcontrato;

CALL sp_numcuenta_by_idcontrato(4);

SELECT * FROM numcuentas;

SELECT * FROM detallepagos;

SELECT idnumcuentas, numcuenta FROM numcuentas WHERE idcontrato = 1;
DROP PROCEDURE sp_add_detallepago_cronograma;
DROP PROCEDURE sp_numcuenta_by_idcontrato

SELECT * FROM numcuentas;

SELECT * FROM detallepagos;

SELECT * FROM cronogramapagos;
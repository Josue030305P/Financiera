
USE financiera;

DELIMITER //

CREATE PROCEDURE sp_add_garantia_contrato(
IN idgarantia_ INT,
IN idcontrato_ INT,
IN porcentaje_ INT,
IN observaciones_ VARCHAR(100)

)
BEGIN
        INSERT INTO detallegarantias(idgarantia, idcontrato, porcentaje,observaciones)
                VALUES(idgarantia_, idcontrato_, porcentaje_,observaciones_);
END //


DELIMITER ;


DROP PROCEDURE sp_add_garantia_contrato;
SELECT * from detallegarantias;
SELECT * FROM garantias;

SELECT * FROM contratos;

USE financiera;

DELIMITER //
CREATE PROCEDURE sp_add_contrato(
IN idversion_		INT,
IN idasesor_		INT,
IN idinversionista_	INT,
IN idconyuge_		INT,   -- ES EL ID DE PERSONA que se agregado.
IN idusuariocreacion_ INT,
IN fechainicio_		DATE,
IN fechafin_		DATE,
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
	INSERT INTO contratos(idversion,idasesor,idinversionista,idconyuge,idusuariocreacion,fechainicio,fechafin
						,impuestorenta,toleranciadias,duracionmeses,moneda,diapago,interes,capital,
                        tiporetorno,periodopago,observacion)
                        VALUES
                        (idversion_,idasesor_,idinversionista_,idconyuge_,idusuariocreacion_,fechainicio_,fechafin_,
						impuestorenta_,toleranciadias_,duracionmeses_,moneda_,diapago_,interes_,capital_,
                        tiporetorno_,periodopago_,observacion_);
                        
                        SELECT LAST_INSERT_ID() AS idcontrato;
END //
DELIMITER ;


DROP PROCEDURE sp_delete_contrato

DELIMITER //
CREATE PROCEDURE sp_delete_contrato(
IN idcontrato_ INT
)
BEGIN
    UPDATE contratos SET 
    estado = 'Eliminado'
    WHERE idcontrato = idcontrato_;
END //
DELIMITER ;

CALL sp_delete_contrato(1);
SELECT * FROM contratos;
SHOW COLUMNS FROM contratos LIKE 'estado';


SELECT * FROM contratos WHERE idcontrato = 1;

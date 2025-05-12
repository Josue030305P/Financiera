-- GENERAR CRONOGRAMA DE PAGO
USE financiera;
DELIMITER //

CREATE PROCEDURE sp_generar_cronograma(
IN idcontrato_ 	  INT,
IN numcuota_  	  INT,
IN totalbruto_ 	  DECIMAL(10,2),
IN totalneto_	  DECIMAL(10,2),
IN fechavencimiento DATE
)
BEGIN
	INSERT INTO cronogramapagos(idcontrato, numcuota, totalbruto, totalneto, fechavencimiento)
        VALUES (idcontrato_, numcuota_, totalbruto_, totalneto_, fechavencimiento);

END //

DELIMITER ;

CALL sp_generar_cronograma(1,1,988,865,'2025-08-12');
SELECT * FROM cronogramapagos;
SELECT * FROM contratos;
SELECT * FROM inversionistas;
SELECT * FROM personas;
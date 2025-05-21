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




DELIMITER //
CREATE PROCEDURE obtener_cronogramas_por_contrato (
    IN idcontrato_ INT
)
BEGIN
    SELECT *
    FROM vista_cronogramas_detallado
    WHERE idcontrato = idcontrato_;
END //
DELIMITER ;
CALL  obtener_cronogramas_por_contrato(1);



DELIMITER //
CREATE PROCEDURE obtener_cronogramas_filtrado (
    IN filtro_estado VARCHAR(20),
    IN filtro_id_contrato INT,
    IN filtro_dni VARCHAR(12)
)
BEGIN
    SELECT *
    FROM vista_cronogramas_detallado
    WHERE (filtro_estado IS NULL OR estado_pago = filtro_estado)
    AND (filtro_id_contrato IS NULL OR idcontrato = filtro_id_contrato)
    AND (filtro_dni IS NULL OR dni = filtro_dni);
END //
DELIMITER ;

    
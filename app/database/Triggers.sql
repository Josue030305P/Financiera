DELIMITER //
CREATE TRIGGER check_unica_version_activa_insert
BEFORE INSERT ON versiones
FOR EACH ROW
BEGIN
    IF NEW.fechafin IS NULL THEN
        IF EXISTS (SELECT 1 FROM versiones WHERE fechafin IS NULL) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Ya existe una versión activa (fechafin es NULL).';
        END IF;
    END IF;
END//
DELIMITER ;

INSERT INTO versiones(fechainicio) VALUES(now());



-- TRIGGER PARA ACTUALIZAR CAMPO AMORTIZACION DE LA TABLA CRONOGRAMAPAGOS AL ACTUALIZAR EL CAMPO MONTO DE DETALLEPAGOS

DELIMITER //

CREATE TRIGGER detallepagos_update_monto_amortizacion
AFTER UPDATE ON detallepagos
FOR EACH ROW
BEGIN
    
    UPDATE cronogramapagos 
    SET amortizacion = amortizacion + (NEW.monto - OLD.monto)
    WHERE idcronogramapago = NEW.idcronogramapago;
    
    
    UPDATE cronogramapagos 
    SET estado = 'Pagado'
    WHERE idcronogramapago = NEW.idcronogramapago 
    AND (totalneto - amortizacion) <= 0;
END //

DELIMITER ;


DELIMITER //	
CREATE TRIGGER detallepagos_insert_monto_amortizacion
AFTER INSERT ON detallepagos
FOR EACH ROW
BEGIN
    -- Actualiza la amortización sumando el nuevo monto
    UPDATE cronogramapagos 
    SET amortizacion = amortizacion + NEW.monto
    WHERE idcronogramapago = NEW.idcronogramapago;
    
    -- Actualiza el estado a 'Pagado' si el monto restante es 0 o menos
    UPDATE cronogramapagos 
    SET estado = 'Pagado'
    WHERE idcronogramapago = NEW.idcronogramapago 
    AND (totalneto - amortizacion) <= 0;
END //


SELECT * FROM detallepagos;



INSERT INTO detallepagos (idcronogramapago, idusuariopago,idnumcuenta, numtransaccion, fechahora,monto, observaciones)
		VALUES(1,1,1,'5455455',NOW(),306.65, 'Se ha pagado una parte');

UPDATE detallepagos SET monto = 574 WHERE iddetallepago = 2;


SELECT * FROM detallepagos;
SELECT * FROM cronogramapagos;

CREATE VIEW vista_cronogramapagos AS
SELECT 
    c.idcronogramapago,
    c.idcontrato,
    c.numcuota,
    c.totalbruto,
    c.totalneto,
    c.amortizacion,
    (c.totalneto - c.amortizacion) as restante,
    c.fechavencimiento,
    c.estado,
    c.created_at,
    c.updated_at
FROM cronogramapagos c;
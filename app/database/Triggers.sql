USE financiera;
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





SELECT * FROM cronogramapagos;

UPDATE cronogramapagos SET estado = 'Eliminado' WHERE idcontrato = 1;
SELECT * FROM contratos;


DELIMITER //

-- Trigger para actualizar el estado de cronogramapagos cuando un contrato es eliminado
CREATE TRIGGER trg_contrato_eliminado_update_cronograma
AFTER UPDATE ON contratos
FOR EACH ROW
BEGIN
    -- Verifica si el estado del contrato ha cambiado a 'Eliminado'
    IF NEW.estado = 'Eliminado' AND OLD.estado <> 'Eliminado' THEN
        -- Actualiza el estado de todas las cuotas asociadas en cronogramapagos a 'Eliminado'
        UPDATE cronogramapagos
        SET estado = 'Eliminado'
        WHERE idcontrato = NEW.idcontrato;
    END IF;
END //

DELIMITER ;





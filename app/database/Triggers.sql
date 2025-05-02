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

USE financiera;


DROP EVENT IF EXISTS actualizar_estado_contratos;

-- Crear el evento para actualizar el estado de los contratos
DELIMITER //
CREATE EVENT actualizar_estado_contratos
ON SCHEDULE EVERY 1 DAY -- Se ejecutará cada día
STARTS CURRENT_TIMESTAMP -- Comienza inmediatamente
DO
BEGIN
    -- Actualiza el estado de los contratos a 'Completado'
    -- cuando la fecha de fin (fechafin) es igual o anterior a la fecha actual
    -- y el estado actual del contrato es 'Vigente'.
    UPDATE contratos
    SET estado = 'Completado', -- Cambia el estado a 'Completado'
        updated_at = NOW()      -- Actualiza la marca de tiempo de modificación
    WHERE
        fechafin <= CURDATE() AND -- La fecha de fin es igual o anterior a la fecha actual
        estado = 'Vigente';       -- Y el contrato está actualmente 'Vigente'
END //

DELIMITER ;

-- Puedes verificar si el evento fue creado correctamente:


DROP EVENT IF EXISTS actualizar_pagos_vencidos;

-- Crear el evento para actualizar el estado de las cuotas a 'Vencido'
CREATE EVENT actualizar_pagos_vencidos
ON SCHEDULE EVERY 1 DAY -- Se ejecutará cada día
STARTS CURRENT_TIMESTAMP -- Comienza inmediatamente (o en el próximo minuto completo)
DO
BEGIN
    -- Actualiza el estado de las cuotas en cronogramapagos a 'Vencido'
    -- cuando la fecha de vencimiento (fechavencimiento) es anterior a la fecha actual
    -- y el estado actual de la cuota es 'Pendiente'.
    UPDATE cronogramapagos
    SET estado = 'Vencido', -- Cambia el estado a 'Vencido'
        updated_at = NOW()  -- Actualiza la marca de tiempo de modificación
    WHERE
        fechavencimiento < CURDATE() AND -- La fecha de vencimiento es anterior a la fecha actual
        estado = 'Pendiente';           -- Y la cuota está actualmente 'Pendiente'
END //

DELIMITER ;

-- event_scheduler = ON

--SHOW VARIABLES LIKE 'event_scheduler';

SHOW EVENTS;

UPDATE contratos SET estado = 'Completado' WHERE idcontrato = 1;
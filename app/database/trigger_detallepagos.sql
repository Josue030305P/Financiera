DELIMITER //

-- Trigger para INSERT
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

-- Trigger para UPDATE
CREATE TRIGGER detallepagos_update_monto_amortizacion
AFTER UPDATE ON detallepagos
FOR EACH ROW
BEGIN
    -- Actualiza la amortización sumando la diferencia entre el nuevo monto y el monto anterior
    UPDATE cronogramapagos 
    SET amortizacion = amortizacion + (NEW.monto - OLD.monto)
    WHERE idcronogramapago = NEW.idcronogramapago;
    
    -- Actualiza el estado a 'Pagado' si el monto restante es 0 o menos
    UPDATE cronogramapagos 
    SET estado = 'Pagado'
    WHERE idcronogramapago = NEW.idcronogramapago 
    AND (totalneto - amortizacion) <= 0;
END //

DELIMITER ; 
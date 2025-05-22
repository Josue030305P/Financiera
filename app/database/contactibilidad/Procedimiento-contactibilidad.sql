
USE financiera;
DELIMITER //

CREATE PROCEDURE sp_lead_add_contactbilidad(
IN idlead_				INT,
IN idusuariocreacion_ 	INT,
IN fecha_				DATE,
IN hora_				TIME,
IN comentarios_			VARCHAR(120),
IN estado_				ENUM('Realizado','Pendiente','Reprogramado')
)
BEGIN 

	INSERT INTO contactibilidad(idlead, idusuariocreacion, fecha, hora, comentarios, estado)
				VALUES(idlead_, idusuariocreacion_, fecha_, hora_, comentarios_, estado_);

END //

DELIMITER ;




DELIMITER //

CREATE PROCEDURE sp_update_contactibilidad(
    IN idcontactibilidad_ INT,
    IN fecha_             DATE,
    IN hora_              TIME,
    IN comentarios_       VARCHAR(120),
    IN estado_            ENUM('Realizado','Pendiente','Reprogramado')
)
BEGIN
    UPDATE contactibilidad SET
        fecha = fecha_,
        hora = hora_,
        comentarios = comentarios_,
        estado = estado_
    WHERE idcontactibilidad = idcontactibilidad_; 

END //


DELIMITER ;




SELECT * FROM contactibilidad;
SELECT * FROM leads;
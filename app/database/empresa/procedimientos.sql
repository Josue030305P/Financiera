
DELIMITER //
CREATE PROCEDURE sp_add_empresa(
IN nombrecomercial_ VARCHAR(100),
IN direccion_		VARCHAR(100),
IN ruc_				CHAR(11),
IN razonsocial_		VARCHAR(300)
)
BEGIN
	INSERT INTO empresas(nombrecomercial, direccion, ruc, razonsocial)
		VALUES(nombrecomercial_, direccion_, ruc_, razonsocial_);
             SELECT LAST_INSERT_ID() AS idempresa;
END //
DELIMITER ;

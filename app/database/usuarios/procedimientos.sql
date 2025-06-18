
USE financiera;

SELECT * FROM personas;
SELECT * FROM colaboradores;

SELECT * FROM contratos;
UPDATE contratos SET fechafin = '2026-05-29	' WHERE idcontrato = 9;
SELECT * FROM roles;
 UPDATE contratos SET estado = 'Completado' WHERE idcontrato = 9;

SELECT * FROM usuarios;
UPDATE usuarios SET passworduser = '$2y$10$DbtIbwxMk215n9BIuChY3.M2.N/E7qdk91aLW9H3G/4PCW7qZWS7e';
SHOW COLUMNS FROM colaboradores;

DELIMITER //
CREATE PROCEDURE sp_add_persona_usuario(
IN idpais_		INT,
IN apellidos_	VARCHAR(70),
IN nombres_		VARCHAR(70),
IN fechanacimiento_  DATE,
IN tipodocumento_ ENUM('DNI','PSP','CEX'),
IN numdocumento_  VARCHAR(12),
IN email_		VARCHAR(100),
IN telprincipal_ VARCHAR(15),
IN domicilio_ VARCHAR(100)

)
BEGIN

	INSERT INTO personas(idpais,apellidos,nombres,fechanacimiento,tipodocumento,numdocumento,email,telprincipal,domicilio, estado)
		VALUES(idpais_,apellidos_,nombres_,fechanacimiento_,tipodocumento_,numdocumento_,email_,telprincipal_,domicilio_,'Usuario');

END //

DELIMITER ;

CALL sp_add_persona_usuario(1,'SancheZ Sanchez', 'Milenka','1990-06-18','DNI','66633366','milenka67@gmail.com','900000223','AV CARRIZO #554 - GROCIO PRADO - CHINCHA');

DROP PROCEDURE sp_add_colaborador_usuario

DELIMITER //

-- Procedimiento para agregar un colaborador y actualizar el estado de la persona
CREATE PROCEDURE sp_add_colaborador_usuario(
    IN idpersona_ INT,
    IN idrol_ INT,
    IN idusuariocreacion_ INT,
    IN fechainicio_ DATE,
    IN fechafin_ DATE,
    IN observaciones_ VARCHAR(100)
)
BEGIN
    -- 1. Insertar el nuevo registro en la tabla 'colaboradores'
    INSERT INTO colaboradores(idpersona, idrol, idusuariocreacion, fechainicio, fechafin, observaciones)
    VALUES(idpersona_, idrol_, idusuariocreacion_, fechainicio_, fechafin_, observaciones_);

    -- 2. Actualizar el estado de la persona en la tabla 'personas'
    -- Una vez que la persona es asignada como colaborador, su estado cambia
    -- para no ser seleccionada nuevamente para un rol de colaborador.
    UPDATE personas
    SET estado = 'Colaborador' -- Cambiamos el estado a 'Colaborador'
    WHERE idpersona = idpersona_;

END //

DELIMITER ;

/* UPDATE personas SET estado = 'Colaborador' WHERE idpersona = 4;  */

CALL sp_add_colaborador_usuario(38,1,1,'2025-06-16','2026-06-16','Contrato de un año');



DELIMITER //
CREATE PROCEDURE sp_add_usuario(
IN idcolaborador_  INT,
IN usuario_	VARCHAR(40),
IN passworduser_	VARCHAR(255),
IN fotoperfil_  VARCHAR(140)
)
BEGIN

	INSERT INTO usuarios(idcolaborador, usuario, passworduser, fotoperfil)
                VALUES(idcolaborador_, usuario_, passworduser_, fotoperfil_);
END //

DELIMITER ;
CALL sp_add_usuario(5,'milenka123','12345','uploads/fotoperfil/jirafales.jpg');


-- UPDATE personas SET estado = 'Usuario' WHERE idpersona = 4;



-- idpersona = 1, 2, 3 ,4 , 31

DROP PROCEDURE   sp_getpersona_to_colaborador;
DELIMITER //

-- Procedimiento para obtener personas que están disponibles para ser asignadas como colaborador
-- Es decir, personas cuyo estado es 'Usuario' y que NO están ya en la tabla 'colaboradores'.
CREATE PROCEDURE sp_getpersona_to_colaborador()
BEGIN
    SELECT
        p.idpersona,
        -- Concatenamos apellidos y nombres para una mejor presentación
        CONCAT(p.apellidos, ' ', p.nombres) AS nombrecompleto
    FROM
        personas p
    LEFT JOIN
        colaboradores c ON p.idpersona = c.idpersona
    WHERE
        p.estado = 'Usuario' -- Filtramos por el estado inicial 'Usuario' que tú definiste
        AND c.idpersona IS NULL; -- ¡CLAVE! Excluimos aquellas personas que YA TIENEN un registro en 'colaboradores'

END //

DELIMITER ;

CALL sp_getpersona_to_colaborador();



DELIMITER //

-- Procedimiento para obtener los colaboradores que aún no tienen una cuenta de usuario
-- Esto se determina buscando colaboradores que NO existen en la tabla 'usuarios'.
CREATE PROCEDURE sp_getcolaborador_to_add_usuario()
BEGIN
    SELECT
        col.idcolaborador,
        -- Concatena el nombre y apellido de la persona asociada al colaborador para una mejor visualización
        CONCAT(p.nombres, ' ', p.apellidos) AS nombrecompleto
    FROM
        colaboradores col
    JOIN
        personas p ON col.idpersona = p.idpersona -- Unimos con 'personas' para obtener los nombres
    LEFT JOIN
        usuarios u ON col.idcolaborador = u.idcolaborador -- Hacemos un LEFT JOIN con 'usuarios'
    WHERE
        u.idcolaborador IS NULL; -- Filtramos para incluir solo aquellos colaboradores que NO tienen una entrada en 'usuarios'
        -- Si el campo 'esUsuario' en la tabla 'colaboradores' realmente indica si se ha creado (o se debe crear) una cuenta de usuario,
        
END //

DELIMITER ;

-- Para probar el procedimiento:
CALL sp_getcolaborador_to_add_usuario();







UPDATE personas SET estado = 'Usuario' WHERE idpersona = 1
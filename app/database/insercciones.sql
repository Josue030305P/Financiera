-- Tabla: pais
INSERT INTO pais (pais) VALUES 
('Perú'),
('Argentina');
SELECT * FROM pais;
-- Tabla: departamentos
INSERT INTO departamentos (departamento) VALUES 
('Lima'),
('Cusco');


INSERT INTO provincias (iddepartamento, provincia) VALUES 
(1, 'Callao'),
(1, 'Barranca');
SELECT * FROM provincias;

INSERT INTO distritos (idprovincia, distrito) VALUES 
(1, 'Miraflores');
SELECT * FROM distritos;


-- Tabla: roles
INSERT INTO roles (rol) VALUES 
('Asesor de inversión'),
('Admin');

-- Tabla: entidades
INSERT INTO entidades (tipo, entidad) VALUES 
('Banco', 'BCP'),
('Caja', 'Caja Arequipa');

-- Tabla: personas
INSERT INTO personas (
    tipodocumento, numdocumento, idpais, 
    apellidos, nombres, email, domicilio, telprincipal, referencia
)
VALUES

('DNI', '12344538', 1, 'Meneses Fuentes', 'Paola Manuela', 'Paola@example.com', 'Av. nn', '987654851', 'Al costado de mi vecino'),
('DNI', '71882015', 1 ,'Pilpe Yataco', 'Josué Isai', 'josue@example.com', 'Av. nn', '936047189', 'Al costado de bodega Marcelina'),
('DNI', '85986985', 1, 'Perez Munayco', 'María Esther', 'maria@example.com', 'Av. nn', '923569887','Al costado de mi vecino');

SELECT * FROM personas;
SELECT * FROM roles;

INSERT INTO colaboradores (idpersona, idrol, fechainicio)
VALUES
(3, 1, '2025-01-01');

SELECT * FROM colaboradores;


INSERT INTO usuarios (idcolaborador, usuario, passworduser)
VALUES
(2, 'Maria', '12345');

SELECT * FROM usuarios;

INSERT INTO inversionistas (idpersona, idempresa, idasesor)
VALUES
(7, NULL, 1);

SELECT * FROM inversionistas;


INSERT INTO numcuentas (idinversionista, identidad, tipomoneda, numcuenta, cci)
VALUES
(1, 1, 'PEN', '1234567890', '001234567890');



INSERT INTO canales (canal) VALUES 
('Facebook'),
('WhatsApp'),
('Instagram');

SELECT * FROM personas;
SELECT * FROM usuarios;

INSERT INTO leads (idasesor, idpersona, idcanal, comentarios, prioridad, ocupacion)
VALUES
(2, 3, 1, 'Esta demasiado interesado', 'Alto', 'Ingeníera');


INSERT INTO contactibilidad (idlead, fecha, hora, comentarios, estado)
VALUES
(1, '2025-03-01', '10:00:00', 'Contacto inicial', 'Activo');


SELECT * FROM  inversionistas;
SELECT * FROM inversionistas;
INSERT INTO contratos (
    idasesor, idinversionista, fechainicio, fechafin, 
    impuestorenta, toleranciadias, duracionmeses, moneda, 
    diapago, interes, capital, tiporetorno, periodopago, observacion, version
)
VALUES
(1, 1, '2025-01-01', '2026-01-01', 15.50, 30, 12, 'PEN', 15, 5.50, 10000.00, 'Fijo', 'Mensual', 'Contrato 1', '1');

-- Tabla: garantias
INSERT INTO garantias (tipogarantia) VALUES 
('Auto'),
('Hipoteca'),
('Letra');

SELECT * FROM contratos;

INSERT INTO detallegarantias (idgarantia, idcontrato, porcentaje, observaciones)
VALUES
(1, 2, 50, 'Un auto Kia Picanto 2025');


INSERT INTO cronogramapagos (idcontrato, numcuota, totalpago, amortizacion, fechavencimiento, estado)
VALUES
(2, 1, 1000.00, 1000.00, '2025-04-01', 'Pendiente');

SELECT * FROM usuarios;
SELECT * FROM numcuentas;
INSERT INTO detallepagos (idcronogramapago, idusuariopago, idnumcuenta, numtransaccion, fechahora, monto, observaciones)
VALUES
(1, 1, 1, 'TX123', NOW(), 1000.00, 'Pago 1');



INSERT INTO accesos (idusuario_acceso, status_)
VALUES
(1, 'Activo');

SELECT * FROM accesos;


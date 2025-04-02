-- Tabla: pais
INSERT INTO pais (pais) VALUES 
('Perú'),
('Colombia');

-- Tabla: departamentos
INSERT INTO departamentos (departamento) VALUES 
('Lima'),
('Cusco');

-- Tabla: provincias 
-- (Se asume que el departamento con id=1 es 'Lima' y id=2 es 'Cusco')
INSERT INTO provincias (iddepartamento, provincia) VALUES 
(1, 'Lima Province'),
(2, 'Cusco Province');

-- Tabla: distritos
-- (Se asume que la provincia 1 es para Lima y la 2 para Cusco)
INSERT INTO distritos (idprovincia, distrito) VALUES 
(1, 'Miraflores'),
(2, 'Wanchaq');

-- Tabla: roles
INSERT INTO roles (rol) VALUES 
('Admin'),
('User');

-- Tabla: entidades
INSERT INTO entidades (tipo, entidad) VALUES 
('Banco', 'BCP'),
('Caja', 'Caja Arequipa');

-- Tabla: personas
INSERT INTO personas (
    tipodocumento, numdocumento, idpais, iddistrito, 
    apellidos, nombres, email, domicilio, telprincipal, telsecundario, referencia
)
VALUES
('DNI', '12345678', 1, 1, 'Perez', 'Juan', 'juan@example.com', 'Av. Lima 123', '987654321', NULL, 'Referencia 1'),
('DNI', '87654321', 2, 2, 'Gomez', 'Maria', 'maria@example.com', 'Av. Cusco 456', '912345678', NULL, 'Referencia 2');

-- Tabla: empresas
-- (Se deja sin insertar datos)

-- Tabla: colaboradores
-- (Se asume que en 'personas' se insertaron los registros con idpersona=1 y 2; en roles, idrol=1 es 'Admin' y 2 es 'User')
INSERT INTO colaboradores (idpersona, idrol, fechainicio)
VALUES
(1, 1, '2025-01-01'),
(2, 2, '2025-01-02');

-- Tabla: usuarios
-- (Se asume que en 'colaboradores' se insertaron registros con idcolaborador=1 y 2)
INSERT INTO usuarios (idcolaborador, usuario, password_user)
VALUES
(1, 'admin', '12345'),
(2, 'user', 'password');

-- Tabla: inversionistas
-- (Se asume que idpersona=1 y 2; se asigna idasesor=1 para el primero y 2 para el segundo)
INSERT INTO inversionistas (idpersona, idempresa, idasesor)
VALUES
(1, NULL, 1),
(2, NULL, 2);

-- Tabla: numcuentas
-- (Se asume que en inversionistas se insertaron con idinversionista=1 y 2; en entidades, id=1 y 2 respectivamente)
INSERT INTO numcuentas (idinversionista, identidad, tipomoneda, numcuenta, cci)
VALUES
(1, 1, 'PEN', '1234567890', '001234567890'),
(2, 2, 'USD', '9876543210', '009876543210');

-- Tabla: canales
INSERT INTO canales (canal) VALUES 
('Facebook'),
('WhatsApp');

-- Tabla: leads
-- (Se asume que en usuarios, idusuario=1 y 2; y en personas, idpersona=1 y 2)
INSERT INTO leads (idasesor, idpersona, idcanal, comentarios, prioridad, ocupacion)
VALUES
(1, 1, 1, 'Lead 1', 'Alto', 'Ingeniero'),
(2, 2, 2, 'Lead 2', 'Medio', 'Arquitecto');

-- Tabla: contactibilidad
-- (Se asume que en leads, idlead=1 y 2)
INSERT INTO contactibilidad (idlead, fecha, hora, comentarios, estado)
VALUES
(1, '2025-03-01', '10:00:00', 'Contacto inicial', 'Activo'),
(2, '2025-03-02', '11:00:00', 'Seguimiento', 'Inactivo');

-- Tabla: contratos
-- (Se asume que en inversionistas, idinversionista=1 y 2; en usuarios, idusuario=1 y 2)
INSERT INTO contratos (
    idasesor, idinversionista, fechainicio, fechafin, 
    impuestorenta, toleranciadias, duracionmeses, moneda, 
    diapago, interes, capital, tiporetorno, periodopago, observacion, version
)
VALUES
(1, 1, '2025-01-01', '2026-01-01', 15.50, 30, 12, 'PEN', 15, 5.50, 10000.00, 'Fijo', 'Mensual', 'Contrato 1', '1'),
(2, 2, '2025-02-01', '2026-02-01', 12.00, 30, 12, 'USD', 20, 6.00, 20000.00, 'Variable', 'Mensual', 'Contrato 2', '1');

-- Tabla: garantias
INSERT INTO garantias (tipogarantia) VALUES 
('Auto'),
('Hipoteca');

-- Tabla: detallegarantias
-- (Se asume que en contratos se insertaron con idcontrato=1 y 2; en garantias, id=1 y 2)
INSERT INTO detallegarantias (idgarantia, idcontrato, porcentaje, observaciones)
VALUES
(1, 1, 25, 'Detalle garantía 1'),
(2, 2, 50, 'Detalle garantía 2');

-- Tabla: cronogramapagos
-- (Se asume que en contratos, idcontrato=1 y 2)
INSERT INTO cronogramapagos (idcontrato, numcuota, totalpago, amortizacion, fechavencimiento, estado)
VALUES
(1, 1, 1000.00, 1000.00, '2025-04-01', 'Pendiente'),
(2, 1, 2000.00, 2000.00, '2025-05-01', 'Pendiente');

-- Tabla: detallepagos
-- (Se asume que en cronogramapagos, idcronogramapago=1 y 2; en usuarios, idusuario=1 y 2; en numcuentas, idnumcuentas=1 y 2)
INSERT INTO detallepagos (idcronogramapago, idusuariopago, idnumcuenta, numtransaccion, fechahora, monto, observaciones)
VALUES
(1, 1, 1, 'TX123', NOW(), 1000.00, 'Pago 1'),
(2, 2, 2, 'TX456', NOW(), 2000.00, 'Pago 2');

-- Tabla: accesos
-- (Se asume que en colaboradores, idcolaborador=1 y 2)
INSERT INTO accesos (idcolaborador_acces, status_)
VALUES
(1, 'Activo'),
(2, 'Inactivo');


CREATE DATABASE financiera;
-- DROP DATABASE financiera;
USE financiera;
SELECT * FROM usuarios;
SELECT * FROM vista_cronogramas_detallado;
DELETE FROM pais WHERE idpais = 2;
-- UPDATE personas SET idpais=1 WHERE idpais=2;
SELECT * FROM pais;
SELECT * FROM personas;
SELECT * FROM contratos;
UPDATE contratos SET fechafin = '2025-07-11' WHERE idcontrato = 5;

-- UPDATE usuarios SET passworduser='$2y$10$wv2310nlHt7yRcNXqdahBuxfkVUnIEqdocHYQ62ypkxER95RNXr5C' WHERE idusuario =1

CREATE TABLE pais(
idpais 				INT PRIMARY KEY AUTO_INCREMENT,
pais				VARCHAR(40) NOT NULL DEFAULT 'Perú' UNIQUE
)ENGINE=InnoDB;

SELECT * FROM paises;


CREATE TABLE departamentos(
iddepartamento		INT PRIMARY KEY AUTO_INCREMENT,
idpais 				INT NOT NULL DEFAULT 1,
departamento		VARCHAR(40) NOT NULL,
CONSTRAINT fk_idpais_depart FOREIGN KEY(idpais) REFERENCES pais(idpais)
)ENGINE=InnoDB;




CREATE  TABLE provincias(
idprovincia			INT PRIMARY KEY AUTO_INCREMENT,
iddepartamento		INT NOT NULL,
provincia			VARCHAR(40) NOT NULL,
CONSTRAINT fk_iddepartamen FOREIGN KEY(iddepartamento) REFERENCES departamentos(iddepartamento)
)ENGINE=InnoDB;



CREATE TABLE distritos(
iddistrito			INT PRIMARY KEY AUTO_INCREMENT,
idprovincia			INT NOT NULL,
distrito			VARCHAR(40) NOT NULL,
CONSTRAINT fk_provincia FOREIGN KEY(idprovincia) REFERENCES provincias(idprovincia)
)ENGINE=InnoDB;


CREATE TABLE roles(
idrol				INT PRIMARY KEY AUTO_INCREMENT,
rol					VARCHAR(40) UNIQUE NOT NULL -- Unique
)ENGINE=InnoDB;

-- TABLA ENTIDADES
CREATE TABLE entidades(
identidad				INT PRIMARY KEY AUTO_INCREMENT,
tipo					ENUM('Banco','Caja') NOT NULL,
entidad					VARCHAR(45) UNIQUE NOT NULL 
)ENGINE=InnoDB;



CREATE TABLE  personas(
idpersona			INT  PRIMARY KEY AUTO_INCREMENT,
tipodocumento		ENUM('DNI','PSP','CEX') DEFAULT 'DNI',
numdocumento		VARCHAR(12) NULL,
idpais				INT NOT NULL DEFAULT 1,
iddistrito 		    INT NULL,
apellidos			VARCHAR(70) NOT NULL,
nombres				VARCHAR(70) NOT NULL,
fechanacimiento   	DATE NULL,
email				VARCHAR(100) UNIQUE NOT NULL,
domicilio			VARCHAR(100) NULL,
telprincipal		VARCHAR(15) NOT NULL UNIQUE,
telsecundario		VARCHAR(15) NULL,
referencia			VARCHAR(150) NULL,
estado				ENUM('Activo','Inactivo', 'Usuario','Colaborador') DEFAULT 'Activo',
CONSTRAINT uk_numdocumento UNIQUE(tipodocumento,numdocumento),  -- Manejar un numero de documento y amarrarlo a un tipo de documento
CONSTRAINT fk_idpais	FOREIGN KEY(idpais) REFERENCES pais(idpais),
CONSTRAINT fk_distrito  FOREIGN KEY(iddistrito) REFERENCES distritos(iddistrito)
)ENGINE=InnoDB;

ALTER TABLE personas MODIFY COLUMN estado ENUM('Activo','Inactivo','Usuario','Colaborador') DEFAULT 'Activo';
SELECT * FROM personas;
SELECT * FROM colaboradores;
SELECT * FROM usuarios;
SELECT * FROM leads;
SELECT * FROM contratos;


CREATE TABLE empresas(
idempresa			INT PRIMARY KEY AUTO_INCREMENT,
nombrecomercial		VARCHAR(100) NOT NULL UNIQUE,
direccion			VARCHAR(100) NOT NULL,
ruc					CHAR(11)  UNIQUE NOT NULL,
razonsocial			VARCHAR(300) UNIQUE NOT NULL,
created_at			DATETIME NOT NULL DEFAULT NOW(),
updated_at			DATETIME NULL
)ENGINE=InnoDB;


CREATE TABLE colaboradores(
idcolaborador   	INT PRIMARY KEY AUTO_INCREMENT,
idpersona			INT NOT NULL UNIQUE,
idrol				INT NOT NULL,
idusuariocreacion     INT  NULL, -- FK
idusuarioeliminacion	INT NULL, -- FK
fechainicio			DATE NOT NULL,
fechafin			DATE NULL,
observaciones		VARCHAR(100) NULL,
fechahoraeliminacion	DATETIME NULL,
created_at			DATETIME NOT NULL DEFAULT NOW(),
updated_at			DATETIME NULL,

CONSTRAINT fk_idpersona FOREIGN KEY(idpersona) REFERENCES personas(idpersona),
CONSTRAINT fk_id_user_creacion_colab FOREIGN KEY (idusuariocreacion) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_colab FOREIGN KEY (idusuarioeliminacion) REFERENCES usuarios(idusuario),
CONSTRAINT fk_idrol FOREIGN KEY(idrol) REFERENCES roles(idrol)

)ENGINE=InnoDB;
-- ALTER TABLE colaboradores DROP COLUMN esUsuario;

ALTER TABLE colaboradores ADD CONSTRAINT fk_id_user_creacion_colab FOREIGN KEY (idusuariocreacion) REFERENCES usuarios(idusuario);
ALTER TABLE colaboradores MODIFY COLUMN idpersona INT NOT NULL UNIQUE;

ALTER TABLE colaboradores
ADD CONSTRAINT fk_id_user_elimin_colab FOREIGN KEY (idusuarioeliminacion) REFERENCES usuarios(idusuario);



SELECT *  FROM colaboradores;
SELECT * FROM usuarios;
SELECT * FROM personas;

CREATE TABLE  usuarios(
idusuario	 		INT PRIMARY KEY AUTO_INCREMENT,
idcolaborador    	INT NOT NULL,
usuario				VARCHAR(40) NOT NULL,
passworduser		VARCHAR(255) NOT NULL,
fotoperfil			VARCHAR(140) NULL,
estado				ENUM('Activo', 'Inactivo') NOT NULL DEFAULT 'Activo',
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
CONSTRAINT fk_idcolaborador FOREIGN KEY(idcolaborador) REFERENCES colaboradores(idcolaborador)
)ENGINE=InnoDB;

USE financiera;
SELECT * FROM personas;
-- SHOW COLUMNS FROM usuarios;
SELECT * FROM usuarios;
SELECT * FROM colaboradores;
/* ALTER TABLE usuarios MODIFY COLUMN estado  ENUM('Activo', 'Inactivo') NOT NULL DEFAULT 'Activo' */


CREATE TABLE inversionistas(
idinversionista		INT PRIMARY KEY AUTO_INCREMENT,
idpersona			INT NULL UNIQUE, -- persona inversionista  
idempresa			INT NULL,
idasesor			INT NOT NULL, -- Usuario encargado
idusuariocreacion	INT  NULL, -- FK
idusuarioeliminacion INT NULL,	
estado				ENUM('Activo','Inactivo') DEFAULT 'Activo',
fechahoraeliminacion DATETIME NULL,
created_at			DATETIME NOT NULL DEFAULT NOW(),
updated_at			DATETIME NULL,
CONSTRAINT fk_idpersona_inver FOREIGN KEY(idpersona) REFERENCES personas(idpersona),
CONSTRAINT fk_idempresa FOREIGN KEY(idempresa) REFERENCES empresas(idempresa),
CONSTRAINT fk_idusuario	FOREIGN KEY(idasesor) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_creacion_inver FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_inver FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;



INSERT INTO numcuentas(idcontrato, identidad,numcuenta, cci)
	VALUES(2,1,'858585858585','2025858588');
    
SELECT * FROM contratos;

SELECT * FROM personas;
SELECT * FROM inversionistas;

SELECT * FROM inversionistas;
SELECT * FROM entidades;
SELECT * FROM numcuentas;
 INSERT INTO numcuentas (idinversionista,identidad, tipomoneda, idusuariocreacion, numcuenta, cci, observaciones)
		VALUES(1,1,'PEN',1,'31575022240137','00231517502224013703','Asociando numeor de cuenta a inverisonista');


CREATE TABLE canales(
idcanal			INT AUTO_INCREMENT PRIMARY KEY,
canal			ENUM('Facebook','WhatsApp','Instagram','Otro')
)ENGINE=InnoDB;

-- Personas en conversacion que aun no son inversionistas
CREATE TABLE leads(
idlead				INT PRIMARY KEY AUTO_INCREMENT,
idasesor  			INT NULL, -- El usuario asesor
idpersona			INT NOT NULL,
idcanal				INT NOT NULL,
fecharegistro		DATETIME NOT NULL DEFAULT NOW(),
comentarios			VARCHAR(120) NULL,
prioridad			ENUM('Bajo','Medio','Alto') NOT NULL,
ocupacion			VARCHAR(50) NOT NULL,
estado				ENUM('Nuevo contacto','En proceso','Inversionista','Inactivo') NOT NULL DEFAULT 'Nuevo contacto',
CONSTRAINT fk_idasesor FOREIGN KEY(idasesor) REFERENCES usuarios(idusuario),
CONSTRAINT idpersona_leads FOREIGN KEY(idpersona) REFERENCES personas(idpersona),
CONSTRAINT fk_idcanla_leads FOREIGN KEY(idcanal) REFERENCES canales(idcanal)
)ENGINE=InnoDB;


CREATE TABLE contactibilidad(
idcontactibilidad		INT PRIMARY KEY AUTO_INCREMENT,
idlead					INT NOT NULL,
idusuariocreacion		INT  NULL,  -- FK
idusuarioeliminacion	INT NULL, -- FK
fecha					DATE NOT NULL,
hora					TIME NOT NULL,
comentarios				VARCHAR(120) NULL,
fechahoraeliminacion	DATETIME NULL,
estado					ENUM('Realizado','Pendiente','Reprogramado','Elimninado') NOT NULL,
CONSTRAINT fk_idlead FOREIGN KEY(idlead) REFERENCES leads(idlead),
CONSTRAINT fk_id_user_creacion_contact FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_contact FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;

ALTER TABLE contactibilidad MODIFY COLUMN estado ENUM('Realizado','Pendiente','Reprogramado','Eliminado') NOT NULL;
SELECT * FROM contactibilidad;
CREATE TABLE versiones (
  idversion    INT AUTO_INCREMENT PRIMARY KEY,
  fechainicio  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fechafin     DATE        NULL
) ENGINE=InnoDB;

ALTER TABLE condiciones MODIFY COLUMN condicion TEXT NOT NULL;
INSERT INTO versiones(fechainicio) VALUES(NOW());
SELECT * FROM versiones;

CREATE TABLE condiciones(
idcondicion				INT AUTO_INCREMENT PRIMARY KEY,
idversion				INT NOT NULL,
entidad					ENUM('Mutuatario','Mutuante') COMMENT 'Mutuatario(Yonda) - Mutuante(Inversionista)',
condicion				TEXT NOT NULL,
CONSTRAINT fk_idversion_condicion FOREIGN KEY(idversion) REFERENCES versiones(idversion)
)ENGINE=InnoDB;



INSERT INTO condiciones(idversion,entidad,condicion)
	VALUES(1,'Mutuante','DECLARACIÓN JURADA DE ORIGEN DE FONDOS'),
		  (1,'Mutuante','Cumplir con la presentación de documentos contables requeridos, referente a sus facturas de renta de segunda categoría'),
		  (1,'Mutuante','Informar al MUTUATARIO cualquier situación referente a sus cuentas bancarias a recibir su rentabilidad con anticipación');
		
SELECT * FROM condiciones;


CREATE TABLE contratos(
idcontrato				INT PRIMARY KEY AUTO_INCREMENT,
idversion				INT NOT NULL,
idasesor				INT NOT NULL,
idinversionista			INT NOT NULL UNIQUE,
idconyuge				INT NULL, -- Persona a la que pueden depositar en caso suceda algo al cliente o asi lo decida
idusuariocreacion		INT  NULL, -- fk
idusuarioeliminacion 	INT NULL, -- fk 	
fechainicio				DATE NOT NULL,
fechafin			    DATE NOT NULL,
impuestorenta           DECIMAL(5,2) NOT NULL,
toleranciadias			tinyint NOT NULL,
duracionmeses			tinyint NOT NULL,
moneda					ENUM('PEN','USD') NOT NULL,
diapago					tinyint NOT NULL, -- INDENTIFICANDO QUE DIA SE LE PAGARA AL INVERSIONISTA
interes					decimal(5,2) NOT NULL,
capital					DECIMAL(10,2) NOT NULL,
tiporetorno				ENUM('Fijo','Variable') NOT NULL, -- EL monto del dinero peude variar o ser fijo 
periodopago				VARCHAR(30) NOT NULL DEFAULT 'Mensual',
observacion				VARCHAR(100) NULL,
fechahoraeliminacion	DATETIME NULL,
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
estado 				ENUM('Vigente','Completado', 'Eliminado') DEFAULT 'Vigente',
CONSTRAINT fk_idusuario_asesor FOREIGN KEY(idasesor) REFERENCES usuarios(idusuario),
CONSTRAINT fk_idversion FOREIGN KEY(idversion) REFERENCES versiones(idversion),
CONSTRAINT fk_idinversionista_contrato FOREIGN KEY(idinversionista) REFERENCES inversionistas(idinversionista),
CONSTRAINT fk_idconyugue FOREIGN KEY(idconyuge) REFERENCES personas(idpersona),
CONSTRAINT fk_id_user_creacion_contrat FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_contrat FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;

SELECT * FROM personas;
SELECT * FROM inversionistas;
INSERT INTO inversionistas(idpersona, idasesor, idusuariocreacion)
	VALUES(13,1,1);
INSERT INTO contratos(idversion, idasesor, idinversionista, idconyuge, idusuariocreacion, fechainicio, fechafin, impuestorenta, toleranciadias, duracionmeses, moneda, diapago, interes, capital, tiporetorno, periodopago, observacion)
	VALUES(1,1,5,NULL,NULL,'2024-06-14','2025-06-14',5.00,5,12,'PEN',15,2.50,1000.00,'Fijo','Mensual','Contrato de prueba');


SELECT * FROM numcuentas;
USE financiera;
ALTER TABLE contratos MODIFY COLUMN estado ENUM('Vigente','Completado', 'Eliminado') DEFAULT 'Vigente';

SELECT * FROM contratos;



CREATE TABLE numcuentas(
idnumcuentas		INT PRIMARY KEY AUTO_INCREMENT,
idcontrato			INT NOT NULL,
identidad			INT NOT NULL, -- Entidad es el banco o cajas
idusuariocreacion   INT NULL, -- FK
idusuarioeliminacion INT NULL, -- FK
numcuenta			VARCHAR(30)  UNIQUE NOT NULL,
fecharegistro		DATETIME NOT NULL DEFAULT NOW(),
cci         		VARCHAR(30) UNIQUE NOT NULL,
estitular			CHAR(2) NOT NULL DEFAULT 'Si',
observaciones		VARCHAR(100) NULL,
estado				ENUM('Activo', 'Desactivado') NOT NULL DEFAULT 'Activo' ,
created_at			DATETIME NOT NULL DEFAULT NOW(),
updated_at			DATETIME NULL,
CONSTRAINT fk_contrato_numcuenta FOREIGN KEY(idcontrato) REFERENCES contratos(idcontrato),
CONSTRAINT fk_identidad FOREIGN KEY(identidad) REFERENCES entidades(identidad),
CONSTRAINT fk_id_user_creacion_numcuenta FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_numcuenta FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;

USE financiera;
SELECT * FROM numcuentas;

CREATE TABLE garantias(
idgarantia				INT PRIMARY KEY AUTO_INCREMENT,
tipogarantia			ENUM('Auto','Hipoteca','Letra') NOT NULL
)ENGINE=InnoDB;

CREATE TABLE detallegarantias(
iddetallegarantia       INT PRIMARY KEY AUTO_INCREMENT,
idgarantia				INT NOT NULL,
idcontrato				INT NOT NULL,
porcentaje	           	INT NOT NULL,
observaciones			VARCHAR(100) NULL,
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
CONSTRAINT fk_idgarantia FOREIGN KEY(idgarantia) REFERENCES garantias(idgarantia),
CONSTRAINT fk_idcontrato_detal_garant FOREIGN KEY(idcontrato) REFERENCES contratos(idcontrato)
)ENGINE=InnoDB;

INSERT INTO detallegarantias(idgarantia, idcontrato, porcentaje, observaciones)
		VALUES(1,1,100,'Carro Kia Picanto - 2023');
SELECT * FROM detallegarantias;


CREATE TABLE cronogramapagos(
idcronogramapago		INT PRIMARY KEY AUTO_INCREMENT,
idcontrato		 		INT NOT NULL,
numcuota		    	INT NOT NULL,
totalbruto			DECIMAL(10,2) NOT NULL, -- El pago pendiente 
totalneto			DECIMAL(10,2) NOT NULL,
amortizacion			DECIMAL(10,2) NOT NULL DEFAULT 0,
restante				DECIMAL(10,2) GENERATED ALWAYS AS (totalneto - amortizacion) STORED,
fechavencimiento		DATE NOT NULL, -- Para identificar hasta que fecha hay plazo para pagar
estado					ENUM('Pagado','Pendiente','Vencido','Eliminado') DEFAULT 'Pendiente',
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
CONSTRAINT fk_idcontrato_crono_pag FOREIGN KEY(idcontrato) REFERENCES contratos(idcontrato) 
) ENGINE=InnoDB; 

ALTER TABLE cronogramapagos MODIFY COLUMN estado ENUM('Pagado','Pendiente', 'Vencido','Eliminado') DEFAULT 'Pendiente';

-- ALTER TABLE cronogramapagos DROP CONSTRAINT fk_idcontrato_crono_pag;

CREATE TABLE detallepagos(
iddetallepago			INT PRIMARY KEY AUTO_INCREMENT,
idcronogramapago		INT NOT NULL,
idusuariopago		    INT NOT NULL,
idnumcuenta				INT NOT NULL,
numtransaccion			VARCHAR(30) NOT NULL,
fechahora				DATETIME NOT NULL,
monto					DECIMAL(10,2) NOT NULL,
observaciones			VARCHAR(180) NULL,
comprobante				VARCHAR(255),
CONSTRAINT fk_idcronogramapago FOREIGN KEY(idcronogramapago) REFERENCES cronogramapagos(idcronogramapago),
CONSTRAINT fk_idusuariopago	FOREIGN KEY(idusuariopago) REFERENCES usuarios(idusuario),
CONSTRAINT fk_idnumcuenta FOREIGN KEY(idnumcuenta) REFERENCES numcuentas(idnumcuentas)
)ENGINE=InnoDB;


--ALTER TABLE detallepagos ADD COLUMN comprobante VARCHAR(255);

SELECT * FROM detallepagos;
USE financiera

SELECT * FROM cronogramapagos;
SHOW COLUMNS FROM cronogramapagos;
SHOW COLUMNS FROM contratos;
SELECT * FROM contratos;
--  DROP TABLE detallepagos;
--  ALTER TABLE detallepagos ADD COLUMN comprobante VARCHAR(255) NULL;
-- ALTER TABLE detallepagos MODIFY COLUMN comprobante VARCHAR(255) NULL;


CREATE TABLE accesos(
idacceso				INT PRIMARY KEY AUTO_INCREMENT,
idusuario_acceso 		INT NOT NULL,
fechahora				DATETIME NOT NULL DEFAULT NOW(),
fechafin					DATETIME NULL,
status_					ENUM('Activo','Inactivo') NOT NULL,
CONSTRAINT fk_idusuario_acceso FOREIGN KEY(idusuario_acceso) REFERENCES usuarios(idusuario) -- Aclarar leugo si es en colabordores o usuarios;
)ENGINE=InnoDB;

SHOW COLUMNS FROM accesos;

ALTER TABLE accesos MODIFY COLUMN status_ ENUM('Activo','Inactivo') NOT NULL;





USE financiera;

SELECT * FROM entidades;
SELECT * FROM inversionistas;
SELECT * FROM personas;
SELECT * FROM cronogramapagos;
SELECT * FROM contratos;
SELECT * FROM numcuentas;


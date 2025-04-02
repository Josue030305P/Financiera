CREATE DATABASE financiera;
-- DROP DATABASE financiera;
USE financiera;

CREATE TABLE pais(
idpais 				INT PRIMARY KEY AUTO_INCREMENT,
pais				VARCHAR(40) NOT NULL
)ENGINE=InnoDB;


CREATE TABLE departamentos(
iddepartamento		INT PRIMARY KEY AUTO_INCREMENT,
departamento		VARCHAR(40) NOT NULL
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

SELECT * FROM distritos;
SELECT * FROM canales;

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
idpais				INT NOT NULL,
iddistrito 		    INT NOT NULL DEFAULT 0,
apellidos			VARCHAR(70) NOT NULL,
nombres				VARCHAR(70) NOT NULL,
email				VARCHAR(100) UNIQUE NOT NULL,
domicilio			VARCHAR(100) NULL,
telprincipal		VARCHAR(15) NOT NULL,
telsecundario		VARCHAR(15) NULL,
referencia			VARCHAR(150) NULL,
CONSTRAINT uk_numdocumento UNIQUE(tipodocumento,numdocumento),  -- Manejar un numero de documento y amarrarlo a un tipo de documento
CONSTRAINT fk_idpais	FOREIGN KEY(idpais) REFERENCES pais(idpais),
CONSTRAINT fk_distrito  FOREIGN KEY(iddistrito) REFERENCES distritos(iddistrito)
);
ALTER TABLE personas MODIFY iddistrito INT NULL  ;
SELECT * FROM personas;
-- ALTER TABLE personas MODIFY tipodocumento  ENUM('DNI','PSP','CEX') DEFAULT 'DNI';




CREATE TABLE empresas(
idempresa			INT PRIMARY KEY AUTO_INCREMENT,
nombrecomercial		VARCHAR(100) NOT NULL,
direccion			VARCHAR(100) NOT NULL,
ruc					CHAR(11)  UNIQUE NOT NULL,
razonsocial			VARCHAR(300) UNIQUE NOT NULL,
created_at			DATETIME NOT NULL DEFAULT NOW(),
updated_at			DATETIME NULL

)ENGINE=InnoDB;


CREATE TABLE colaboradores(
idcolaborador   	INT PRIMARY KEY AUTO_INCREMENT,
idpersona			INT NOT NULL,
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
CONSTRAINT fk_idrol FOREIGN KEY(idrol) REFERENCES roles(idrol),
CONSTRAINT fk_id_user_creacion_colab FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_colab FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;



CREATE TABLE  usuarios(
idusuario	 		INT PRIMARY KEY AUTO_INCREMENT,
idcolaborador    	INT NOT NULL,
usuario				VARCHAR(40) NOT NULL,
password_user		VARCHAR(255) NOT NULL,
fotoperfil			VARCHAR(140) NULL,
estado				VARCHAR(18) NULL,
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
CONSTRAINT fk_idcolaborador FOREIGN KEY(idcolaborador) REFERENCES colaboradores(idcolaborador)
)ENGINE=InnoDB;


/*ALTER TABLE usuarios
CHANGE COLUMN idcolaboradores idcolaborador INT NOT NULL;
*/

CREATE TABLE inversionistas(
idinversionista		INT PRIMARY KEY AUTO_INCREMENT,
idpersona			INT NULL, -- persona inversionista  
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

CREATE TABLE numcuentas(
idnumcuentas		INT PRIMARY KEY AUTO_INCREMENT,
estitular			CHAR(2) NOT NULL DEFAULT 'Si',
idinversionista		INT NOT NULL,
identidad			INT NOT NULL, -- Entidad es el banco o cajas
tipomoneda			ENUM('PEN','USD') NOT NULL,
idusuariocreacion   INT NULL, -- FK
idusuarioeliminacion INT NULL, -- FK
numcuenta			VARCHAR(30)  UNIQUE NOT NULL,
cci         		VARCHAR(30) UNIQUE NOT NULL,
fecharegistro		DATETIME NOT NULL DEFAULT NOW(),
observaciones		VARCHAR(100) NULL,
fechahoraeliminacion	DATETIME NULL,
created_at			DATETIME NOT NULL DEFAULT NOW(),
updated_at			DATETIME NULL,
CONSTRAINT fk_idinversionista FOREIGN KEY(idinversionista) REFERENCES inversionistas(idinversionista),
CONSTRAINT fk_identidad FOREIGN KEY(identidad) REFERENCES entidades(identidad),
CONSTRAINT fk_id_user_creacion_numcuenta FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_numcuenta FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;


CREATE TABLE canales(
idcanal			INT AUTO_INCREMENT PRIMARY KEY,
canal			ENUM('Facebook','WhatsApp','Instagram','Otro')
)ENGINE=InnoDB;

-- Personas en conversacion que aun no son inversionistas
CREATE TABLE leads(
idlead			INT PRIMARY KEY AUTO_INCREMENT,
idasesor  			INT NOT NULL, -- El usuario asesor
idpersona			INT NOT NULL,
idcanal				INT NOT NULL,
fecharegistro		DATETIME NOT NULL DEFAULT NOW(),
comentarios			VARCHAR(120) NULL,
prioridad			ENUM('Bajo','Medio','Alto') NOT NULL,
ocupacion			VARCHAR(50) NOT NULL,
estado				VARCHAR(50) NOT NULL DEFAULT 'Nuevo contacto',
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
estado					VARCHAR(50) NULL,
CONSTRAINT fk_idlead FOREIGN KEY(idlead) REFERENCES leads(idlead),
CONSTRAINT fk_id_user_creacion_contact FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_contact FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;

CREATE TABLE contratos(
idcontrato				INT PRIMARY KEY AUTO_INCREMENT,
idasesor				INT NOT NULL,
idinversionista			INT NOT NULL,
idconyuge				INT NULL, -- Persona a la que pueden depositar en caso suceda algo al cliente o asi lo decida
idusuariocreacion		INT  NULL, -- fk
idusuarioeliminacion 	INT NULL, -- fk 	
fechainicio				DATE NOT NULL,
fechafin			    DATE NOT NULL,
fecharetornocapital		DATE NULL,
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
version					CHAR(2)  NOT NULL DEFAULT '1',
fechahoraeliminacion	DATETIME NULL,
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
CONSTRAINT fk_idusuario_asesor FOREIGN KEY(idasesor) REFERENCES usuarios(idusuario),
CONSTRAINT fk_idinversionista_contrato FOREIGN KEY(idinversionista) REFERENCES inversionistas(idinversionista),
CONSTRAINT fk_idconyugue FOREIGN KEY(idconyuge) REFERENCES personas(idpersona),
CONSTRAINT fk_id_user_creacion_contrat FOREIGN KEY (idusuariocreacion ) REFERENCES usuarios(idusuario),
CONSTRAINT fk_id_user_elimin_contrat FOREIGN KEY (idusuarioeliminacion ) REFERENCES usuarios(idusuario)
)ENGINE=InnoDB;

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


CREATE TABLE cronogramapagos(
idcronogramapago		INT PRIMARY KEY AUTO_INCREMENT,
idcontrato		 		INT NOT NULL,
numcuota		    	INT NOT NULL,
totalpago				DECIMAL(10,2) NOT NULL, -- El pago pendiente 
amortizacion			DECIMAL(10,2) NOT NULL,
fechavencimiento				DATE NOT NULL, -- Para identificar hasta que fecha hay plazo para pagar
estado					ENUM('Pagado','Pendiente') DEFAULT 'Pendiente',
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
CONSTRAINT fk_idcontrato_crono_pag FOREIGN KEY(idcontrato) REFERENCES contratos(idcontrato) 
) ENGINE=InnoDB;

CREATE TABLE detallepagos(
iddetallepago			INT PRIMARY KEY AUTO_INCREMENT,
idcronogramapago		INT NOT NULL,
idusuariopago		    INT NOT NULL,
idnumcuenta				INT NOT NULL,
numtransaccion			VARCHAR(30) NOT NULL,
fechahora				DATETIME NOT NULL,
monto					DECIMAL(10,2) NOT NULL,
observaciones			VARCHAR(180) NULL,
CONSTRAINT fk_idcronogramapago FOREIGN KEY(idcronogramapago) REFERENCES cronogramapagos(idcronogramapago),
CONSTRAINT fk_idusuariopago	FOREIGN KEY(idusuariopago) REFERENCES usuarios(idusuario),
CONSTRAINT fk_idnumcuenta FOREIGN KEY(idnumcuenta) REFERENCES numcuentas(idnumcuentas)
)ENGINE=InnoDB;

CREATE TABLE accesos(
idacceso				INT PRIMARY KEY AUTO_INCREMENT,
idcolaborador_acces		INT NOT NULL,
fechahora				DATETIME NOT NULL DEFAULT NOW(),
status_					ENUM('Activo','Inactivo') NOT NULL,
CONSTRAINT fk_idcolaborador_acces FOREIGN KEY(idcolaborador_acces) REFERENCES colaboradores(idcolaborador)		
)ENGINE=InnoDB;
SHOW TABLES ;

INSERT INTO canales(canal) VALUES('Facebook');
SELECT * FROM canales;
SELECT * From colaboradores;
SELECT * FROM personas;
SELECT * FROM roles;
SELECT * FROM usuarios;
UPDATE usuarios SET
	usuario = "MaríaGomez"
	WHERE idusuario=2;
;

UPDATE roles SET
	rol = "Admin"
    WHERE idrol = 2;

UPDATE canales SET
	canal = 'Instagram'
    WHERE idcanal = 2;
    
INSERT INTO pais(pais) VALUES('Perú');

CREATE VIEW list_asesores AS

	SELECT
 
	FROM colaboradores c
    INNER JOIN 
    
SELECT * FROM canales;
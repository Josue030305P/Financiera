CREATE TABLE cronogramapagos(
idcronogramapago		INT PRIMARY KEY AUTO_INCREMENT,
idcontrato		 		INT NOT NULL,
numcuota		    	INT NOT NULL,
totalbruto			DECIMAL(10,2) NOT NULL, -- El pago pendiente 
totalneto			DECIMAL(10,2) NOT NULL,
amortizacion			DECIMAL(10,2) NOT NULL DEFAULT 0,
restante				DECIMAL(10,2) GENERATED ALWAYS AS (totalneto - amortizacion) STORED,
fechavencimiento		DATE NOT NULL, -- Para identificar hasta que fecha hay plazo para pagar
estado					ENUM('Pagado','Pendiente') DEFAULT 'Pendiente',
created_at 			DATETIME NOT NULL DEFAULT NOW() ,
updated_at 			DATETIME NULL,
CONSTRAINT fk_idcontrato_crono_pag FOREIGN KEY(idcontrato) REFERENCES contratos(idcontrato) 
) ENGINE=InnoDB; 
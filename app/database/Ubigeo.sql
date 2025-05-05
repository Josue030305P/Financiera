INSERT INTO departamentos (departamento) VALUES
('Amazonas'),
('Áncash'),
('Apurímac'),
('Arequipa'),
('Ayacucho'),
('Cajamarca'),
('Callao'),
('Cusco'),
('Huancavelica'),
('Huánuco'),
('Ica'),
('Junín'),
('La Libertad'),
('Lambayeque'),
('Lima'),
('Loreto'),
('Madre de Dios'),
('Moquegua'),
('Pasco'),
('Piura'),
('Puno'),
('San Martín'),
('Tacna'),
('Tumbes'),
('Ucayali');

SELECT * FROM departamentos;

-- PROVINCIAS

INSERT INTO provincias (iddepartamento, provincia) VALUES
(1, 'Chachapoyas'),
(1, 'Bagua'),
(1, 'Bongará'),
(1, 'Condorcanqui'),
(1, 'Luya'),
(1, 'Rodríguez de Mendoza'),
(1, 'Utcubamba'),
(2, 'Huaraz'),
(2, 'Aija'),
(2, 'Antonio Raymondi'),
(2, 'Asunción'),
(2, 'Bolognesi'),
(2, 'Carhuaz'),
(2, 'Carlos Fermín Fitzcarrald'),
(2, 'Casma'),
(2, 'Corongo'),
(2, 'Huari'),
(2, 'Huarmey'),
(2, 'Huaylas'),
(2, 'Mariscal Luzuriaga'),
(2, 'Ocros'),
(2, 'Pallasca'),
(2, 'Pomabamba'),
(2, 'Recuay'),
(2, 'Santa'),
(2, 'Sihuas'),
(2, 'Yungay'),
(3, 'Abancay'),
(3, 'Andahuaylas'),
(3, 'Antabamba'),
(3, 'Aymaraes'),
(3, 'Cotabambas'),
(3, 'Chincheros'),
(3, 'Grau'),
(4, 'Arequipa'),
(4, 'Camaná'),
(4, 'Caravelí'),
(4, 'Castilla'),
(4, 'Caylloma'),
(4, 'Condesuyos'),
(4, 'Islay'),
(4, 'La Unión'),
(5, 'Huamanga'),
(5, 'Cangallo'),
(5, 'Huanca Sancos'),
(5, 'Huanta'),
(5, 'La Mar'),
(5, 'Lucanas'),
(5, 'Parinacochas'),
(5, 'Pàucar del Sara Sara'),
(5, 'Sucre'),
(5, 'Víctor Fajardo'),
(5, 'Vilcas Huamán'),
(6, 'Cajamarca'),
(6, 'Cajabamba'),
(6, 'Celendín'),
(6, 'Chota'),
(6, 'Contumazá'),
(6, 'Cutervo'),
(6, 'Hualgayoc'),
(6, 'Jaén'),
(6, 'San Ignacio'),
(6, 'San Marcos'),
(6, 'San Miguel'),
(6, 'San Pablo'),
(6, 'Santa Cruz'),
(7, 'Prov. Const. del Callao'),
(8, 'Cusco'),
(8, 'Acomayo'),
(8, 'Anta'),
(8, 'Calca'),
(8, 'Canas'),
(8, 'Canchis'),
(8, 'Chumbivilcas'),
(8, 'Espinar'),
(8, 'La Convención'),
(8, 'Paruro'),
(8, 'Paucartambo'),
(8, 'Quispicanchi'),
(8, 'Urubamba'),
(9, 'Huancavelica'),
(9, 'Acobamba'),
(9, 'Angaraes'),
(9, 'Castrovirreyna'),
(9, 'Churcampa'),
(9, 'Huaytará'),
(9, 'Tayacaja'),
(10, 'Huánuco'),
(10, 'Ambo'),
(10, 'Dos de Mayo'),
(10, 'Huacaybamba'),
(10, 'Huamalíes'),
(10, 'Leoncio Prado'),
(10, 'Marañón'),
(10, 'Pachitea'),
(10, 'Puerto Inca'),
(10, 'Lauricocha'),
(10, 'Yarowilca'),
(11, 'Ica'),
(11, 'Chincha'),
(11, 'Nasca'),
(11, 'Palpa'),
(11, 'Pisco'),
(12, 'Huancayo'),
(12, 'Concepción'),
(12, 'Chanchamayo'),
(12, 'Jauja'),
(12, 'Junín'),
(12, 'Satipo'),
(12, 'Tarma'),
(12, 'Yauli'),
(12, 'Chupaca'),
(13, 'Trujillo'),
(13, 'Ascope'),
(13, 'Bolívar'),
(13, 'Chepén'),
(13, 'Julcán'),
(13, 'Otuzco'),
(13, 'Pacasmayo'),
(13, 'Pataz'),
(13, 'Sánchez Carrión'),
(13, 'Santiago de Chuco'),
(13, 'Gran Chimú'),
(13, 'Virú'),
(14, 'Chiclayo'),
(14, 'Ferreñafe'),
(14, 'Lambayeque'),
(15, 'Lima'),
(15, 'Barranca'),
(15, 'Cajatambo'),
(15, 'Canta'),
(15, 'Cañete'),
(15, 'Huaral'),
(15, 'Huarochirí'),
(15, 'Huaura'),
(15, 'Oyón'),
(15, 'Yauyos'),
(16, 'Maynas'),
(16, 'Alto Amazonas'),
(16, 'Loreto'),
(16, 'Mariscal Ramón Castilla'),
(16, 'Requena'),
(16, 'Ucayali'),
(16, 'Datem del Marañón'),
(16, 'Putumayo'),
(17, 'Tambopata'),
(17, 'Manu'),
(17, 'Tahuamanu'),
(18, 'Mariscal Nieto'),
(18, 'General Sánchez Cerro'),
(18, 'Ilo'),
(19, 'Pasco'),
(19, 'Daniel Alcides Carrión'),
(19, 'Oxapampa'),
(20, 'Piura'),
(20, 'Ayabaca'),
(20, 'Huancabamba'),
(20, 'Morropón'),
(20, 'Paita'),
(20, 'Sullana'),
(20, 'Talara'),
(20, 'Sechura'),
(21, 'Puno'),
(21, 'Azángaro'),
(21, 'Carabaya'),
(21, 'Chucuito'),
(21, 'El Collao'),
(21, 'Huancané'),
(21, 'Lampa'),
(21, 'Melgar'),
(21, 'Moho'),
(21, 'San Antonio de Putina'),
(21, 'San Román'),
(21, 'Sandia'),
(21, 'Yunguyo'),
(22, 'Moyobamba'),
(22, 'Bellavista'),
(22, 'El Dorado'),
(22, 'Huallaga'),
(22, 'Lamas'),
(22, 'Mariscal Cáceres'),
(22, 'Picota'),
(22, 'Rioja'),
(22, 'San Martín'),
(22, 'Tocache'),
(23, 'Tacna'),
(23, 'Candarave'),
(23, 'Jorge Basadre'),
(23, 'Tarata'),
(24, 'Tumbes'),
(24, 'Contralmirante Villar'),
(24, 'Zarumilla'),
(25, 'Coronel Portillo'),
(25, 'Atalaya'),
(25, 'Padre Abad'),
(25, 'Purús');

SELECT * FROM provincias;

SELECT * FROM distritos;
-- DISTRITOS

-- Amazonas Departamentomanta Distritukuna
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Chachapoyas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Asunción');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Balsas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Cheto');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Chiliquin');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Chuquibamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Granada');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Huancas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'La Jalca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Leimebamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Levanto');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Magdalena');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Mariscal Castilla');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Molinopampa');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Montevideo');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Olleros');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Quinjalca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'San Francisco de Daguas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'San Isidro de Maino');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Soloco');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Chachapoyas' AND iddepartamento = 1), 'Sonche');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bagua' AND iddepartamento = 1), 'Bagua');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bagua' AND iddepartamento = 1), 'Aramango');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bagua' AND iddepartamento = 1), 'Copallin');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bagua' AND iddepartamento = 1), 'El Parco');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bagua' AND iddepartamento = 1), 'Imaza');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bagua' AND iddepartamento = 1), 'La Peca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Jumbilla');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Chisquilla');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Churuja');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Corosha');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Cuispes');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Florida');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Jazan');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Recta');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'San Carlos');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Shipasbamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Valera');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bongará' AND iddepartamento = 1), 'Yambrasbamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Condorcanqui' AND iddepartamento = 1), 'Nieva');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Condorcanqui' AND iddepartamento = 1), 'El Cenepa');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Condorcanqui' AND iddepartamento = 1), 'Río Santiago');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Lamud');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Camporredondo');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Cocabamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Colcamar');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Conila');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Inguilpata');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Longuita');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Lonya Chico');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Luya');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Luya Viejo');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'María');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Ocalli');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Ocumal');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Pisuquia');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Providencia');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'San Cristóbal');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'San Francisco de Yeso');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'San Jerónimo');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'San Juan de Lopecancha');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Santa Catalina');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Santo Tomas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Tingo');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Luya' AND iddepartamento = 1), 'Trita');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'San Nicolás');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Chirimoto');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Cochamal');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Huambo');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Limabamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Longar');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Mariscal Benavides');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Milpuc');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Omia');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Santa Rosa');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Totora');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Rodríguez de Mendoza' AND iddepartamento = 1), 'Vista Alegre');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Utcubamba' AND iddepartamento = 1), 'Bagua Grande');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Utcubamba' AND iddepartamento = 1), 'Cajaruro');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Utcubamba' AND iddepartamento = 1), 'Cumba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Utcubamba' AND iddepartamento = 1), 'El Milagro');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Utcubamba' AND iddepartamento = 1), 'Jamalca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Utcubamba' AND iddepartamento = 1), 'Lonya Grande');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Utcubamba' AND iddepartamento = 1), 'Yamon');

-- Áncash Departamentomanta Distritukuna
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Huaraz');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Cochabamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Colcabamba');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Huanchay');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Independencia');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Jangas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'La Libertad');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Olleros');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Pampas Grande');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Pariacoto');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Pira');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Huaraz' AND iddepartamento = 2), 'Tarica');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Aija' AND iddepartamento = 2), 'Aija');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Aija' AND iddepartamento = 2), 'Coris');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Aija' AND iddepartamento = 2), 'Huacllan');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Aija' AND iddepartamento = 2), 'La Merced');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Aija' AND iddepartamento = 2), 'Succha');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Antonio Raymondi' AND iddepartamento = 2), 'Llamellin');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Antonio Raymondi' AND iddepartamento = 2), 'Aczo');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Antonio Raymondi' AND iddepartamento = 2), 'Chaccho');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Antonio Raymondi' AND iddepartamento = 2), 'Chingas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Antonio Raymondi' AND iddepartamento = 2), 'Mirgas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Antonio Raymondi' AND iddepartamento = 2), 'San Juan de Rontoy');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Asunción' AND iddepartamento = 2), 'Chacas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Asunción' AND iddepartamento = 2), 'Acochaca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Chiquian');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Abelardo Pardo Lezameta');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Antonio Raymondi');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Aquia');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Cajacay');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Canis');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Colquioc');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Huallanca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Huasta');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Huayllacayan');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'La Primavera');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Mangas');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Pacllon');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'San Miguel de Corpanqui');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Bolognesi' AND iddepartamento = 2), 'Ticllos');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Carhuaz');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Acopampa');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Amashca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Anta');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Ataquero');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Marcara');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Pariahuanca');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'San Miguel de Aco');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Shilla');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Tinco');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carhuaz' AND iddepartamento = 2), 'Yungar');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carlos Fermín Fitzcarrald' AND iddepartamento = 2), 'San Luis');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carlos Fermín Fitzcarrald' AND iddepartamento = 2), 'San Nicolás');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Carlos Fermín Fitzcarrald' AND iddepartamento = 2), 'Yauya');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Casma' AND iddepartamento = 2), 'Casma');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Casma' AND iddepartamento = 2), 'Buena Vista Alta');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Casma' AND iddepartamento = 2), 'Comandante Noel');
INSERT INTO distritos (idprovincia, distrito) VALUES ((SELECT idprovincia FROM provincias WHERE provincia = 'Casma' AND iddepartamento = 2), 'Yautan');


INSERT INTO distritos (idprovincia, distrito) VALUES
((SELECT idprovincia FROM provincias WHERE provincia = 'Corongo' AND iddepartamento = 2), 'Corongo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Corongo' AND iddepartamento = 2), 'Aco'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Corongo' AND iddepartamento = 2), 'Bambas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Corongo' AND iddepartamento = 2), 'Cusca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Corongo' AND iddepartamento = 2), 'La Pampa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Corongo' AND iddepartamento = 2), 'Yanac'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Corongo' AND iddepartamento = 2), 'Yupan'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Huari'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Anra'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Cajay'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Chavin de Huantar'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Huacachi'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Huacchis'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Huachis'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Huantar'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Masin'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Paucas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Ponto'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Rahuapampa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Rapayan'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'San Marcos'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'San Pedro de Chana'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huari' AND iddepartamento = 2), 'Uco'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huarmey' AND iddepartamento = 2), 'Huarmey'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huarmey' AND iddepartamento = 2), 'Cochapeti'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huarmey' AND iddepartamento = 2), 'Culebras'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huarmey' AND iddepartamento = 2), 'Huayan'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huarmey' AND iddepartamento = 2), 'Malvas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Caraz'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Huallanca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Huata'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Huaylas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Mato'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Pamparomas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Pueblo Libre'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Santa Cruz'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Santo Toribio'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Huaylas' AND iddepartamento = 2), 'Yuracmarca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Piscobamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Casca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Eleazar Guzmán Barron'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Fidel Olivas Escudero'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Llama'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Llumpa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Lucma'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Mariscal Luzuriaga' AND iddepartamento = 2), 'Musga'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Ocros'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Acas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Cajamarquilla'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Carhuapampa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Cochas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Congas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Llipa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'San Cristóbal de Rajan'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'San Pedro'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Ocros' AND iddepartamento = 2), 'Santiago de Chilcas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Cabana'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Bolognesi'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Conchucos'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Huacaschuque'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Huandoval'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Lacabamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Llapo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pallasca' AND iddepartamento = 2), 'Pallasca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pomabamba' AND iddepartamento = 2), 'Pomabamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pomabamba' AND iddepartamento = 2), 'Huayllan'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pomabamba' AND iddepartamento = 2), 'Parobamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Pomabamba' AND iddepartamento = 2), 'Quinuabamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Recuay'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Catac'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Cotaparaco'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Huayllapampa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Llacllin'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Marca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Pampas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Parquin'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Tapacocha'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Recuay' AND iddepartamento = 2), 'Ticapampa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Santa' AND iddepartamento = 2), 'Chimbote'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Santa' AND iddepartamento = 2), 'Cáceres del Perú'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Santa' AND iddepartamento = 2), 'Coishco'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Santa' AND iddepartamento = 2), 'Nepeña'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Santa' AND iddepartamento = 2), 'Samanco'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Santa' AND iddepartamento = 2), 'Santa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Santa' AND iddepartamento = 2), 'Nuevo Chimbote'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Sihuas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Acobamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Alfonso Ugarte'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Cashapampa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Chingalpo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Huayllabamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Quiches'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Ragash'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'San Juan'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Sihuas' AND iddepartamento = 2), 'Sicsibamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Yungay'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Cascapara'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Mancos'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Matacoto'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Quillo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Ranrahirca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Shupluy'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Yungay' AND iddepartamento = 2), 'Yanama');



-- ABANCAY
INSERT INTO distritos (idprovincia, distrito) VALUES
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'Abancay'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'Chacoche'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'Circa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'Curahuasi'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'Lambrama'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'Pichirhua'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'San José de Cachora'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Abancay' AND iddepartamento = 3), 'Tamburco'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Andahuaylas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Andarapa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Chiara'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Huancarama'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Huancaray'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Huayana'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Kishuara'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Pacobamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Pacucha'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Pumaqucha'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'San Antonio de Cachi'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'San Jerónimo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'San Miguel de Chaccrampa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Santa María'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Talavera'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Tumay Huaraca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Turpo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Andahuaylas' AND iddepartamento = 3), 'Kaqupata'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Antabamba' AND iddepartamento = 3), 'Antabamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Antabamba' AND iddepartamento = 3), 'Juan Espinoza Medrano'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Antabamba' AND iddepartamento = 3), 'Oropesa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Antabamba' AND iddepartamento = 3), 'Pachaconas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Antabamba' AND iddepartamento = 3), 'Sabaino'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Antabamba' AND iddepartamento = 3), 'Chalhuahuacho'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Antabamba' AND iddepartamento = 3), 'El Oro'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Chalhuanca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Capaya'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Caraybamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Chapimarca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Colcabamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Cotaruse'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Huayllo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Lucre'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Pocohuanca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Sañayca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Soraya'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Tapairihua'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Tintay'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Aymaraes' AND iddepartamento = 3), 'Yanaca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Cotabambas' AND iddepartamento = 3), 'Tambobamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Cotabambas' AND iddepartamento = 3), 'Cotabambas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Cotabambas' AND iddepartamento = 3), 'Coyllurqui'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Cotabambas' AND iddepartamento = 3), 'Haquira'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Cotabambas' AND iddepartamento = 3), 'Mara'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Cotabambas' AND iddepartamento = 3), 'Ollantay'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Cotabambas' AND iddepartamento = 3), 'Challhuahuacho'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Chincheros'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Anco_Huallo'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Cocharcas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Huaccana'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Ongoy'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Uranmarca'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Ranracancha'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Chincheros' AND iddepartamento = 3), 'Rocchacc'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Chuquibambilla'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Curpahuasi'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Huayllati'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Mamara'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Micaela Bastidas'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Pacocha'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'San Antonio'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Santa Rosa'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Turpay'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Vilcabamba'),
((SELECT idprovincia FROM provincias WHERE provincia = 'Grau' AND iddepartamento = 3), 'Virundo');





-- CHINCHA

INSERT INTO distritos (idprovincia, distrito) VALUES
(100, 'Chincha Alta'),
(100, 'Alto Larán'),
(100, 'Chavín'),
(100, 'Chincha Baja'),
(100, 'El Carmen'),
(100, 'Grocio Prado'),
(100, 'Pueblo Nuevo'),
(100, 'Sunampe'),
(100, 'Tambo de Mora'),
(100, 'Topará'),
(100, 'San Pedro de Huacarpana');

SELECT * FROM distritos;
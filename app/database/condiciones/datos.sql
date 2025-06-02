
USE financiera;
SELECT * FROM versiones;
DELETE FROM condiciones;
SELECT * FROM condiciones;

INSERT INTO condiciones(idversion,entidad, condicion)
        VALUES (1,'Mutuatario', 'se obliga a devolver a EL MUTUANTE la referida suma de dinero en la forma y oportunidad pactadas en el presente documento.'),
        (1,'Mutuatario', 'está obligado a devolver a EL MUTUANTE la suma del monto de capital invertido'),
        (1,'Mutuatario','Pagar puntualmente las cuotas acordadas de la forma y en los plazos señalados en el “Cronograma de Pago del Mutuatario"'),
        (1,'Mutuatario','EL MUTUATARIO devolverá la suma de dinero (objeto del préstamo) y su rentabilidad mensual, en la misma moneda, y deberá ser depositado en la cuenta del MUTUANTE.');


INSERT INTO condiciones(idversion,entidad, condicion)
    VALUES (1,'Mutuante', 'Cumplir con la presentación de documentos contables requeridos, referente a sus facturas de renta de segunda categoría.'),
            (1,'Mutuante','Informar al MUTUATARIO cualquier situación referente a sus cuentas bancarias a recibir su rentabilidad con anticipación.'),
            (1,'Mutuante','Que, los recursos que entrego para la(s) transacción(es) realizada provienen de fuentes de carácter Profesional, Actividades de Negocios, Actividades Productivas, de Servicios u otras Actividades lícitas referidas a…………………........................................................y que dichos fondos proceden de sus rentas de primera, segunda, tercera, cuarta y quinta categoría debidamente declaradas a la SUNAT con el pago de los impuestos respectivos.'),
            (1,'Mutuante','Que, los recursos que entrego no provienen de ninguna actividad ilícita contempladas en el Código Penal, Código Civil o Código Tributario Peruano o en cualquier norma que los modifique o adicione.'),
            (1,'Mutuante', 'Que, no estoy efectuando transacciones provenientes de las actividades ilícitas contempladas en el Código Penal, Código Civil o Código Tributario Peruano o en cualquier norma que lo modifique o adicione, a favor de personas relacionadas con las mismas.'),
            (1,'Mutuante', 'Que, en el caso de infracción de cualquiera de los numerales contenidos en este documento, eximo a la entidad de toda responsabilidad que se derive por información errónea, falsa o inexacta que yo hubiere proporcionado en este documento, o de la violación del mismo.')



ALTER TABLE condiciones MODIFY COLUMN condicion TEXT NOT NULL;
SELECT idversion, condicion FROM condiciones WHERE entidad = 'Mutuatario'; 

SELECT idversion, condicion FROM condiciones WHERE entidad = 'Mutuante'; 
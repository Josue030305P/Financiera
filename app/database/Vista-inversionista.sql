CREATE VIEW vista_inversionistas_resumida_profesional AS
SELECT
    i.idinversionista AS ID_Inversionista,
    IF(i.idpersona IS NOT NULL, CONCAT(p.nombres, ' ', p.apellidos), e.nombrecomercial) AS Inversionista,
    IF(i.idpersona IS NOT NULL, p.tipodocumento, 'RUC') AS Tipo_Doc,
    IF(i.idpersona IS NOT NULL, p.numdocumento, e.ruc) AS Numero_Doc,
    CONCAT(pa.pais, ' - ', dep.departamento, ' - ', prov.provincia, ' - ', dist.distrito) AS Ubicacion,
    u.usuario AS Asesor,
    i.estado AS Estado
FROM
    inversionistas i
LEFT JOIN
    personas p ON i.idpersona = p.idpersona
LEFT JOIN
    empresas e ON i.idempresa = e.idempresa
JOIN
    usuarios u ON i.idasesor = u.idusuario
LEFT JOIN
    pais pa ON p.idpais = pa.idpais
LEFT JOIN
    distritos dist ON p.iddistrito = dist.iddistrito
LEFT JOIN
    provincias prov ON dist.idprovincia = prov.idprovincia
LEFT JOIN
    departamentos dep ON prov.iddepartamento = dep.iddepartamento;
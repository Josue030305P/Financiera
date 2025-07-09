
DROP VIEW  list_inversionistas;
CREATE VIEW list_inversionistas AS
SELECT
    inv.idinversionista,
    CONCAT(p.nombres, ' ', p.apellidos) AS nombrecompleto,
    cont.capital,
    GROUP_CONCAT(DISTINCT nc.numcuenta SEPARATOR ', ') AS numeros_cuenta,
    GROUP_CONCAT(DISTINCT nc.cci SEPARATOR ', ') AS cci_cuentas,
    GROUP_CONCAT(DISTINCT ent.tipo SEPARATOR ', ') AS tipos_entidad,
    GROUP_CONCAT(DISTINCT ent.entidad SEPARATOR ', ') AS nombres_entidad,
    CONCAT(p_asesor.nombres, ' ', p_asesor.apellidos) AS nombre_completo_asesor
FROM
    inversionistas inv
LEFT JOIN
    personas p ON inv.idpersona = p.idpersona
LEFT JOIN
    contratos cont ON inv.idinversionista = cont.idinversionista
LEFT JOIN
    numcuentas nc ON cont.idcontrato = nc.idcontrato
LEFT JOIN
    entidades ent ON nc.identidad = ent.identidad
LEFT JOIN
    usuarios u ON inv.idasesor = u.idusuario
LEFT JOIN
    colaboradores col ON u.idcolaborador = col.idcolaborador
LEFT JOIN
    personas p_asesor ON col.idpersona = p_asesor.idpersona
   
    WHERE LOWER(inv.estado) = 'activo' 
    GROUP BY
    inv.idinversionista,
    p.nombres,
    p.apellidos,
    cont.capital,
    p_asesor.nombres

    ORDER BY inv.idinversionista DESC;


-- VOLVER A CREAR LA VISTA  LIST_INVERSIONSITAS















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
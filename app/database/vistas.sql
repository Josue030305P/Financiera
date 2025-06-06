
USE financiera;

-- Suponiendo que 'estado' en la tabla contratos indica si está activo (ej. 'Activo', 'Vigente')
SELECT COUNT(*) AS total_contratos_activos
FROM contratos
WHERE estado IN ('Activo', 'Vigente');

USE financiera;

SELECT COUNT(*) AS total_contratos_activos
FROM contratos
WHERE estado IN ('Activo', 'Vigente');
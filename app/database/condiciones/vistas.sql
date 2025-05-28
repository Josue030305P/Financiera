USE financiera;


CREATE VIEW vista_condiciones_activas AS

SELECT c.*
FROM condiciones c
JOIN versiones v ON c.idversion = v.idversion
WHERE v.fechafin IS NULL;

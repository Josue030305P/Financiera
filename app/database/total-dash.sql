
USE financiera;

-- Vista para el total de contratos activos
DROP VIEW IF EXISTS v_total_contratos_activos;
CREATE VIEW v_total_contratos_activos AS
SELECT COUNT(*) AS contratos_activos
FROM contratos
WHERE estado = 'Vigente';

-- Vista para el monto total invertido en contratos vigentes
DROP VIEW IF EXISTS v_monto_total_invertido;
CREATE VIEW v_monto_total_invertido AS
SELECT SUM(capital) AS monto_total_invertido
FROM contratos
WHERE estado = 'Vigente';

-- Vista para la cantidad de próximos pagos pendientes (60 días)
DROP VIEW IF EXISTS v_proximos_pagos_cantidad_60d; -- Nombre actualizado para reflejar 60 días
CREATE VIEW v_proximos_pagos_cantidad_60d AS
SELECT COUNT(*) AS proximos_pagos_cantidad
FROM cronogramapagos cp
JOIN contratos c ON cp.idcontrato = c.idcontrato
WHERE cp.estado = 'Pendiente'
AND cp.fechavencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 60 DAY)
AND c.estado = 'Vigente';

SELECT * FROM v_proximos_pagos_cantidad_60d 

-- Vista para la fecha del próximo pago más cercano
DROP VIEW IF EXISTS v_proximo_pago_fecha_cercana;
CREATE VIEW v_proximo_pago_fecha_cercana AS
SELECT MIN(cp.fechavencimiento) AS proximo_pago_fecha
FROM cronogramapagos cp
JOIN contratos c ON cp.idcontrato = c.idcontrato
WHERE cp.estado != 'Pagado' -- Considera tanto Pendiente como Vencido para el "próximo" pago
AND cp.fechavencimiento >= CURDATE()
AND c.estado = 'Vigente';

-- Vista para el total de leads en proceso
DROP VIEW IF EXISTS v_total_leads_en_proceso;
CREATE VIEW v_total_leads_en_proceso AS
SELECT COUNT(*) AS leads_en_proceso
FROM leads
WHERE estado IN ('Nuevo contacto', 'En proceso');

-- Vista para el total de contratos por vencer (60 días)
DROP VIEW IF EXISTS v_total_contratos_por_vencer_60d;
CREATE VIEW v_total_contratos_por_vencer_60d AS
SELECT COUNT(*) AS contratos_por_vencer
FROM contratos
WHERE fechafin IS NOT NULL
AND fechafin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 60 DAY)
AND estado = 'Vigente';
SELECT * FROM v_total_contratos_por_vencer_60d;

-- Vista para el total de colaboradores activos
DROP VIEW IF EXISTS v_total_colaboradores_activos;
CREATE VIEW v_total_colaboradores_activos AS
SELECT COUNT(col.idcolaborador) AS colaboradores_activos
FROM colaboradores col
JOIN personas p ON col.idpersona = p.idpersona
WHERE p.estado = 'Colaborador';

-- Vista para el total de pagos realizados hoy
DROP VIEW IF EXISTS v_total_pagos_realizados_hoy;
CREATE VIEW v_total_pagos_realizados_hoy AS
SELECT COUNT(iddetallepago) AS total_pagos_hoy
FROM detallepagos
WHERE DATE(fechahora) = CURDATE();






USE financiera

-- Vista para el total de pagos realizados AYER (suma el monto)
DROP VIEW IF EXISTS v_total_pagos_realizados_ayer;
CREATE VIEW v_total_pagos_realizados_ayer AS
SELECT SUM(dp.monto) AS total_monto_pagado_ayer
FROM detallepagos dp
WHERE DATE(dp.fechahora) = CURDATE() - INTERVAL 1 DAY;

-- Vista para el total de pagos realizados en la SEMANA ACTUAL (suma el monto)
DROP VIEW IF EXISTS v_total_pagos_realizados_semana_actual;
CREATE VIEW v_total_pagos_realizados_semana_actual AS
SELECT SUM(dp.monto) AS total_monto_pagado_semana_actual
FROM detallepagos dp
WHERE DATE(dp.fechahora) BETWEEN DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
AND DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 6 DAY);



-- Nueva vista para el total de pagos realizados en el MES ACTUAL (suma el monto)
DROP VIEW IF EXISTS v_total_pagos_realizados_mes_actual;
CREATE VIEW v_total_pagos_realizados_mes_actual AS
SELECT SUM(dp.monto) AS total_monto_pagado_mes_actual
FROM detallepagos dp
WHERE YEAR(dp.fechahora) = YEAR(CURDATE()) AND MONTH(dp.fechahora) = MONTH(CURDATE());





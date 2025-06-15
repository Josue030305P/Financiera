<?php

require_once '../config/Database.php';

class Dashboard
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

    /**
     * Obtiene las métricas de resumen para los widgets del dashboard.
     * @return array Array asociativo con las métricas.
     * @throws Exception Si ocurre un error al consultar la base de datos.
     */
    public function obtenerMetricasResumen()
    {
        $metrics = [];
        try {
            $stmt = $this->conexion->query("SELECT contratos_activos FROM v_total_contratos_activos");
            $metrics['contratos_activos'] = $stmt->fetch(PDO::FETCH_ASSOC)['contratos_activos'];

            $stmt = $this->conexion->query("SELECT monto_total_invertido FROM v_monto_total_invertido");
            $metrics['monto_total_invertido'] = $stmt->fetch(PDO::FETCH_ASSOC)['monto_total_invertido'];

            $stmt = $this->conexion->query("SELECT proximos_pagos_cantidad FROM v_proximos_pagos_cantidad_60d");
            $metrics['proximos_pagos_cantidad'] = $stmt->fetch(PDO::FETCH_ASSOC)['proximos_pagos_cantidad'];

            $stmt = $this->conexion->query("SELECT proximo_pago_fecha FROM v_proximo_pago_fecha_cercana");
            $metrics['proximo_pago_fecha'] = $stmt->fetch(PDO::FETCH_ASSOC)['proximo_pago_fecha'];

            $stmt = $this->conexion->query("SELECT leads_en_proceso FROM v_total_leads_en_proceso");
            $metrics['leads_en_proceso'] = $stmt->fetch(PDO::FETCH_ASSOC)['leads_en_proceso'];

            $stmt = $this->conexion->query("SELECT contratos_por_vencer FROM v_total_contratos_por_vencer_60d");
            $metrics['contratos_por_vencer'] = $stmt->fetch(PDO::FETCH_ASSOC)['contratos_por_vencer'];

            $stmt = $this->conexion->query("SELECT colaboradores_activos FROM v_total_colaboradores_activos");
            $metrics['colaboradores_activos'] = $stmt->fetch(PDO::FETCH_ASSOC)['colaboradores_activos'];

            // NUEVA MÉTRICA DE RESUMEN: Total de pagos realizados hoy
            $stmt = $this->conexion->query("SELECT total_pagos_hoy FROM v_total_pagos_realizados_hoy");
            $metrics['total_pagos_hoy'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_pagos_hoy'];

             // NUEVA MÉTRICA DE RESUMEN: Total de pagos realizados ayer
            $stmt = $this->conexion->query("SELECT total_monto_pagado_ayer FROM v_total_pagos_realizados_ayer");
            $metrics['total_monto_pagado_ayer'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_monto_pagado_ayer'];

             // NUEVA MÉTRICA DE RESUMEN: Total de pagos realizados en la semana
            $stmt = $this->conexion->query("SELECT total_monto_pagado_semana_actual FROM v_total_pagos_realizados_semana_actual ");
            $metrics['total_monto_pagado_semana_actual'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_monto_pagado_semana_actual'];

            // NUEVA MÉTRICA DE RESUMEN: Total de pagos realizados en el mes actual
            $stmt = $this->conexion->query("SELECT total_monto_pagado_mes_actual FROM v_total_pagos_realizados_mes_actual ");
            $metrics['total_monto_pagado_mes_actual'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_monto_pagado_mes_actual'];




        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerMetricasResumen: " . $e->getMessage());
            throw new Exception("Error al obtener las métricas del dashboard. Por favor, intente de nuevo más tarde.");
        }
        return $metrics;
    }

    /**
     * Obtiene el listado de contratos activos.
     * @return array Array de contratos activos.
     * @throws Exception Si ocurre un error al consultar la base de datos.
     */
    public function obtenerListadoContratosActivos()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_contratos_activos");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoContratosActivos: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de contratos activos.");
        }
    }

    /**
     * Obtiene el listado de próximos pagos pendientes.
     * @return array Array de próximos pagos pendientes.
     * @throws Exception Si ocurre un error al consultar la base de datos.
     */
    public function obtenerListadoProximosPagosPendientes()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_proximos_pagos_pendientes");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoProximosPagosPendientes: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de próximos pagos.");
        }
    }

    /**
     * Obtiene el listado de leads en proceso.
     * @return array Array de leads en proceso.
     * @throws Exception Si ocurre un error al consultar la base de datos.
     */
    public function obtenerListadoLeadsEnProceso()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_leads_en_proceso");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoLeadsEnProceso: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de leads en proceso.");
        }
    }

    /**
     * Obtiene el listado de contratos por vencer.
     * @return array Array de contratos por vencer.
     * @throws Exception Si ocurre un error al consultar la base de datos.
     */
    public function obtenerListadoContratosPorVencer()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_contratos_por_vencer");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoContratosPorVencer: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de contratos por vencer.");
        }
    }

    /**
     * Obtiene el listado de colaboradores activos.
     * @return array Array de colaboradores activos.
     * @throws Exception Si ocurre un error al consultar la base de datos.
     */
    public function obtenerListadoColaboradoresActivos()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_colaboradores_activos");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoColaboradoresActivos: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de colaboradores activos.");
        }
    }

    /**
     * Obtiene el listado de pagos realizados hoy, incluyendo la cantidad de pagos por persona.
     * @return array Array de pagos realizados hoy.
     * @throws Exception Si ocurre un error al consultar la base de datos.
     */
    public function obtenerListadoPagosRealizadosHoy()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_pagos_realizados_hoy");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoPagosRealizadosHoy: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de pagos realizados hoy.");
        }
    }

    public function obtenerListadoPagosRealizadosAyer()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_pagos_realizados_ayer");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoPagosRealizadosHoy: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de pagos realizados ayer.");
        }
    }

     public function obtenerListadoPagosSemanaActual()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_pagos_realizados_semana_actual");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoPagosRealizadosHoy: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de pagos realizados en la semana actual.");
        }
    }
    

    public function obtenerListadoPagosMesActual()
    {
        try {
            $stmt = $this->conexion->query("SELECT * FROM v_listado_pagos_realizados_mes_actual");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Dashboard::obtenerListadoPagosRealizadosHoy: " . $e->getMessage());
            throw new Exception("Error al obtener la lista de pagos realizados en el mes actual.");
        }
    }
}
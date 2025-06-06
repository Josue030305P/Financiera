<?php

require_once '../models/Dashboard.php';

// Establece la cabecera para que la respuesta sea JSON y se interprete correctamente.
if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    $dashboardModel = new Dashboard();

    // Maneja las diferentes solicitudes HTTP.
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            try {
                // Obtiene todas las métricas de resumen.
                $metricasResumen = $dashboardModel->obtenerMetricasResumen();

                // Obtiene todos los listados detallados.
                $listadoContratosActivos = $dashboardModel->obtenerListadoContratosActivos();
                $listadoProximosPagosPendientes = $dashboardModel->obtenerListadoProximosPagosPendientes();
                $listadoLeadsEnProceso = $dashboardModel->obtenerListadoLeadsEnProceso();
                $listadoContratosPorVencer = $dashboardModel->obtenerListadoContratosPorVencer();
                $listadoColaboradoresActivos = $dashboardModel->obtenerListadoColaboradoresActivos();
                $listadoPagosRealizadosHoy = $dashboardModel->obtenerListadoPagosRealizadosHoy(); // Nueva lista

                // Responde con un JSON que contiene tanto las métricas como los listados.
                echo json_encode([
                    "status" => true,
                    "data" => [
                        "resumen" => $metricasResumen, // Cambiado 'summary' a 'resumen'
                        "listados" => [ // Cambiado 'lists' a 'listados'
                            "contratos_activos" => $listadoContratosActivos,
                            "proximos_pagos" => $listadoProximosPagosPendientes,
                            "leads_en_proceso" => $listadoLeadsEnProceso,
                            "contratos_por_vencer" => $listadoContratosPorVencer,
                            "colaboradores_activos" => $listadoColaboradoresActivos,
                            "pagos_hoy" => $listadoPagosRealizadosHoy // Nombre en español para la lista
                        ]
                    ]
                ]);
            } catch (Exception $e) {
                // Captura cualquier excepción y responde con un mensaje de error.
                echo json_encode([
                    'status' => false,
                    'message' => 'Error al obtener los datos del dashboard: ' . $e->getMessage()
                ]);
                error_log('DashboardController Error: ' . $e->getMessage()); // Registra el error para depuración
            }
            break;

      
    }
} else {
    // Si se intenta acceder directamente al archivo sin una solicitud HTTP, deniega el acceso.
    http_response_code(403); // Prohibido
    echo json_encode([
        'status' => false,
        'message' => 'Acceso directo no permitido.'
    ]);
}
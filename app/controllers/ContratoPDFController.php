<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    header('Content-Type: application/json; charset=utf-8');
    require_once '../models/Contrato.php';

    $contrato = new Contrato();

    if (isset($_GET['idcontrato'])) {
        try {
            $idcontrato = (int)$_GET['idcontrato'];
            error_log("Buscando contrato ID: " . $idcontrato);
            
            $resultado = $contrato->getDatosPDF($idcontrato);
            error_log("Resultado de la búsqueda: " . print_r($resultado, true));
            
            if ($resultado) {
                // Procesar el cronograma de pagos
                if (isset($resultado['cronograma_pagos'])) {
                    $cronograma = [];
                    $cuotas = explode(';', $resultado['cronograma_pagos']);
                    foreach ($cuotas as $cuota) {
                        list($numcuota, $fecha, $bruto, $neto) = explode('|', $cuota);
                        $cronograma[] = [
                            'numcuota' => $numcuota,
                            'fecha' => $fecha,
                            'totalbruto' => $bruto,
                            'totalneto' => $neto
                        ];
                    }
                    $resultado['cronograma_pagos'] = $cronograma;
                }
                
                error_log("Datos procesados: " . print_r($resultado, true));
                echo json_encode($resultado);
            } else {
                error_log("No se encontró el contrato con ID: " . $idcontrato);
                echo json_encode(['error' => 'No se encontró el contrato']);
            }
        } catch (Exception $e) {
            error_log("Error en ContratoPDFController: " . $e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        error_log("No se proporcionó ID de contrato");
        echo json_encode(['error' => 'ID de contrato no proporcionado']);
    }
} 
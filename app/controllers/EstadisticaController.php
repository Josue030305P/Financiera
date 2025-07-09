<?php
require_once '../models/Estadistica.php';

$estadistica = new Estadistica();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        if (isset($_GET['tipo'])) {
            switch ($_GET['tipo']) {
                case 'convertidos':
                    $data = $estadistica->obtenerLeadsConvertidosPorCanal();
                    break;
                case 'inversionistas_por_asesor':
                    $data = $estadistica->obtenerInversionistasPorAsesor();
                    break;
                default:
                    $data = $estadistica->obtenerLeadsPorCanal();
                    break;
            }
        } else {
            $data = $estadistica->obtenerLeadsPorCanal();
        }

        echo json_encode($data);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}


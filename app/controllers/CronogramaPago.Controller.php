<?php

require_once '../models/CronogramaPago.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    $cronograma = new CronogramaPago();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);

            $idcontrato = $dataJSON['idcontrato'];
            $cuotas = $dataJSON['cuotas'];

            try {
                $result = $cronograma->add($idcontrato, $cuotas);
                echo json_encode([
                    "status" => "success",
                    "message" => "Cronograma generado correctamente",
                    "data" => $result
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al generar el cronograma: ' . $e->getMessage()
                ]);
            }
            break;
    }
}
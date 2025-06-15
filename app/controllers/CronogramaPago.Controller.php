<?php

require_once '../models/CronogramaPago.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    $cronograma = new CronogramaPago();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);
            error_log("Datos recibidos: " . print_r($dataJSON, true));
            $idcontrato = $dataJSON['idcontrato'];
            $cuotas = $dataJSON['cuotas'];
            error_log("Primera cuota: " . print_r($cuotas[0] ?? 'Sin cuotas', true));
            try {
                $result = $cronograma->add($idcontrato, $cuotas);
                echo json_encode([
                    "status" => "success",
                    "message" => "Cronograma generado correctamente",
                    "data" => $result
                ]);
                exit();
            } catch (Exception $e) {
                echo json_encode([
                    'status' => "error",
                    'message' => 'Error al generar el cronograma: ' . $e->getMessage()
                ]);

            }
            break;

        case 'GET':
            if (isset($_GET['idcontrato'])) {
                $idcontrato = $_GET['idcontrato'];
                try {
                    $resultados = $cronograma->obtenerPorContrato($idcontrato);
                    echo json_encode([
                        "status" => "success",
                        "data" => $resultados
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al obtener cronogramas por contrato: ' . $e->getMessage()
                    ]);
                }
            } else {


                // Obtener los coronogramas con filtros
                $filtros = [
                    'estado' => isset($_GET['estado']) ? $_GET['estado'] : '',
                    'idcontrato' => isset($_GET['idcontrato_filtro']) ? intval($_GET['idcontrato_filtro']) : '', // Diferenciar del id_contrato para vista individual
                    'dni' => isset($_GET['dni']) ? $_GET['dni'] : ''
                ];


                $filtros['estado'] = filter_var($filtros['estado'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $filtros['dni'] = filter_var($filtros['dni'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);



                try {
                    $resultados = $cronograma->obtenerTodosFiltrado($filtros);
                    echo json_encode([
                        "status" => "success",
                        "data" => $resultados
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al obtener los cronogramas: ' . $e->getMessage()
                    ]);
                }
            }
    }
}

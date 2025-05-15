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
                    'fechainicio' => isset($_GET['fechainicio']) ? $_GET['fechainicio'] : '',
                    'fechafin' => isset($_GET['fechafin']) ? $_GET['fechafin'] : '',
                    'idcontrato' => isset($_GET['idcontrato_filtro']) ? intval($_GET['idcontrato_filtro']) : '', // Diferenciar del id_contrato para vista individual
                    'dni' => isset($_GET['dni']) ? $_GET['dni'] : ''
                ];


                $filtros['estado'] = filter_var($filtros['estado'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $filtros['fechainicio'] = filter_var($filtros['fechainicio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $filtros['fechafin'] = filter_var($filtros['fechafin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

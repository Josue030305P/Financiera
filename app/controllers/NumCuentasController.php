<?php

require_once '../models/Numcuentas.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    $numCuenta = new Numcuentas();

    switch ($_SERVER['REQUEST_METHOD']) {



        case 'GET':
            if (isset($_GET['idcontrato'])) {
                $idcontrato = $_GET['idcontrato'];
                try {
                    $resultados = $numCuenta->getNumcuentasByContrato($idcontrato);
                    echo json_encode([
                        "status" => "success",
                        "data" => $resultados
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al obtener los número de cuentas del contrato: ' . $e->getMessage()
                    ]);
                }
            }
            break;
        case 'POST':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);


            $registro = [
                'idcontrato'    => htmlspecialchars($dataJSON['idcontrato'] ?? ''),
                'identidad'     => htmlspecialchars($dataJSON['identidad'] ?? ''),
                'numcuenta'     => htmlspecialchars($dataJSON['numcuenta'] ?? ''),
                'cci'           => htmlspecialchars($dataJSON['cci'] ?? ''),
                'observaciones' => htmlspecialchars($dataJSON['observaciones'] ?? null)
            ];

            try {


                $result = $numCuenta->add($registro);


                echo json_encode([
                    "status" => $result['success'] ? "success" : "error",
                    "message" => $result['success'] ? "Número de cuenta agregado correctamente" : ($result['message'] ?? "Error desconocido"),
                    "data" => $result
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error interno del servidor: " . $e->getMessage()
                ]);
            }
            break;
    }
}

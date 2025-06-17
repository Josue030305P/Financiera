<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Colaborador.php';

    $colaborador = new Colaborador();

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':

            try {
                $resultados = $colaborador->getPersonaColaborador();
                echo json_encode($resultados
                );
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al obtener la persona colaborador: ' . $e->getMessage()
                ]);
            }

            break;


        case 'POST':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);


            $registro = [
                'idpersona'    => htmlspecialchars($dataJSON['idpersona']),
                'idrol'     => htmlspecialchars($dataJSON['idrol']),
                'fechainicio'     => htmlspecialchars($dataJSON['fechainicio']),
                'fechafin' => htmlspecialchars($dataJSON['fechafin']),
                'observaciones' => htmlspecialchars($dataJSON['observaciones']),

            ];

            try {


                $result = $colaborador->add($registro);

                echo json_encode(
                    $result
                );
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error interno del servidor: " . $e->getMessage()
                ]);
            }
            break;
    }
}

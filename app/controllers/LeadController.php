<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Lead.php';

    $lead = new Lead();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':

            if (isset($_GET['id'])) {
                try {
                    $result = $lead->getById($_GET['id']);
                    echo json_encode([
                        "status" => "success",
                        "data" => $result
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => "error",
                        "message" => $e->getMessage()
                    ]);
                }
            } else {

                echo json_encode($lead->getAll());
            }
            break;

        case 'POST':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);

            // Verificar si es un array (importación desde Excel)
            if (isset($dataJSON[0])) {
                $results = [];
                $errors = [];
                $successCount = 0;

                foreach ($dataJSON as $registro) {
                    try {
                        $data = [
                            'idpais' => htmlspecialchars($registro['idpais'] ?? $registro['País'] ?? ''),
                            'apellidos' => htmlspecialchars($registro['apellidos'] ?? $registro['Apellidos'] ?? ''),
                            'nombres' => htmlspecialchars($registro['nombres'] ?? $registro['Nombres'] ?? ''),
                            'email' => htmlspecialchars($registro['email'] ?? $registro['Correo'] ?? ''),
                            'telprincipal' => htmlspecialchars($registro['telprincipal'] ?? $registro['Teléfono'] ?? ''),
                            'idasesor' => htmlspecialchars($registro['idasesor'] ?? $registro['Asesor'] ?? ''),
                            'idcanal' => htmlspecialchars($registro['idcanal'] ?? $registro['Canal'] ?? ''),
                            'comentarios' => htmlspecialchars($registro['comentarios'] ?? $registro['Comentarios'] ?? ''),
                            'prioridad' => htmlspecialchars($registro['prioridad'] ?? $registro['Prioridad'] ?? ''),
                            'ocupacion' => htmlspecialchars($registro['ocupacion'] ?? $registro['Ocupación'] ?? '')
                        ];

                        $result = $lead->add($data);
                        $successCount++;
                    } catch (Exception $e) {
                        $errors[] = [
                            'registro' => $registro,
                            'error' => $e->getMessage()
                        ];
                    }
                }

                echo json_encode([
                    "status" => "success",
                    "message" => "Importación completada",
                    "success_count" => $successCount,
                    "error_count" => count($errors),
                    "errors" => $errors
                ]);
            } else {
                // Si no es un excel, agregar de mi formulario normal
                $registro = [
                    'idpais' => htmlspecialchars($dataJSON['idpais']),
                    'apellidos' => htmlspecialchars($dataJSON['apellidos']),
                    'nombres' => htmlspecialchars($dataJSON['nombres']),
                    'email' => htmlspecialchars($dataJSON['email']),
                    'telprincipal' => htmlspecialchars($dataJSON['telprincipal']),
                    'idasesor' => htmlspecialchars($dataJSON['idasesor']),
                    'idcanal' => htmlspecialchars($dataJSON['idcanal']),
                    'comentarios' => htmlspecialchars($dataJSON['comentarios']),
                    'prioridad' => htmlspecialchars($dataJSON['prioridad']),
                    'ocupacion' => htmlspecialchars($dataJSON['ocupacion'])
                ];

                try {
                    $result = $lead->add($registro);
                    echo json_encode([
                        "status" => "success",
                        "message" => "Lead agregado correctamente",
                        "data" => $result
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => "error",
                        "message" => $e->getMessage()
                    ]);
                }
            }
            break;

        case 'PUT':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);

            if (!isset($_GET['id'])) {
                echo json_encode([
                    "status" => "error",
                    "message" => "ID no proporcionado"
                ]);
                break;
            }

            $registro = [
                'tipodocumento' => htmlspecialchars($dataJSON['tipodocumento']),
                'numdocumento'=> htmlspecialchars($dataJSON['numdocumento']),
                'idpais' => htmlspecialchars($dataJSON['idpais']),
                'iddistrito'=> htmlspecialchars($dataJSON['iddistrito']),
                'apellidos' => htmlspecialchars($dataJSON['apellidos']),
                'nombres' => htmlspecialchars($dataJSON['nombres']),
                'fechanacimiento'=> htmlspecialchars($dataJSON['fechanacimiento']),
                'email' => htmlspecialchars($dataJSON['email']),
                'domicilio'=> htmlspecialchars($dataJSON['domicilio']),
                'telprincipal' => htmlspecialchars($dataJSON['telprincipal']),
                'telsecundario'=> htmlspecialchars($dataJSON['telsecundario']),
                'referencia'=> htmlspecialchars($dataJSON['referencia']),
                'idasesor' => htmlspecialchars($dataJSON['idasesor']),
                'idcanal' => htmlspecialchars($dataJSON['idcanal']),
                'comentarios' => htmlspecialchars($dataJSON['comentarios']),
                'prioridad' => htmlspecialchars($dataJSON['prioridad']),
                'ocupacion' => htmlspecialchars($dataJSON['ocupacion'])
            ];

            try {
                $result = $lead->update($_GET['id'], $registro);
                echo json_encode([
                    "status" => "success",
                    "message" => "Lead actualizado correctamente",
                    "data" => $result
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }
            break;

        case 'DELETE':
            if (!isset($_GET['id'])) {
                echo json_encode([
                    "status" => "error",
                    "message" => "ID no proporcionado"
                ]);
                break;
            }

            try {
                $result = $lead->delete($_GET['id']);
                echo json_encode([
                    "status" => "success",
                    "message" => "Lead eliminado correctamente",
                    "data" => $result
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }
            break;

        default:
            echo json_encode(["error" => "Método no soportado"]);
            break;
    }
}


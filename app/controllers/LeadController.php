<?php
if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Lead.php';

    $lead = new Lead();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            echo json_encode($lead->getAll());
            break;

            case 'POST':
                $input = file_get_contents('php://input');
                $dataJSON = json_decode($input, true);
                
                $registro = [
                    'idpais'       => htmlspecialchars($dataJSON['idpais']),
                    'apellidos'    => htmlspecialchars($dataJSON['apellidos']),
                    'nombres'      => htmlspecialchars($dataJSON['nombres']),
                    'email'        => htmlspecialchars($dataJSON['email']),
                    'telprincipal' => htmlspecialchars($dataJSON['telprincipal']),
                    'idasesor'     => htmlspecialchars($dataJSON['idasesor']),
                    'idcanal'      => htmlspecialchars($dataJSON['idcanal']),
                    'comentarios'  => htmlspecialchars($dataJSON['comentarios']),
                    'prioridad'    => htmlspecialchars($dataJSON['prioridad']),
                    'ocupacion'    => htmlspecialchars($dataJSON['ocupacion'])
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
                break;
        default:
            echo json_encode(["error" => "Método no soportado"]);
            break;
    }
}


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
                'iddistrito'   => htmlspecialchars($dataJSON['iddistrito'] ?? 1),
                'apellidos'    => htmlspecialchars($dataJSON['apellidos']),
                'nombres'      => htmlspecialchars($dataJSON['nombres']),
                'email'        => htmlspecialchars($dataJSON['email']),
                'telprincipal' => htmlspecialchars($dataJSON['telprincipal']),
                'idasesor'     => htmlspecialchars($dataJSON['idasesor'] ?? 1),
                'idcanal'      => htmlspecialchars($dataJSON['idcanal'] ?? 1),
                'comentarios'  => htmlspecialchars($dataJSON['comentarios']),
                'prioridad'    => htmlspecialchars($dataJSON['prioridad']),
                'ocupacion'    => htmlspecialchars($dataJSON['ocupacion'])
            ];

            try {
                $n = $lead->add($registro);
                echo json_encode(["rows" => $n]);
            } catch (Exception $e) {
                echo json_encode(["error" => $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(["error" => "Método no soportado"]);
            break;
    }
}


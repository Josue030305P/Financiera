<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Contactibilidad.php';

    $contacto = new Contactibilidad();

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            echo json_encode($contacto->getAll());
            break;


       case 'POST':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);

            
            $registro = [
                'idlead'    => htmlspecialchars($dataJSON['idlead']),
                'fecha'     => htmlspecialchars($dataJSON['fecha']),
                'hora'     => htmlspecialchars($dataJSON['hora']),
                'comentarios' => htmlspecialchars($dataJSON['comentarios']),
                'estado' => htmlspecialchars($dataJSON['estado'])
            ];

            try {

                
                $result = $contacto->add($registro);

           
                echo json_encode([
                    "status" => $result['success'] ? "success" : "error", 
                    "message" => $result['success'] ? "Conctacto agregado correctamente" : ($result['message'] ?? "Error desconocido"),
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

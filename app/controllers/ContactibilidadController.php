<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Contactibilidad.php';

    $contacto = new Contactibilidad();

    switch ($_SERVER['REQUEST_METHOD']) {

             case 'GET':
            if (isset($_GET['id'])) {
                try {
                    $idcontactibilidad = (int)$_GET['id'];
                    $data = $contacto->getById($idcontactibilidad);
                    if ($data) {
                        echo json_encode(["status" => "success", "data" => $data]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "Contacto no encontrado."]);
                    }
                } catch (Exception $e) {
                    echo json_encode(["status" => "error", "message" => "Error al obtener contacto: " . $e->getMessage()]);
                }
            } else {
                echo json_encode($contacto->getAll());
            }
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



            case 'PUT': 
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);

            $idcontactibilidad = $_GET['id'] ?? null;

            if (!$idcontactibilidad || !is_numeric($idcontactibilidad)) {
                echo json_encode(["status" => "error", "message" => "ID de contactibilidad no proporcionado o inválido."]);
                exit();
            }

            try {
                $result = $contacto->update((int)$idcontactibilidad, $dataJSON);
                echo json_encode([
                    "status" => $result['success'] ? "success" : "error",
                    "message" => $result['success'] ? "Contacto actualizado correctamente." : "No se pudo actualizar el contacto.",
                    "rows" => $result['rows']
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error al actualizar contacto: " . $e->getMessage()
                ]);
            }
            break;


            
       case 'DELETE':
            $idcontactibilidad = $_GET['id'] ?? null;

            if ($idcontactibilidad === null) {
                echo json_encode([
                    'status' => false,
                    'message' => 'ID de contacto no proporcionado para la eliminación.'
                ]);
                break;
            }

            try {
                $result = $contacto->delete((int) $idcontactibilidad);
                echo json_encode($result);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Error al eliminar el contacto: ' . $e->getMessage()
                ]);
            }
            break;

    }
}

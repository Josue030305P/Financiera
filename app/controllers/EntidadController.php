<?php 





/*

require_once '../models/Entidad.php'; 

header('Content-Type: application/json'); 

$response = [
    'success' => false,
    'message' => 'Error desconocido.',
    'data' => []
];

try {
    $entidad = new Entidad();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
           
            if ($tipo === 'Banco' || $tipo === 'Caja') {
                $entities = $entidad->getByTipo($tipo);
                $response['success'] = true;
                $response['message'] = 'Entidades obtenidas exitosamente.';
                $response['data'] = $entities;
            } else {
                $response['message'] = 'Tipo de entidad inválido.';
            }
        } else {
            
            $response['message'] = 'Parámetro "tipo" es requerido para esta operación.';
        }
    } else {
        $response['message'] = 'Método de solicitud no permitido.';
        http_response_code(405); 
    }
} catch (Exception $e) {
    $response['message'] = 'Error en el servidor: ' . $e->getMessage();
    http_response_code(500); 
}

echo json_encode($response);
*/

 
require_once '../models/Entidad.php'; 

header('Content-Type: application/json; charset=utf-8'); 

try {
    $entidadModel = new Entidad();
    $result = []; 

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['action']) && $_GET['action'] === 'get_types') {
         
            $tipos = $entidadModel->getTiposUnicos();
            $result = [
                'status' => 'success',
                'message' => 'Tipos de entidad obtenidos exitosamente.',
                'data' => $tipos
            ];
        } elseif (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
           
            $tipo = $_GET['tipo'];
           
            if ($tipo === 'Banco' || $tipo === 'Caja') {
                $entities = $entidadModel->getByTipo($tipo);
                $result = [
                    'status' => 'success',
                    'message' => 'Entidades obtenidas exitosamente.',
                    'data' => $entities
                ];
            } else {
                $result = [
                    'status' => 'error',
                    'message' => 'Tipo de entidad inválido.'
                ];
                http_response_code(400); 
            }
        } else {
            $result = [
                'status' => 'error',
                'message' => 'Parámetro "tipo" o "action=get_types" es requerido para esta operación GET.'
            ];
            http_response_code(400); 
        }
    } else {
        $result = [
            'status' => 'error',
            'message' => 'Método de solicitud no permitido.'
        ];
        http_response_code(405); 
    }
} catch (Exception $e) {
    $result = [
        "status" => "error",
        "message" => 'Error en el servidor: ' . $e->getMessage()
    ];
    http_response_code(500); 
}

echo json_encode($result);









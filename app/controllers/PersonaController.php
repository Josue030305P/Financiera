<?php

require_once '../models/Persona.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    header('Content-Type: application/json; charset=utf-8');
    
    $input = json_decode(file_get_contents("php://input"), true);

    $params = [
        'idpais' => $input['idpais'] ?? null,
        'apellidos' => $input['apellidos'] ?? null,
        'nombres' => $input['nombres'] ?? null,
        'tipodocumento' => $input['tipodocumento'] ?? null,
        'numdocumento' => $input['numdocumento'] ?? null,
        'email' => $input['email'] ?? null,
        'telprincipal' => $input['telprincipal'] ?? null,
        'domicilio' => $input['domicilio'] ?? null,
    ];
    
    if (in_array(null, $params, true)) {
        echo json_encode(['success' => false, 'message' => 'Faltan parámetros']);
        exit;
    }

    try {
  
        $persona = new Persona();
        
        
        $result = $persona->addConyuge($params);
        
        if ($result['success']) {
            echo json_encode(['success' => true, 'message' => 'Cónyuge agregado exitosamente', 'idconyuge' => $result['idconyuge']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo agregar al cónyuge']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    
    echo json_encode(['success' => false, 'message' => 'Método no soportado']);
}

<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Ubigeo.php'; 

    $ubigeo = new Ubigeo();

    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            
            if (isset($_GET['departamento'])) {
                
                $departamentoId = $_GET['departamento'];
                echo json_encode($ubigeo->getProvinciasByDepartamento($departamentoId));
            } 
            
            elseif (isset($_GET['provincia'])) {
                $provinciaId = $_GET['provincia'];
                echo json_encode($ubigeo->getDistritosByProvincia($provinciaId));
            } 
           
            else {
                echo json_encode($ubigeo->getDepartamentos());
            }
            break;

        default:
            echo json_encode(['message' => 'Método no soportado']);
            break;
    }
}
?>






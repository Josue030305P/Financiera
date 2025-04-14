<?php

if ($_SERVER["REQUEST_METHOD"]) {

    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Lead.php'; 

    $lead = new Lead();

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];

                try {
                    $resultado = $lead->getLeadToInversionistaById($id);
                    echo json_encode($resultado);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }

            } else {
                echo json_encode(['error' => 'Parámetro "id" no proporcionado']);
            }
            break;
    }
}




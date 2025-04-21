<?php

if ($_SERVER["REQUEST_METHOD"]) {

    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Lead.php'; 

    $lead = new Lead();

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            $id = null;
            if (isset($_POST['leadId'])) {
                $id = (int) $_POST['leadId'];
            } elseif (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
            }
        
            if ($id !== null) {
                try {
                    $resultado = $lead->getLeadToInversionistaById($id);
                    echo json_encode($resultado);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            }
            else if (isset($_GET['dni'])) {
                $dni = $_GET['dni'];
                try {
                    $resultado = $lead->searchConyuge($dni);
                    echo json_encode($resultado);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            }
            else {
                echo json_encode(['error' => 'Parámetro "id" no proporcionado']);
            }
            break;
        case 'POST':

    }
}




<?php

require_once '../models/Inversionista.php';
require_once '../models/Lead.php';

$inversionista = new Inversionista();
$lead = new Lead();

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
           if (isset($_GET['lead_id'])) {
                try {
                    $leadData = $lead->getById($_GET['lead_id']);
                    echo json_encode([
                        "status" => "success",
                        "data" => $leadData
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => "error",
                        "message" => $e->getMessage()
                    ]);
                }
            } else {
                echo json_encode($inversionista->getAll());
            }
            break;

        case 'POST':

    }


}

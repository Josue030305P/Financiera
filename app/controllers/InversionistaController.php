<?php

require_once '../models/Inversionista.php';
require_once '../models/Lead.php';

$inversionista = new Inversionista();
$lead = new Lead();

if (isset($_SERVER['REQUEST_METHOD'])) {
  header('Content-Type: application/json; charset=utf-8');

  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            try {
                $result = $inversionista->getById();
                echo json_encode([
                    "status" => "success",
                    "data" => $result
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        } else if (isset($_GET['lead_id'])) {
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
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Si viene de un lead, actualizar su estado
            if (isset($data['lead_id'])) {
                $lead->updateEstadoInversionista($data['lead_id']);
            }
            
            $result = $inversionista->add($data);
            echo json_encode([
                "status" => "success",
                "data" => $result
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
        break;
  }
}


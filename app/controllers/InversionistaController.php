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
            $input = file_get_contents('php://input');
            $inversionistaData = json_decode($input, true);

            if ($inversionistaData) {
                $idpersona = $inversionistaData['idpersona'] ?? null;
                $idempresa = $inversionistaData['idempresa'] ?? null;
                $idasesor = $inversionistaData['idasesor'] ?? null;
              

                if (($idpersona !== null || $idempresa !== null) && $idasesor !== null) {
                    $params = [
                        'idpersona' => $idpersona,
                        'idempresa' => $idempresa,
                        'idasesor' => $idasesor,
                    ];

                    try {
                        $result = $inversionista->add($params);
                        echo json_encode([
                            "status" => true,
                            "message" => $result['message'],
                            "idinversionista" => $result['idinversionista']
                        ]);
                    } catch (Exception $e) {
                        echo json_encode([
                            "status" => "error",
                            "message" => "Error al agregar el inversionista: " . $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Datos de inversionista incompletos. Se requiere idpersona o idempresa e idasesor."
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Datos JSON inválidos recibidos."
                ]);
            }
            break;

    }


}

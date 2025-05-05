<?php
session_start();

if ($_SERVER["REQUEST_METHOD"]) {

    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Lead.php';
    require_once '../models/Contrato.php';

    $lead = new Lead();
    $contrato = new Contrato();

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
            } else if (isset($_GET['dni'])) {
                $dni = $_GET['dni'];
                try {
                    $resultado = $lead->searchConyuge($dni);
                    echo json_encode($resultado);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Parámetro "id" no proporcionado']);
            }
            break;

            case 'POST':
                $input = file_get_contents('php://input');
                $dataJSON = json_decode($input, true);

                $registro = [
                    'idversion' => $dataJSON['idversion'],
                    'idasesor'=> $dataJSON['idasesor'],
                    'idinversionista'=> $dataJSON['idinversionista'],
                    'idconyuge'=> $dataJSON['idconyuge'] ?? null,
                    'fechainicio'=> $dataJSON['fechainicio'],
                    'fechafin'=> $dataJSON['fechafin'],
                    'impuestorenta'=> $dataJSON['impuestorenta'],
                    'toleranciadias'=> $dataJSON['toleranciadias'],
                    'duracionmeses' => $dataJSON['duracionmeses'],
                    'moneda'=> $dataJSON['moneda'],
                    'diapago'=> $dataJSON['diapago'],
                    'interes'=> $dataJSON['interes'],
                    'capital'=> $dataJSON['capital'],
                    'tiporetorno'=> $dataJSON['tiporetorno'],
                    'periodopago'=> $dataJSON['periodopago'],
                    'observacion'=> $dataJSON['observacion'],

                ];

                try {
                    $result = $contrato->add($registro);
                    echo json_encode($result);
                    
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => 'Error al generar contrato', $e->getMessage()]);
                }
                




    }


}




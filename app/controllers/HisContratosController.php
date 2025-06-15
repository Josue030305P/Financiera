<?php
session_start();

if ($_SERVER["REQUEST_METHOD"]) {

    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/HistorialContratos.php';

    $historialContrato = new HistorialContratos();

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':


            try {
                $resultado = $lead->getAll();
                echo json_encode($resultado);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }

            break;


    }


}


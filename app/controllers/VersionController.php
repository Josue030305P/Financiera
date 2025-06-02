<?php
session_start();
require_once '../models/VersionContrato.php';
$versionContrato = new VersionContrato();

if ($_SERVER["REQUEST_METHOD"]) {
    header('Content-Type: application/json; charset=utf-8');

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':

            try {
                $resultados = $versionContrato->getCondicionesByVersionActiva();
                echo json_encode($resultados);
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al obtener version: ' . $e->getMessage()
                ]);
            }
            break;



    }



}

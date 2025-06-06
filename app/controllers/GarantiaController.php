<?php

require_once '../models/Garantia.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
  header('Content-Type: application/json; charset=utf-8');

  $garantia = new Garantia();


  switch ($_SERVER['REQUEST_METHOD']) {


    case 'GET':
      
        try {
          $resultados = $garantia->getTiposGarantia();
          echo json_encode([
            "status" => true,
            "data" => $resultados
          ]);
        } catch (Exception $e) {
          echo json_encode([
            'success' => false,
            'message' => 'Error al obtener los detalels de pagos: ' . $e->getMessage()
          ]);
        }
      
      break;

    }


}
<?php

require_once '../models/DetalleGarantia.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
  header('Content-Type: application/json; charset=utf-8');

  $detalleGarantia = new DetalleGarantia();


  switch ($_SERVER['REQUEST_METHOD']) {


    case 'GET':
      
        try {
          $resultados = $detalleGarantia->getAllDetalleGarantias();
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

    case 'POST':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      $registro = [
        'idgarantia' => htmlspecialchars($dataJSON['idgarantia']),
        'idcontrato' => htmlspecialchars($dataJSON['idcontrato']),
        'porcentaje' => htmlspecialchars($dataJSON['porcentaje']),
        'observaciones' => htmlspecialchars($dataJSON['observaciones'] ?? null),
      ];

      try {
        $result = $detalleGarantia->add($registro);
        echo json_encode([
          "status" => true,
          "Se ha registrado la garantia del contrato",
        ]);
      } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el pago: ' . $e->getMessage()]);
      }
      break;
  }
}

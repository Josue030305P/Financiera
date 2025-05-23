<?php

require_once '../models/DetallePago.php';
require_once '../models/Numcuentas.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
  header('Content-Type: application/json; charset=utf-8');

  $detallePago = new DetallePago();
  $numCuenta = new Numcuentas();

  switch ($_SERVER['REQUEST_METHOD']) {



    case 'GET':
      if (isset($_GET['idcontrato'])) {
        $idcontrato = $_GET['idcontrato'];
        try {
          $resultados = $numCuenta->getNumcuentasByContrato($idcontrato);
          echo json_encode([
            "status" => "success",
            "data" => $resultados
          ]);
        } catch (Exception $e) {
          echo json_encode([
            'success' => false,
            'message' => 'Error al obtener los número de cuentas del contrato: ' . $e->getMessage()
          ]);
        }
      }
      break;

    case 'POST':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      $registro = [
        'idcronogramapago' => htmlspecialchars($dataJSON['idcronogramapago']),
        'idnumcuenta' => htmlspecialchars($dataJSON['idnumcuenta']),
        'numtransaccion' => htmlspecialchars($dataJSON['numtransaccion']),
        'fechahora' => htmlspecialchars($dataJSON['fechahora']),
        'monto' => htmlspecialchars($dataJSON['monto']),
        'observaciones' => htmlspecialchars($dataJSON['observaciones'])
      ];

      try {
        $result = $detallePago->add($registro);
        echo json_encode([
          "status" => "success",
          "Se ha registrado el pago",
          "data" => $result
        ]);
      } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el pago: ' . $e->getMessage()]);
      }
      break;


  }



}

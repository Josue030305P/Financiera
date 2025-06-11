<?php

require_once '../models/DetallePago.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
  header('Content-Type: application/json; charset=utf-8');

  $detallePago = new DetallePago();


  switch ($_SERVER['REQUEST_METHOD']) {


    case 'GET':
      
        try {
          $resultados = $detallePago->getAll();
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

           
            $idcronogramapago = $dataJSON['idcronogramapago'];
            $idnumcuenta = $dataJSON['idnumcuenta'] ;
            $numtransaccion = $dataJSON['numtransaccion'] ;
            $fechahora = $dataJSON['fechahora'] ;
            $monto = $dataJSON['monto'];
            $observaciones = $dataJSON['observaciones'] ?? null;
            $comprobante_base64 = $dataJSON['comprobante'] ?? null; 

         

            $registro = [
                'idcronogramapago' => htmlspecialchars($idcronogramapago),
                'idnumcuenta' => htmlspecialchars($idnumcuenta),
                'numtransaccion' => htmlspecialchars($numtransaccion),
                'fechahora' => htmlspecialchars($fechahora),
                'monto' => htmlspecialchars($monto),
                'observaciones' => htmlspecialchars($observaciones),
                'comprobante' => $comprobante_base64 
            ];

            try {
                $result = $detallePago->add($registro);
                echo json_encode([
                    "status" => $result['status'],
                    "message" => $result['message']
                ]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error al agregar el pago: ' . $e->getMessage()]);
            }
            break;

  }
}

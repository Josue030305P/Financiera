<?php

require_once '../models/Empresa.php';


if (isset($_SERVER['REQUEST_METHOD'])) {
  header('Content-Type: application/json; charset=utf-8');

  $empresa = new Empresa();

  switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input,true);

     $resgitro  = [
      'nombrecomercial' => htmlspecialchars($dataJSON['nombrecomercial']),
      'direccion'=> htmlspecialchars($dataJSON['direccion']),
      'ruc'=> htmlspecialchars($dataJSON['ruc']),
      'razonsocial'=> htmlspecialchars($dataJSON['razonsocial']),
     ];

      
      try {
        $result = $empresa->add($resgitro);
        echo json_encode([
          "status" => "success",
          "message" => "Empresa agregada correctamente",
          "data" => $result
      ]);




      } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la empresa: ' . $e->getMessage()]);

      }

      break;










  }





}
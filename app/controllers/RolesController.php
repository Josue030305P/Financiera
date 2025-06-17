<?php

require_once '../models/Roles.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
  header('Content-Type: application/json; charset=utf-8');

$rol = new Roles();


  switch ($_SERVER['REQUEST_METHOD']) {


    case 'GET':
      
        try {
          $resultados = $rol->getAll();
          echo json_encode(
          $resultados
          );
        } catch (Exception $e) {
          echo json_encode([
            'success' => false,
            'message' => 'Error al obtener los roles: ' . $e->getMessage()
          ]);
        }
      
      break;

    }


}
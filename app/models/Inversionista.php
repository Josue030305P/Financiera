<?php

require_once '../config/Database.php';

class Inversionista
{

  private $conexion;

  public function __construct()
  {
    $this->conexion = Database::getConexion();

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }





  }


  public function getAll(): array
  {

    $result = [];
    try {
      $sql = "SELECT * FROM list_inversionistas ";
      $smt = $this->conexion->prepare($sql);
      $smt->execute();
      $result = $smt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      throw new Exception($e->getMessage());
    }

    return $result;

  }


  public function add($params = []): array
  {

    try {

      if (!isset($_SESSION['idusuario'])) {
        return ['success' => false, 'message' => 'No se encontró el ID de usuairo en la sesión.'];
      }

      $idUsuarioCreador = $_SESSION['idusuario'];
      


      $sql = "";
    } catch (PDOException) {

    }

  }






}


//$inv = new Inversionista();
//var_dump( $inv->getAll() );




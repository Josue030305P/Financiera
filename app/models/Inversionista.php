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
      $this->conexion->beginTransaction();
       if (!isset($_SESSION['idusuario'])) {
        return ['success' => false, 'message' => 'No se encontró el ID de usuairo en la sesión.'];
      }
    
      $idusuariocreacion = $_SESSION['idusuario'];
      $sql = "CALL sp_add_inversionista(?,?,?,?)";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute(array(
        $params["idpersona"],
        $params["idempresa"],
        $params["idasesor"],
        $idusuariocreacion

      ));
      
      $idRow = $stmt->fetch(PDO::FETCH_ASSOC);
      $idinversionista = $idRow['idinversionista'] ?? 0 ;
      $stmt->closeCursor();
      
      $this->conexion->commit();
     
      return ["success" => true, "message" => "Se agrego el inversionista", "idinversionista" => $idinversionista];
    } catch (PDOException $e) {
      $this->conexion->rollBack();
      throw new Exception($e->getMessage());
    }

  }

}

// $inv = new Inversionista();
//   $dato = [
//   "idpersona"=> 7,
//    "idempresa"=> 2,
//     "idasesor"=> 2
//   ];

//   var_dump($inv->add($dato));




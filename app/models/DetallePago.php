<?php

require_once '../config/Database.php';


class DetallePago
{

  private $conexion;
  public function __construct()
  {
    $this->conexion = Database::getConexion();
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }


  public function add($params = []): array
  {

    try {

      $this->conexion->beginTransaction();

      if (!isset($_SESSION['idusuario'])) {
        return ['success' => false, 'message' => 'No se encontró el ID de usuairo en la sesión.'];
      }

      $idusuariocreacion = $_SESSION['idusuario'];
      $sql = "CALL sp_add_detallepago_cronograma(?,?,?,?,?,?,?)";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute(array(
        $params["idcronogramapago"],
        $idusuariocreacion,
        $params["idnumcuenta"],
        $params["numtransaccion"],
        $params["fechahora"],
        $params["monto"],
        $params["observaciones"]

      ));

      $this->conexion->commit();

      return [
        'status' => true,
        'message' => 'Se ha insertado el pago'
      ];
    } catch (PDOException $e) {
      $this->conexion->rollBack();
      throw new Exception($e->getMessage());
    }
  }
}

//$detallepago  = new DetallePago();



// $params = [
//    'idcronogramapago' => 1,
//     'idnumcuenta' => 4,
//     'numtransaccion' => '1858545541411',
//     'fechahora' => '2025-05-22',
//     'monto' => 310.65,
//     'observaciones' => 'Se ha cancelado la primer cuota'
// ];

// var_dump($detallepago->add($params));
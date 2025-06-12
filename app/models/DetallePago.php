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

  public function getByContratoId($idContrato)
    {
        $result = [];
        try {
        
            $sql = "SELECT * FROM v_detalle_pagos WHERE idcontrato = ? ORDER BY ncuota ASC, fechapago ASC";
            $stmt = $this->conexion->prepare($sql);
          
            $stmt->execute([$idContrato]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Error al obtener el historial de pagos por contrato: " . $e->getMessage());
        }
        return $result;
    }


  public function getAll()
  {
    $result = [];
    try {
      $sql = "SELECT * FROM v_detalle_pagos";
      $stmt = $this->conexion->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException($e->getMessage());
    }

    return $result;
  }

  // public function add($params = []): array
  // {

  //   try {

  //     $this->conexion->beginTransaction();

  //     if (!isset($_SESSION['idusuario'])) {
  //       return ['success' => false, 'message' => 'No se encontró el ID de usuairo en la sesión.'];
  //     }

  //     $idusuariocreacion = $_SESSION['idusuario'];
  //     $sql = "CALL sp_add_detallepago_cronograma(?,?,?,?,?,?,?,?)";
  //     $stmt = $this->conexion->prepare($sql);
  //     $stmt->execute(array(
  //       $params["idcronogramapago"],
  //       $idusuariocreacion,
  //       $params["idnumcuenta"],
  //       $params["numtransaccion"],
  //       $params["fechahora"],
  //       $params["monto"],
  //       $params["observaciones"],
  //       $params["comprobante"]

  //     ));

  //     $this->conexion->commit();

  //     return [
  //       'status' => true,
  //       'message' => 'Se ha insertado el pago'
  //     ];
  //   } catch (PDOException $e) {
  //     $this->conexion->rollBack();
  //     throw new Exception($e->getMessage());
  //   }



  // }


  public function add($params = []): array
    {
        try {
            $this->conexion->beginTransaction();

            if (!isset($_SESSION['idusuario'])) {
                return ['status' => false, 'message' => 'No se encontró el ID de usuario en la sesión.'];
            }

            $idusuariocreacion = $_SESSION['idusuario'];
           
            $comprobante_path = $params["comprobante"] ?? null; 

        
            $sql = "CALL sp_add_detallepago_cronograma(?,?,?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params["idcronogramapago"],
                $idusuariocreacion,
                $params["idnumcuenta"],
                $params["numtransaccion"],
                $params["fechahora"],
                $params["monto"],
                $params["observaciones"],
                $comprobante_path 
            ));

            $this->conexion->commit();

            return [
                'status' => true,
                'message' => 'Se ha insertado el pago'
            ];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new PDOException("Error en el servidor al procesar el pago: " . $e->getMessage());
        }
    }


  // public function add($params = []): array
  // {

  //   try {

  //     $this->conexion->beginTransaction();

  //     if (!isset($_SESSION['idusuario'])) {
  //       return ['success' => false, 'message' => 'No se encontró el ID de usuairo en la sesión.'];
  //     }

  //     $idusuariocreacion = $_SESSION['idusuario'];
  //     $sql = "CALL sp_add_detallepago_cronograma(?,?,?,?,?,?,?)";
  //     $stmt = $this->conexion->prepare($sql);
  //     $stmt->execute(array(
  //       $params["idcronogramapago"],
  //       $idusuariocreacion,
  //       $params["idnumcuenta"],
  //       $params["numtransaccion"],
  //       $params["fechahora"],
  //       $params["monto"],
  //       $params["observaciones"]

  //     ));

  //     $this->conexion->commit();

  //     return [
  //       'status' => true,
  //       'message' => 'Se ha insertado el pago'
  //     ];
  //   } catch (PDOException $e) {
  //     $this->conexion->rollBack();
  //     throw new Exception($e->getMessage());
  //   }
  // }
}

// $detallepago  = new DetallePago();
// // var_dump($detallepago->getByContratoId(16));


// $params = [
//    'idcronogramapago' => 1,
//      'idnumcuenta' => 4,
//      'numtransaccion' => '1858545541411',
//      'fechahora' => '2025-05-22',
//      'monto' => 310.65,
//      'observaciones' => 'Se ha cancelado la primer cuota',
//      'comprobante' => 'hjeghgaerg/gfefrgeg/'
//  ];

// var_dump($detallepago->add($params));
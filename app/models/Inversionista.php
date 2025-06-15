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
      $idinversionista = $idRow['idinversionista'] ?? 0;
      $stmt->closeCursor();


      $idlead = null;
      if (isset($params["idpersona"]) && $params["idpersona"] !== null) {
        $sqlGetLeadId = "SELECT idlead FROM leads WHERE idpersona = ?";
        $stmtGetLeadId = $this->conexion->prepare($sqlGetLeadId);
        $stmtGetLeadId->execute([$params["idpersona"]]);
        $leadResult = $stmtGetLeadId->fetch(PDO::FETCH_ASSOC);
        if ($leadResult) {
          $idlead = $leadResult['idlead'];
        }
      }



      //  Actualizar el estado del lead si se encontró un idlead válido
      if ($idlead !== null && $idlead > 0) {
        $sqlActualizarLead = "UPDATE leads SET estado = 'Inversionista' WHERE idlead = ? AND estado = 'En proceso'";
        $stmtActualizarLead = $this->conexion->prepare($sqlActualizarLead);
        $stmtActualizarLead->execute([$idlead]);
      }



      $this->conexion->commit();

      return ["success" => true, "message" => "Se agrego el inversionista", "idinversionista" => $idinversionista];
    } catch (PDOException $e) {
      $this->conexion->rollBack();
      throw new Exception($e->getMessage());
    }

  }

   public function delete($idinversionista): array
    {
        try {
            $this->conexion->beginTransaction();
            $sql = "CALL sp_delete_inversionista(?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$idinversionista]);
            $this->conexion->commit();
            return ["success" => true, "message" => "Inversionista eliminado exitosamente"];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new Exception($e->getMessage());
        }
    }

}
// $inv = new Inversionista();
//     $dato = [
//      "idpersona"=> 5,
//       "idempresa"=> 7,
//        "idasesor"=> 2
//      ];

// var_dump($inv->add($dato));




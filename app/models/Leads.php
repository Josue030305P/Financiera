<?php

require_once "Conexion.php";
class Leads extends Conexion {

  private $conexion;
  public function __construct() {

    $this->conexion= parent::getConexion();

  }


  /**
   * Función para poder listar los leads:
   */

   public function getAll():array {

    try {
      $consulta=$this->conexion->prepare("CALL sp_list_leads()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    }
    catch(Exception $e) {
      return ["error"=> $e->getMessage()];

    }

   }


   /**
    * Función para poder insertar un Contrato
    */







}

//  header('Content-Type: application/json; charset=utf-8');

//  $lead = new Leads();

// echo json_encode($lead->getAll());




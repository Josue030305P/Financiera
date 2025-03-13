<?php

require_once "Conexion.php";
class Contrato extends  Conexion{


  
  private $conexion;
  public function __construct() {

    $this->conexion= parent::getConexion();

  }



  public function add($params = []): bool {

    try {
      $consulta = $this->conexion->prepare("INSERT INTO contratos(idasesor,idinversionista,idconyuge,fechainicio,duracionmeses,moneda,diapago,interes,capital,tiporetorno,periodopago,observacion,impuestorenta,toleranciadias) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $saveStatus = $consulta->execute(array(
          $params['idasesor'],
          $params['idinversionista'],
          $params['idconyuge'],
          $params['fechainicio'],
          $params['duracionmeses'],
          $params['moneda'],
          $params['diapago'],
          $params['interes'],
          $params['capital'],
          $params['tiporetorno'],
          $params['periodopago'],
          $params['observacion'],
          $params['impuestorenta'],
          $params['toleranciadias'],

      ));

      return $saveStatus;

    }

    catch(Exception $e) {
      return false;
    }

  }


  

}

// $contrato = new Contrato();

// $datos = [ 
// "idasesor"   => 1,
// "idinversionista"=> 2,
// "idconyuge"      => 3,
// "fechainicio"    => "2025-03-12",
// "duracionmeses"  => 12,
// "moneda"         => "USD",
// "diapago"        => 15,
// "interes"        => 5.5,
// "capital"        => 10000,
// "tiporetorno"    => "mensual",
// "periodopago"    => "30 días",
// "observacion"    => "Contrato inicial",
// "impuestorenta"  => 10,
// "toleranciadias" => 5];

// $status = $contrato->add($datos);
// var_dump( $status );
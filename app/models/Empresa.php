<?php

require_once '../config/Database.php';

class Empresa {

    private $conexion;

   public function __construct() {
        $this->conexion = Database::getConexion();
    }


    public function add($params = []) :array{

        try {

            $sql = "CALL sp_add_empresa(?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params['nombrecomercial'],
                $params['direccion'],
                $params['ruc'],
                $params['razonsocial']
            )); 

            $idempresa = $this->conexion->lastInsertId();

            return [
                'success' => true,
                'idempresa' => $idempresa,
                'rows' => $stmt->rowCount()
            ];
        }

        catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
       
        
    }


}

//  $empresa = new Empresa();
// $datos = [
//      'nombrecomercial' => 'Taxi churro',
//      'direccion' => 'Al costado de una casa blanca',
//      'ruc' => '12343434543',
//      'razonsocial' => 'Taxi churro de Joel Goonzález'
//  ];
//  var_dump($empresa->add($datos));
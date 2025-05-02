<?php

require_once '../config/Database.php';

class Empresa {

    private $conexion;

   public function __construct() {
        $this->conexion = Database::getConexion();
    }


    public function add($params = []) :array{

        try {
            $this->conexion->beginTransaction();
            $sql = "CALL sp_add_empresa(?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params['nombrecomercial'],
                $params['direccion'],
                $params['ruc'],
                $params['razonsocial']
            )); 

            $idRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $idempresa = $idRow['idempresa'] ?? 0 ;
            $stmt->closeCursor();
            
            $this->conexion->commit();

            return [
                'success' => true,
                'idempresa' => $idempresa,
                'rows' => $stmt->rowCount()
            ];
        }

        catch(PDOException $e) {
            $this->conexion->rollback();
            throw new Exception($e->getMessage());
        }
       
        
    }


}

// $empresa = new Empresa();
//     $datos = [
//          'nombrecomercial' => 'TT',
//          'direccion' => 'Al frente de plaza tottus',       
//          'ruc' => '85898585874',
//          'razonsocial' => 'Girasole sy girasoles'
//      ];
// var_dump($empresa->add($datos));
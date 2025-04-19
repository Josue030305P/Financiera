<?php

require_once '../config/Database.php';

class Persona {

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }


    public function addConyuge($params = []) : array {
        try {
          
            $sql = "CALL  sp_add_conyuge(?,?,?,?,?,?,?,?)";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([
                $params['idpais'],
                $params['apellidos'],
                $params['nombres'],
                $params['tipodocumento'],
                $params['numdocumento'],
                $params['email'],
                $params['telprincipal'],
                $params['domicilio'],
            ]);

            return ['success' => true];
        

        }
        catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }


}
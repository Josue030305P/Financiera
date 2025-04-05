<?php

require_once '../config/Database.php';


class Contrato {

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }
    

    public function getAll():array {
        $result = [];
        try {

            $sql = "SELECT * FROM list_contratos";
            $smt = $this->conexion->prepare($sql);
            $smt->execute();

            $result = $smt->fetchAll(PDO::FETCH_ASSOC);

        }
        catch (PDOException $e) {

            throw new Exception($e->getMessage());
        }

        return $result;

    }


}


//$d = new Contrato();
//var_dump($d->getAll());
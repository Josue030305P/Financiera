<?php


require_once '../config/Database.php';

class VersionContrato {

    private $conexion;


    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }


    public function getCondicionesByVersionActiva() {
         $result = [];
        try {
            $sql = "SELECT * FROM vista_condiciones_activas";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
        return $result;
    }
}


// $version = new VersionContrato();
// var_dump($version->getCondicionesByVersionActiva());
<?php


require_once '../config/Database.php';

class VersionContrato {

    private $conexion;


    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }


    public function getCondicionesByVersionActiva() {
        try {
            $sql = "SELECT * FROM vista_condiciones_activas";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
     
    }
}


// $version = new VersionContrato();
// var_dump($version->getCondicionesByVersionActiva());
<?php

require_once '../config/Database.php';


class Garantia {
    private $conexion;

    public function __construct() {
        $this->conexion = Database::getConexion();
    }



     public function getTiposGarantia() {
        $result = [];
        try {
            $sql = "SELECT * FROM garantias ORDER BY tipogarantia ASC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [
                'status' => false,
                'data' => [],
                'message' => 'Error al obtener tipos de garantía: ' . $e->getMessage()
            ];
        }

        return $result;
    }




}
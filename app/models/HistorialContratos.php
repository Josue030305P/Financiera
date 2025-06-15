<?php

require_once '../config/Database.php';


class HistorialContratos {
    private $conexion;


    
    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

    public function getAll () {

        $result = [];
        try {
            $sql = "SELECT * FROM v_historial_contratos_completados";
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

$historial = new HistorialContratos();

var_dump($historial->getAll());
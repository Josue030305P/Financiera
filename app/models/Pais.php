<?php

require_once '../config/Database.php';

class Pais
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

    public function getAll(): array
    {
        $result = [];
        try {

            $sql = "SELECT * FROM pais";
            $smt = $this->conexion->prepare($sql);
            $smt->execute();

            $result = $smt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

}


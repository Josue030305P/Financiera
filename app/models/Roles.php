<?php
require_once '../config/Database.php';

class Roles
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }


    public function getAll()
    {
        $result = [];
        try {

            $sql = "SELECT * FROM roles";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
        return $result;
    }
}


// $rol = new Roles();
// var_dump($rol->getAll());

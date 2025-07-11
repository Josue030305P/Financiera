<?php

require_once '../config/Database.php';

class Asesor
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
            $sql = "SELECT * FROM list_asesores";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    public function getAsesorByLead($id):array {
        $result = [];
        try {
            $sql = "SELECT *  FROM  v_asesor_lead  WHERE idlead = ? ";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
         throw new Exception($e->getMessage());
        }
        return $result;
    }
}
// $asesor = new Asesor();
//  var_dump($asesor->getAesorByLead(2));
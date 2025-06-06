<?php

require_once '../config/Database.php';


class DetalleGarantia {
    private $conexion;

    public function __construct() {
        $this->conexion = Database::getConexion();
    }


    public function add($params = []) {
        try {

            $sql = "CALL sp_add_garantia_contrato(?,?,?,?)"; 
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params["idgarantia"],
                $params["idcontrato"],
                $params["porcentaje"],
                $params["observaciones"]
            ));

            return [
                'status' => true,
                'message' => 'Se ha registrado la garantia'
            ];
        }
        catch(PDOException $e) {
            throw new PDOException($e->getMessage());
        }
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





    public function getAllDetalleGarantias() {
        try {
            $sql = "SELECT * FROM v_garantias_asociadas";
           
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

}




// $garantia = new DetalleGarantia();

// var_dump($garantia->getAllDetalleGarantias());
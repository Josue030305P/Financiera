<?php
require_once '../config/Database.php';

class Estadistica {
    private $conexion;

    public function __construct() {
        $this->conexion = Database::getConexion();
    }

    public function obtenerLeadsPorCanal(): array {
        try {
            $sql = "SELECT c.canal, COUNT(*) as total FROM leads l
                    JOIN canales c ON c.idcanal = l.idcanal
                    GROUP BY l.idcanal";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }



    public function obtenerLeadsConvertidosPorCanal(): array {
    try {
        $sql = "SELECT c.canal, COUNT(*) as total
                FROM leads l
                JOIN canales c ON c.idcanal = l.idcanal
                WHERE l.estado = 'Inversionista'
                GROUP BY l.idcanal";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage());
    }
}


public function obtenerInversionistasPorAsesor(): array {
        try {
            $sql = "SELECT u.usuario, COUNT(*) as total
                    FROM inversionistas i
                    JOIN usuarios u ON u.idusuario = i.idasesor
                    GROUP BY i.idasesor";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

}
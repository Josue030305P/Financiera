<?php

require_once '../config/Database.php'; 

class Entidad
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

 
    public function getByTipo(string $tipo): array
    {
        try {
            $sql = "SELECT identidad, entidad FROM entidades WHERE tipo = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$tipo]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
            throw new Exception("Error al obtener entidades por tipo: " . $e->getMessage());
        }
    }

    public function getTiposUnicos(): array
    {
        try {
            $sql = "SELECT DISTINCT tipo FROM entidades ORDER BY tipo ASC"; 
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN); 
        } catch (PDOException $e) {
            throw new Exception("Error al obtener tipos únicos de entidades: " . $e->getMessage());
        }
    }

    public function getAll(): array
    {
        try {
            $sql = "SELECT identidad, tipo, entidad FROM entidades";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener todas las entidades: " . $e->getMessage());
        }
    }
}

// $tipo = new Entidad();
// echo json_encode($tipo->getTiposUnicos());

// echo json_encode($tipo->getByTipo('Banco'));
// echo json_encode($tipo->getAll());





















/*

require_once '../config/Database.php'; 

class Entidad
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

   
    public function getByTipo(string $tipo): array
    {
        try {
            $sql = "SELECT identidad, entidad FROM entidades WHERE tipo = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$tipo]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
     
            throw new Exception("Error al obtener entidades por tipo: " . $e->getMessage());
        }
    }

    
    public function getAll(): array
    {
        try {
            $sql = "SELECT identidad, tipo, entidad FROM entidades";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener todas las entidades: " . $e->getMessage());
        }
    }
}

*/

// $tipo = new Entidad();

// var_dump($tipo->getByTipo('Banco'));
// var_dump($tipo->getAll());

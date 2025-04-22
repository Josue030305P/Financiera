<?php

require_once '../config/Database.php';
class Ubigeo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

    public function getDepartamentosByPais($paisId): array
    {
        try {
            $sql = "SELECT * FROM departamentos WHERE idpais = ?";  // Filtrar por país
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$paisId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    
    public function getProvinciasByDepartamento($departamentoId): array
    {
        try {
            $sql = "SELECT * FROM provincias WHERE iddepartamento = ? ORDER BY provincia";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$departamentoId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function getDistritosByProvincia($provinciaId): array
    {
        try {
            $sql = "SELECT * FROM distritos WHERE idprovincia = ? ORDER BY distrito";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$provinciaId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}




// $ubigeo = new Ubigeo();
// var_dump($ubigeo->getDepartamentosByPais(1));



















// require_once '../config/Database.php';

// class Ubigeo
// {
//     private $conexion;

//     public function __construct()
//     {
//         $this->conexion = Database::getConexion();
//     }


//     public function getDepartamentos(): array
//     {
//         try {
//             $sql = "SELECT * FROM departamentos";
//             $stmt = $this->conexion->prepare($sql);
//             $stmt->execute();
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             throw new Exception($e->getMessage());
//         }
//     }

//     public function getProvinciasByDepartamento($departamentoId): array
//     {
//         try {
//             $sql = "SELECT * FROM provincias WHERE iddepartamento = ? ORDER BY provincia";
//             $stmt = $this->conexion->prepare($sql);
//             $stmt->execute([$departamentoId]);
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             throw new Exception($e->getMessage());
//         }
//     }

//     public function getDistritosByProvincia($provinciaId): array
//     {
//         try {
//             $sql = "SELECT * FROM distritos WHERE idprovincia = ? ORDER BY distrito";
//             $stmt = $this->conexion->prepare($sql);
//             $stmt->execute([$provinciaId]);
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             throw new Exception($e->getMessage());
//         }
//     }
// }

// $d = new Ubigeo();

// var_dump($d->getDepartamentos());

?>
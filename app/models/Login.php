<?php

require_once '../config/Database.php';

class Login {
    private $conexion;

    public function __construct() {
        $this->conexion = Database::getConexion();
    }

    public function login($params = []): array {
        try {
            
            $sql = "SELECT * FROM usuarios WHERE usuario = ? AND passworduser = ?";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([$params["usuario"], $params["passworduser"]]);

            if ($smt->rowCount() == 1) {
                
                $row = $smt->fetch(PDO::FETCH_ASSOC);
           
                $_SESSION['idusuario'] = $row['idusuario'];

                
                $this->registrarAcceso($row['idusuario']);
                
                return [
                    'success' => true,
                    'nombre' => $row['usuario'],
                    'idusuario' => $row['idusuario']
                ];
            } else {
                return ['success' => false];
            }
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

   
    public function registrarAcceso($idusuario) {
        try {
            $sql = "INSERT INTO accesos (idusuario_acceso, fechahora, status_) VALUES (?, NOW(), 'Activo')";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([$idusuario]);
        } catch(PDOException $e) {
            throw new Exception("Error al registrar el acceso: " . $e->getMessage());
        }
    }

    
    public function cerrarSesion($idusuario) {
        try {

            $sql = "UPDATE accesos SET status_ = 'Inactivo' WHERE idusuario_acceso = ? ORDER BY fechahora DESC LIMIT 1";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([$idusuario]);

        }
        catch(PDOException $e) {
            throw new Exception("Error al cerra sesión: " .  $e->getMessage());
        }
    }






    }

















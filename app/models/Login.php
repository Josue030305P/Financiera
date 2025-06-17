<?php

require_once '../config/Database.php';

class Login {
    private $conexion;

    public function __construct() {
        $this->conexion = Database::getConexion();
    }

    public function login($params = []): array {
        try {
            // 1. Buscar al usuario por su nombre de usuario para obtener su contraseña hasheada
            $sql = "SELECT idusuario, usuario, passworduser FROM usuarios WHERE usuario = ?";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([$params["usuario"]]);
            $user = $smt->fetch(PDO::FETCH_ASSOC);

            // 2. Verificar si se encontró el usuario y si la contraseña ingresada coincide con el hash almacenado
            if ($user && password_verify($params["passworduser"], $user["passworduser"])) {
                // Las credenciales son correctas
                $_SESSION['idusuario'] = $user['idusuario'];
                $this->registrarAcceso($user['idusuario']);
                
                return [
                    'success' => true,
                    'nombre' => $user['usuario'],
                    'idusuario' => $user['idusuario']
                ];
            } else {
                // Usuario no encontrado o contraseña incorrecta
                return ['success' => false, 'message' => 'Credenciales incorrectas.'];
            }
        } catch(PDOException $e) {
            // Captura errores de la base de datos
            throw new Exception("Error de base de datos: " . $e->getMessage());
        } catch(Exception $e) {
            // Captura otros errores generales
            throw new Exception("Error inesperado: " . $e->getMessage());
        }
    }


    // public function registrarse($params = []) : array {

    //     try {

    //     }

    //     catch(PDOException $e) {
    //         throw new Exception($e->getMessage());
    //     }
    // }

   
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

            $sql = "UPDATE accesos 
                SET status_ = 'Inactivo', fechafin = NOW() 
                WHERE idusuario_acceso = ? 
                ORDER BY fechahora DESC 
                LIMIT 1";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([$idusuario]);

        }
        catch(PDOException $e) {
            throw new Exception("Error al cerra sesión: " .  $e->getMessage());
        }
    }






    }

















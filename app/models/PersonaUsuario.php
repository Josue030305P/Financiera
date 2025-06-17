<?php
require_once '../config/Database.php';
class PersonaUsuario {

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }


    public function add($params): array
    {

        try {
            $this->conexion->beginTransaction();
            $sql = "CALL sp_add_persona_usuario(?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params['idpais'],
                $params['apellidos'],
                $params['nombres'],
                $params['fechanacimiento'],
                $params['tipodocumento'],
                $params['numdocumento'],
                $params['email'],
                $params['telprincipal'],
                $params['domicilio']

            ));
            $this->conexion->commit();

            return [
                'status' => true,
                'message' => 'Se ha agregado la persona que pasara a ser Colaborador'
            ];

        } catch (PDOException $e) {
                $this->conexion->rollBack();
            throw new PDOException($e->getMessage());
        }

        
    }
}

// $personaUsuario = new PersonaUsuario();
// $datos = [
//     'idpais' => 1,
//     'apellidos' => 'Sanchez',
//     'nombres' => 'Marlene',
//     'fechanacimiento' => '1998-12-12',
//     'tipodocumento' => 'DNI',
//     'numdocumento' => '44585555',
//     'email' => 'marlenesanchez34@gmail.com',
//     'telprincipal' => '966633333',
//     'domicilio' => 'AV SAN AGUSTÍN #444'
// ];

// var_dump($personaUsuario->add($datos));
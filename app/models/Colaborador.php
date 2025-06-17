<?php

require_once '../config/Database.php';

class Colaborador
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }


      public function getPersonaColaborador()
    {
        $result = [];
        try {

            $sql = "CALL sp_getpersona_to_colaborador()";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
        return $result;
    }


    public function add($params): array
    {

        try {
            $this->conexion->beginTransaction();
            $idusuariocreacion = $_SESSION['idusuario'];
            $sql = "CALL sp_add_colaborador_usuario(?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params['idpersona'],
                $params['idrol'],
                $idusuariocreacion,
                $params['fechainicio'],
                $params['fechafin'],
                $params['observaciones']
            ));
            $this->conexion->commit();

            return [
                'status' => true,
                'message' => 'Se ha agregado el colaborador'
            ];

        } catch (PDOException $e) {
                $this->conexion->rollBack();
            throw new PDOException($e->getMessage());
        }


    }

    
  
}

// $colaborador = new Colaborador();
// $datos = [
//      'idpersona' => 34,
//      'idrol' => 1,
//  
//      'fechainicio' => '2025-06-16',
//      'fechafin' => '2026-06-16',
//      'observaciones' => 'Contrato de un año',
// ];

// var_dump($colaborador->add($datos));

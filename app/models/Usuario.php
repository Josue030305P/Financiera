<?php

require_once '../config/Database.php';

class Usuario
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }



    public function getColaboradorToUsuario()
    {
        $result = [];
        try {

            $sql = "CALL sp_getcolaborador_to_add_usuario()";
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

            $sql = "CALL sp_add_usuario(?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params['idcolaborador'],
                $params['usuario'],
                $params['passworduser'],
                $params['fotoperfil']
            ));
            $this->conexion->commit();

            return [
                'status' => true,
                'message' => 'Se ha agregado el usuario'
            ];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new PDOException($e->getMessage());
        }
    }
}

// $usuario = new Usuario();
// $datos = [
//     'idcolaborador' => 8,
//     'usuario' => 'marlene2025',
//     'passworduser' => '12345',
//     'fotoperfil' => 'uploads/perfilusuario/marlene.jpg'
// ];

// var_dump($usuario->add($datos));
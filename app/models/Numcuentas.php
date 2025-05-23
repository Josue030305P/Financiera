<?php

require_once '../config/Database.php';


class Numcuentas
{

    private $conexion;
    public function __construct()
    {
        $this->conexion = Database::getConexion();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }



    public function getNumcuentasByContrato($id)
    {

        try {
            $sql = "CALL sp_numcuenta_by_idcontrato(?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener número de cuentas del contrato " . $e->getMessage());
        }

    }


    public function add($params = []): array
    {
        try {

            $this->conexion->beginTransaction();
            $idusuariocreacion = $_SESSION['idusuario'];
            $sql = "CALL sp_numcuenta_contrato(?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);

            $stmt->execute(array(
                $params['idcontrato'],
                $params['identidad'],
                $idusuariocreacion,
                $params['numcuenta'],
                $params['cci'],
                $params['observaciones']

            ));
            $this->conexion->commit();



            return [
                'success' => true,
                'rows' => $stmt->rowCount()
            ];



        } catch (PDOException $e) {

            $this->conexion->rollBack();
            throw new Exception($e->getMessage());
        }
    }

}

// $numCuenta = new Numcuentas();
// $params = [
//     'idcontrato' => 7,
//     'identidad' => 1,
//     'numcuenta' => '1234567890',
//     'cci' => '0987654321',
//     'observaciones' => 'Cuenta para este inversionista'
// ];

// var_dump($numCuenta->add($params));
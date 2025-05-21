<?php

require_once '../config/Database.php';


class Contactibilidad
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }


    
    public function getAll():array {
        $result = [];

        try {
            $sql = "SELECT * FROM list_contactibilidad ;";
            $smt = $this->conexion->prepare($sql);
            $smt->execute();
            $result = $smt->fetchAll(PDO::FETCH_ASSOC);


        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
        return $result;


    }

    public function add($params = []): array
    {
        try {

            $this->conexion->beginTransaction();
            $idusuariocreacion = $_SESSION['idusuario'];
            $sql = "CALL sp_lead_add_contactbilidad(?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);

            $stmt->execute(array(
                $params['idlead'],
                $idusuariocreacion,
                $params['fecha'],
                $params['hora'],
                $params['comentarios'],
                $params['estado']

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



// $ts = new Contactibilidad();

//  $params = [
//         'idlead'      => 1,
//         'fecha'       => date('Y-m-d'), // Fecha actual
//         'hora'        => date('H:i:s'), // Hora actual
//         'comentarios' => 'Contacto de prueba desde el script. Lead interesado en más información.',
//         'estado'      => 'Realizado' 
//     ];
// echo json_encode($ts->add($params));
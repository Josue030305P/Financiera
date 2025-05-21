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

            
            $sqlContactibilidad = "CALL sp_lead_add_contactbilidad(?,?,?,?,?,?)";
            $stmtContactibilidad = $this->conexion->prepare($sqlContactibilidad);
            $stmtContactibilidad->execute(array(
                $params['idlead'],
                $idusuariocreacion,
                $params['fecha'],
                $params['hora'],
                $params['comentarios'],
                $params['estado']
            ));

           
            $sqlActualizarLead = "UPDATE leads SET estado = 'En proceso' WHERE idlead = ? AND estado = 'Nuevo contacto'";
            $stmtActualizarLead = $this->conexion->prepare($sqlActualizarLead);
            $stmtActualizarLead->execute([$params['idlead']]);


            $this->conexion->commit();

            return [
                'success' => true,
                'rows' => $stmtContactibilidad->rowCount() + $stmtActualizarLead->rowCount() 
            ];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new Exception($e->getMessage());
        }
    }


     
    public function update($idcontactibilidad, $data = []): array
    {
        try {
            $this->conexion->beginTransaction();


            $sql = "CALL sp_update_contactibilidad(?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                $idcontactibilidad,
                $data['fecha'],
                $data['hora'],
                $data['comentarios'],
                $data['estado']
            ]);

            $this->conexion->commit();

            return [
                'success' => true,
                'rows' => $stmt->rowCount() 
            ];

        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new Exception("Error al actualizar la contactibilidad: " . $e->getMessage());
        } catch (Exception $e) {
            $this->conexion->rollBack(); 
            throw new Exception($e->getMessage());
        }
    }

    
    public function getById($idcontactibilidad): ?array
    {
        try {
            $sql = "SELECT fecha, hora, comentarios, estado FROM contactibilidad WHERE idcontactibilidad = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$idcontactibilidad]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null; 
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la contactibilidad por ID: " . $e->getMessage());
        }
    }




}

// $ts = new Contactibilidad();
// var_dump($ts->getById(1));












// $ts = new Contactibilidad();

//  $params = [
//         'idlead'      => 1,
//         'fecha'       => date('Y-m-d'), // Fecha actual
//         'hora'        => date('H:i:s'), // Hora actual
//         'comentarios' => 'Contacto de prueba desde el script. Lead interesado en más información.',
//         'estado'      => 'Realizado' 
//     ];
// echo json_encode($ts->add($params));
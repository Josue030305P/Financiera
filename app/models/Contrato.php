<?php

require_once '../config/Database.php';


class Contrato
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

    }


    public function getAll(): array
    {
        $result = [];
        try {

            $sql = "SELECT * FROM vista_contratos_resumida";
            $smt = $this->conexion->prepare($sql);
            $smt->execute();

            $result = $smt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            throw new Exception($e->getMessage());
        }

        return $result;

    }

    public function getDatosPDF($idcontrato) {
        try {
            $sql = "SELECT * FROM vista_contrato_pdf  WHERE idcontrato = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$idcontrato]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            }

            return [];


        }catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function add($params = []): array
    {

        try {

            $this->conexion->beginTransaction();
            
          
            $idusuariocreacion = $_SESSION['idusuario'];
            $sql = "CALL sp_add_contrato(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params["idversion"],
                $params["idasesor"],
                $params["idinversionista"],
                $params["idconyuge"],
                $idusuariocreacion,
                $params["fechainicio"],
                $params["fechafin"],
                $params["impuestorenta"],
                $params["toleranciadias"],
                $params["duracionmeses"],
                $params["moneda"],
                $params["diapago"],
                $params["interes"],
                $params["capital"],
                $params["tiporetorno"],
                $params["periodopago"],
                $params["observacion"],

            ));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $this->conexion->commit();


            if ($result && isset($result['idcontrato'])) {
                return  ["success" => true, "message" => "Se creo un nuevo contrato", 'idcontrato' => $result['idcontrato']];
            } else {
                return  ["success" => false, "message" => "Error al obtener el idcontrato"];
            }

        
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new Exception($e->getMessage());
        }
    }

}





// $contrato = new Contrato();
// var_dump($contrato->getAll());






// $contratoModel = new Contrato();


//    $params = [
//        "idversion" => 1,       
//      "idasesor" => 2,        
//        "idinversionista" => 1,
//       "idconyuge" => null,    
//       "fechainicio" => "2025-04-25",
//       "fechafin" => "2026-04-25",
//         "impuestorenta" => 5.00,
//         "toleranciadias" => 5,
//         "duracionmeses" => 12,
//         "moneda" => "PEN",
//         "diapago" => 30,
//         "interes" => 10.00,
//          "capital" => 10000.00,
//         "tiporetorno" => "Fijo",
//         "periodopago" => "Mensual",
//         "observacion" => "Prueba de contrato desde consola"
//     ];


//  $resultado = $contratoModel->add($params);


//  var_dump($resultado);
 
 


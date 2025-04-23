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

            $sql = "SELECT * FROM list_contratos";
            $smt = $this->conexion->prepare($sql);
            $smt->execute();

            $result = $smt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            throw new Exception($e->getMessage());
        }

        return $result;

    }

    public function add($params = []): array
    {

        try {

            $this->conexion->beginTransaction();
            if (!isset($_SESSION['idusuario'])) {
                return ['success' => false, 'message' => 'No se encontró el ID de usuairo en la sesión.'];
            }
            $idusuariocreacion = $_SESSION['idusuario'];
            $sql = "CALL sp_add_contrato(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute(array(
                $params["idversion"],
                $params["idasesor"],
                $params["idinversionista"],
                $params["idconyuge"],
                $idusuariocreacion,
                $params["fechainicio"],
                $params["fechafin"],
                $params["fecharetornocapital"],
                $params["impuestorenta"],
                $params["tolreanciadias"],
                $params["duracionmeses"],
                $params["moneda"],
                $params["diapago"],
                $params["interes"],
                $params["capital"],
                $params["tiporetorno"],
                $params["periodopago"],
                $params["observacion"],

            ));
            $this->conexion->commit();
            return ["success" => true, "message" => "Se creo un nuevo contrato"];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new Exception($e->getMessage());
        }
    }

}




$_SESSION['idusuario'] = 1; 


$contratoModel = new Contrato();


$params = [
    "idversion" => 1,       
    "idasesor" => 2,        
    "idinversionista" => 3,
    "idconyuge" => null,    
    "fechainicio" => "2025-04-25",
    "fechafin" => "2026-04-25",
    "fecharetornocapital" => "2026-04-30",
    "impuestorenta" => 5.00,
    "tolreanciadias" => 5,
    "duracionmeses" => 12,
    "moneda" => "PEN",
    "diapago" => 30,
    "interes" => 10.00,
    "capital" => 10000.00,
    "tiporetorno" => "Fijo",
    "periodopago" => "Mensual",
    "observacion" => "Prueba de contrato desde consola"
];


$resultado = $contratoModel->add($params);


var_dump($resultado);


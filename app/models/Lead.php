<?php

require_once '../config/Database.php';

class Lead
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

    public function getAll(): array
    {
        $result = [];
        try {

            $sql = "SELECT * FROM lista_leads ORDER BY idlead";
            $smt = $this->conexion->prepare($sql);
            $smt->execute();

            $result = $smt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function add(array $data): int
    {
        try {
            $this->conexion->beginTransaction();

            // Insertar en 'personas'
            $sqlP = "INSERT INTO personas (tipodocumento, numdocumento, idpais, iddistrito, apellidos, nombres, email, telprincipal)
                     VALUES ('DNI', NULL, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sqlP);
            $stmt->execute([
                $data['idpais'],
                $data['iddistrito'],
                $data['apellidos'],
                $data['nombres'],
                $data['email'],
                $data['telprincipal']
            ]);
            $idpersona = $this->conexion->lastInsertId();

            // Insertar en 'leads'
            $sqlL = "INSERT INTO leads (idasesor, idpersona, idcanal, comentarios, prioridad, ocupacion)
                     VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sqlL);
            $stmt->execute([
                $data['idasesor'],
                $idpersona,
                $data['idcanal'],
                $data['comentarios'],
                $data['prioridad'],
                $data['ocupacion']
            ]);

            $this->conexion->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}


$lead = new Lead();

$data = [
    // Datos para personas:
    "idpais"       => 1,
    "iddistrito"   => 1, 
    "apellidos"    => "Pilpe Yataco",
    "nombres"      => "Josué Isai",
    "email"        => "josueyaatco96@gmail.com",
    "telprincipal" => '919482381',

    // Datos para leads:
    "idasesor"     => 1,
    "idcanal"      => 1, 
    "comentarios"  => "Está algo interesado",
    "prioridad"    => "Medio", 
    "ocupacion"    => "Profesor"
];

// $lead->add($data);

var_dump($lead->getAll());
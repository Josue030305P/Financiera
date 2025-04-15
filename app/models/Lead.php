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

            $sql = "SELECT * FROM lista_leads ORDER BY idlead ";
            $smt = $this->conexion->prepare($sql);
            $smt->execute();

            $result = $smt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }


    public function getById($id): array
    {
        try {
            $sql = "SELECT l.*, p.idpais, p.apellidos, p.nombres, p.email, p.telprincipal 
                    FROM leads l 
                    JOIN personas p ON l.idpersona = p.idpersona 
                    WHERE l.idlead = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                throw new Exception("Lead no encontrado");
            }

            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getLeadToInversionistaById($id): array
    {

        try {

            $sql = "SELECT * FROM v_lead_to_inversionista WHERE idlead = ?";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([$id]);
            $result = $smt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function searchConyuge($ndocumento):array {
        try {

            $sql = "CALL sp_buscar_persona_dni(?)";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([$ndocumento]);
            $result = $smt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }
        catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function add(array $data): array
    {
        try {
            $this->conexion->beginTransaction();

            // Insertar en personas
            $sqlP = "INSERT INTO personas (idpais, apellidos, nombres, email, telprincipal)
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sqlP);
            $stmt->execute([
                $data['idpais'],
                $data['apellidos'],
                $data['nombres'],
                $data['email'],
                $data['telprincipal']
            ]);
            $idpersona = $this->conexion->lastInsertId();

            // Insertar en leads
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

            return [
                'success' => true,
                'idpersona' => $idpersona,
                'rows' => $stmt->rowCount()
            ];
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update($id, array $data): array
    {
        try {
            $this->conexion->beginTransaction();


            $sql = "SELECT idpersona FROM leads WHERE idlead = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);
            $lead = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$lead) {
                throw new Exception("Lead no encontrado");
            }

            $idpersona = $lead['idpersona'];


            $sqlP = "CALL sp_update_personas(?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sqlP);
            $stmt->execute([
                $idpersona,
                $data['tipodocumento'],
                $data['numdocumento'],
                $data['idpais'],
                $data['iddistrito'],
                $data['apellidos'],
                $data['nombres'],
                $data['fechanacimiento'],
                $data['email'],
                $data['domicilio'],
                $data['telprincipal'],
                $data['telsecundario'],
                $data['referencia'],

            ]);


            $sqlL = "UPDATE leads SET 
                     idasesor = ?, 
                     idcanal = ?, 
                     comentarios = ?, 
                     prioridad = ?, 
                     ocupacion = ? ,
                     estado = 'En proceso'
                     WHERE idlead = ?";
            $stmt = $this->conexion->prepare($sqlL);
            $stmt->execute([
                $data['idasesor'],
                $data['idcanal'],
                $data['comentarios'],
                $data['prioridad'],
                $data['ocupacion'],
                $id
            ]);

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

    public function delete($id): array
    {
        try {
            $this->conexion->beginTransaction();

            $sqlGetPersona = "SELECT idpersona FROM leads WHERE idlead = ?";
            $stmt = $this->conexion->prepare($sqlGetPersona);
            $stmt->execute([$id]);
            $lead = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$lead) {
                throw new Exception("Lead no encontrado");
            }

            $idpersona = $lead['idpersona'];

            $sqlL = "DELETE FROM leads WHERE idlead = ?";
            $stmt = $this->conexion->prepare($sqlL);
            $stmt->execute([$id]);

            $sqlP = "DELETE FROM personas WHERE idpersona = ?";
            $stmt = $this->conexion->prepare($sqlP);
            $stmt->execute([$idpersona]);

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

// $lead = new Lead();
// var_dump($lead->searchConyuge('58787777'));

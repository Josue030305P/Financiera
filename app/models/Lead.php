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


            $sqlP = "UPDATE personas SET 
                     idpais = ?, 
                     apellidos = ?, 
                     nombres = ?, 
                     email = ?, 
                     telprincipal = ? 
                     WHERE idpersona = ?";
            $stmt = $this->conexion->prepare($sqlP);
            $stmt->execute([
                $data['idpais'],
                $data['apellidos'],
                $data['nombres'],
                $data['email'],
                $data['telprincipal'],
                $idpersona
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

    

    // public function convertirAInversionista($idLead, $datosAdicionales)
    // {
    //     try {
    //         $this->conexion->beginTransaction();
    
            
    //         $sqlLead = "SELECT l.*, p.* FROM leads l 
    //                    JOIN personas p ON l.idpersona = p.idpersona 
    //                    WHERE l.idlead = ?";
    //         $stmt = $this->conexion->prepare($sqlLead);
    //         $stmt->execute([$idLead]);
    //         $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //         if (!$lead) {
    //             throw new Exception("Lead no encontrado");
    //         }
    
            
    //         $sqlUpdatePersona = "UPDATE personas SET
    //                            tipodocumento = ?,
    //                            numdocumento = ?,
    //                            fechanacimiento = ?,
    //                            iddepartamento = ?,
    //                            idprovincia = ?,
    //                            iddistrito = ?,
    //                            domicilio = ?,
    //                            telsecundario = ?,
    //                            referencia = ?
    //                            WHERE idpersona = ?";
    
    //         $stmt = $this->conexion->prepare($sqlUpdatePersona);
    //         $stmt->execute([
    //             $datosAdicionales['tipodocumento'],
    //             $datosAdicionales['numdocumento'],
    //             $datosAdicionales['fechanacimiento'],
    //             $datosAdicionales['iddepartamento'],
    //             $datosAdicionales['idprovincia'],
    //             $datosAdicionales['iddistrito'],
    //             $datosAdicionales['domicilio'],
    //             $datosAdicionales['telsecundario'],
    //             $datosAdicionales['referencia'],
    //             $lead['idpersona']
    //         ]);
    
            
    //         $idEmpresa = null;
    //         if (!empty($datosAdicionales['ruc'])) {
    //             $sqlEmpresa = "INSERT INTO empresas (
    //                            nombrecomercial, direccion, ruc, razonsocial
    //                            ) VALUES (?, ?, ?, ?)";
    
    //             $stmt = $this->conexion->prepare($sqlEmpresa);
    //             $stmt->execute([
    //                 $datosAdicionales['nombrecomercial'],
    //                 $datosAdicionales['direccion'],
    //                 $datosAdicionales['ruc'],
    //                 $datosAdicionales['razonsocial']
    //             ]);
    
    //             $idEmpresa = $this->conexion->lastInsertId();
    //         }
    
            
    //         $sqlInversionista = "INSERT INTO inversionistas (
    //                             idpersona, idempresa, idasesor, idusuariocreacion, fechaingreso
    //                             ) VALUES (?, ?, ?, ?, NOW())";
    
    //         $stmt = $this->conexion->prepare($sqlInversionista);
    //         $stmt->execute([
    //             $lead['idpersona'],
    //             $idEmpresa,
    //             $lead['idasesor'],
    //             $datosAdicionales['idusuariocreacion']
    //         ]);
    
    //         $idInversionista = $this->conexion->lastInsertId();
    
    //         // 5. Actualizar estado del lead
    //         $sqlUpdateLead = "UPDATE leads SET estado = 'Inversionista' WHERE idlead = ?";
    //         $stmt = $this->conexion->prepare($sqlUpdateLead);
    //         $stmt->execute([$idLead]);
    
    //         $this->conexion->commit();
    
    //         return [
    //             'success' => true,
    //             'idinversionista' => $idInversionista,
    //             'idpersona' => $lead['idpersona'],
    //             'idempresa' => $idEmpresa
    //         ];
    //     } catch (PDOException $e) {
    //         $this->conexion->rollBack();
    //         throw new Exception($e->getMessage());
    //     }
    // }


}

//$dd = new Lead();
//var_dump( $dd->getAll());

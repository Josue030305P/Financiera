<?php 

require_once '../config/Database.php';


class CronogramaPago {

    private $conexion;

    public function __construct(){
        $this->conexion = Database::getConexion();
    }


    public function add($idcontrato, $cuotas = []) : array {
        try {
            $this->conexion->beginTransaction();

            $sql = "CALL sp_generar_cronograma(?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            foreach ($cuotas as $cuota) {
                $numcuota = $cuota['Cuota'];
                $totalbruto = $cuota['Total_Bruto'];
                $totalneto = $cuota['Total_Neto'];
                $fechavencimiento = DateTime::createFromFormat('d/m/Y', $cuota['Fecha'])->format('Y-m-d');

                $stmt->execute([
                    $idcontrato,
                    $numcuota,
                    $totalbruto,
                    $totalneto,
                    $fechavencimiento
                ]);
                $stmt->closeCursor();
            }

            $this->conexion->commit();

            return [
                'success' => true,
                'message' => 'Cronograma generado correctamente',
                'rows' => count($cuotas)
            ];
        } catch (PDOException $e) {
            $this->conexion->rollback();
            throw new Exception($e->getMessage());
        }
    }


}
<?php

require_once '../config/Database.php';


class CronogramaPago
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }


    public function obtenerTodosFiltrado($filtros = []): array
    {
        try {
            $filtroEstado = isset($filtros['estado']) && $filtros['estado'] !== '' ? "'" . $filtros['estado'] . "'" : 'NULL';
            $filtroIdContrato = isset($filtros['idcontrato']) && $filtros['idcontrato'] !== '' ? intval($filtros['idcontrato']) : 'NULL';
            $filtroDni = isset($filtros['dni']) && $filtros['dni'] !== '' ? "'" . $filtros['dni'] . "'" : 'NULL';
            $sql = "CALL obtener_cronogramas_filtrado($filtroEstado,$filtroIdContrato, $filtroDni)";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener cronogramas filtrados: " . $e->getMessage());
        }
    }




    public function add($idcontrato, $cuotas = []): array
    {
        try {
            $this->conexion->beginTransaction();

            $sql = "CALL sp_generar_cronograma(?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);

            foreach ($cuotas as $cuota) {
                $numcuota = $cuota['numcuota'];
                $totalbruto = $cuota['totalbruto'];
                $totalneto = $cuota['totalneto'];
                $fechavencimiento = DateTime::createFromFormat('d/m/Y', $cuota['fechavencimiento'])->format('Y-m-d');

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



    public function obtenerPorContrato(int $idContrato): array
    {
        try {
            $sql = "CALL obtener_cronogramas_por_contrato(" . intval($idContrato) . ")";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener cronogramas por contrato: " . $e->getMessage());
        }
    }

}

// $cronograma = new CronogramaPago();

// $datos = [
//     'idcontrato' => 19,
//     'totalbruto' => 477,
//     'totalneto' => 453.15,
//     'fechavencimiento' => '2026-06-15'
// ];

// var_dump($cronograma->add($datos));
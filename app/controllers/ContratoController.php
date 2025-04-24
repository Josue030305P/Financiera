<?php
session_start();

if ($_SERVER["REQUEST_METHOD"]) {

    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Lead.php';
    require_once '../models/Contrato.php';
    require_once '../models/Inversionista.php';
    require_once '../models/Empresa.php';
    require_once '../config/Database.php';

    $lead = new Lead();
    $contrato = new Contrato();
    $inversionista = new Inversionista();
    $empresa = new Empresa();
    $conexion = Database::getConexion();

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            $id = null;
            if (isset($_POST['leadId'])) {
                $id = (int) $_POST['leadId'];
            } elseif (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
            }

            if ($id !== null) {
                try {
                    $resultado = $lead->getLeadToInversionistaById($id);
                    echo json_encode($resultado);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else if (isset($_GET['dni'])) {
                $dni = $_GET['dni'];
                try {
                    $resultado = $lead->searchConyuge($dni);
                    echo json_encode($resultado);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Parámetro "id" no proporcionado']);
            }
            break;

            case 'POST':

                











            // case 'POST':
            //     $dataJSON = json_decode(file_get_contents('php://input'), true);
    
            //     if ($dataJSON === null && json_last_error() !== JSON_ERROR_NONE) {
            //         echo json_encode(["status" => "error", "message" => "Error al decodificar los datos JSON del contrato."]);
            //         exit();
            //     }
    
            //     $idlead = $dataJSON['idlead'] ?? null;
            //     $datosEmpresa = $dataJSON['empresa'] ?? null;
            //     $datosContrato = $dataJSON['contrato'] ?? null;
            //     $idConyuge = $dataJSON['idconyuge'] ?? null;
    
            //     if (!$idlead || !$datosContrato) {
            //         echo json_encode(["status" => "error", "message" => "Faltan datos importantes (idlead o datos del contrato)."]);
            //         exit();
            //     }
    
            //     try {
            //         $conexion->beginTransaction();
            //         // 1. Obtener idpersona e idasesor desde la vista
            //         $sql_vista = "SELECT idpersona, idasesor FROM v_lead_to_inversionista WHERE idlead = ?";
            //         $stmt_vista = $conexion->prepare($sql_vista);
            //         $stmt_vista->execute([$idlead]);
            //         $resultado_vista = $stmt_vista->fetch(PDO::FETCH_ASSOC);
    
            //         if (!$resultado_vista) {
            //             throw new Exception("No se encontraron datos del lead con ID: " . $idlead);
            //         }
    
            //         $idpersonaInversionista = $resultado_vista['idpersona'];
            //         $idasesor = $resultado_vista['idasesor'];
            //         $idempresa = null;
    
            //         // 2. Crear empresa si se proporcionaron datos
            //         if ($datosEmpresa) {
            //             $resultado_empresa = $empresaModel->add($datosEmpresa);
            //             if (!$resultado_empresa['success']) {
            //                 throw new Exception("Error al crear la empresa: " . $resultado_empresa['message']);
            //             }
            //             $idempresa = $resultado_empresa['idempresa'];
            //         }
    
            //         // 3. Crear el inversionista
            //         $paramsInversionista = [
            //             "idpersona" => $idpersonaInversionista,
            //             "idempresa" => $idempresa,
            //             "idasesor" => $idasesor,
            //         ];
    
            //         $resultado_inversionista = $inversionistaModel->add($paramsInversionista);
            //         if (!$resultado_inversionista['success']) {
            //             throw new Exception("Error al crear el inversionista: " . $resultado_inversionista['message']);
            //         }
            //         $idinversionista = $resultado_inversionista['idinversionista'];
    
            //         // 4. Crear el contrato
            //           // 4. Crear el contrato
            //     $idUsuarioCreacion = $_SESSION['idusuario'] ?? null; // Obtener el ID de usuario de la sesión

            //         $datosContratoParaModelo = [
            //             "idversion" => 1, // Asegúrate de obtener esto del formulario si es dinámico
            //             "idasesor" => $idasesor,
            //             "idinversionista" => $idinversionista,
            //             "idconyuge" => $idConyuge,
            //             "idusuariocreacion" => $idUsuarioCreacion,
            //             "fechainicio" => $datosContrato['fechainicio'] ?? null,
            //             "fechafin" => $datosContrato['fechafin'] ?? null,
            //             "fecharetornocapital" => $datosContrato['fecharetornocapital'] ?? null,
            //             "impuestorenta" => $datosContrato['impuestorenta'] ?? null,
            //             "tolreanciadias" => $datosContrato['toleranciadias'] ?? null,
            //             "duracionmeses" => $datosContrato['duracionmeses'] ?? null,
            //             "moneda" => $datosContrato['moneda'] ?? null,
            //             "diapago" => $datosContrato['diapago'] ?? null,
            //             "interes" => $datosContrato['interes'] ?? null,
            //             "capital" => $datosContrato['capital'] ?? null,
            //             "tiporetorno" => $datosContrato['tiporetorno'] ?? null,
            //             "periodopago" => $datosContrato['periodopago'] ?? null,
            //             "observacion" => $datosContrato['observacion'] ?? null,
            //         ];
    
            //         $resultado_contrato = $contratoModel->add($datosContratoParaModelo);
            //         if (!$resultado_contrato['success']) {
            //             throw new Exception("Error al crear el contrato: " . $resultado_contrato['message']);
            //         }
    
            //         $conexion->commit();
    
            //         echo json_encode(["status" => "success", "message" => "Contrato creado exitosamente."]);
                    
    
            //     } catch (Exception $e) {
            //         $conexion->rollBack();
            //         echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            //     }
            //     break;


















    }


}




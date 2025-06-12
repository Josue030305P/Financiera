<?php
// DetallePagoController.php



error_reporting(E_ALL);

require_once '../models/DetallePago.php';
define('UPLOAD_DIR', '../../public/uploads/comprobantes/');
define('WEB_UPLOAD_DIR', 'uploads/comprobantes/');


if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    $detallePago = new DetallePago();

   
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0775, true); 
    }


    switch ($_SERVER['REQUEST_METHOD']) {


        case 'GET':

            if (isset($_GET['idcontrato'])) {
                $idContrato = $_GET['idcontrato'];

                try {
                    $resultados = $detallePago->getByContratoId($idContrato);
                    echo json_encode([
                        "status" => true,
                        "data" => $resultados
                    ]);
                } catch (Exception $e) {
                    
                    echo json_encode([
                        'status' => false,
                        'message' => 'Error al obtener el historial de pagos: ' . $e->getMessage()
                    ]);
                }
            }
            break;

        case 'POST':
            
            $idcronogramapago = $_POST['idcronogramapago'] ;
            $idnumcuenta = $_POST['idnumcuenta'] ;
            $numtransaccion = $_POST['numtransaccion'];
            $fechahora = $_POST['fechahora'] ;
            $monto = $_POST['monto'] ;
            $observaciones = $_POST['observaciones'] ?? null;

            $comprobante_path_for_db = null; 

            // Manejo de la subida del archivo comprobante
            if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['comprobante']['tmp_name'];
                $fileName = $_FILES['comprobante']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Generar un nombre único para el archivo
                $newFileName = uniqid('comp_') . '.' . $fileExtension;
                $dest_path = UPLOAD_DIR . $newFileName;

                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Guardar la ruta relativa para la base de datos
                    $comprobante_path_for_db = WEB_UPLOAD_DIR . $newFileName;
                } else {
                   
                    $error_message = 'Error al guardar el archivo de comprobante.';
                    error_log($error_message); // Log del error
                    echo json_encode([
                        'status' => false,
                        'message' => $error_message
                    ]);
               
                    ob_end_flush();
                    exit;
                }
            }

            $registro = [
                'idcronogramapago' => htmlspecialchars($idcronogramapago),
                'idnumcuenta' => htmlspecialchars($idnumcuenta),
                'numtransaccion' => htmlspecialchars($numtransaccion),
                'fechahora' => htmlspecialchars($fechahora),
                'monto' => htmlspecialchars($monto),
                'observaciones' => htmlspecialchars($observaciones),
                'comprobante' => $comprobante_path_for_db 
            ];

            try {
                $result = $detallePago->add($registro);
                echo json_encode([
                    "status" => $result['status'],
                    "message" => $result['message']
                ]);
            } catch (Exception $e) {
           
               
                echo json_encode(['status' => false, 'message' => 'Error al agregar el pago: ' . $e->getMessage()]);
            }
            break;
    }
}


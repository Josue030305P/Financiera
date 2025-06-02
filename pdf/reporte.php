<?php
session_start();
use Spipu\Html2Pdf\Html2Pdf;
require_once __DIR__ . '/../vendor/autoload.php';

// Verificar si se recibió el JSON
if (!isset($_POST['jsonData'])) {
    die('Error: No se recibieron datos en formato JSON');
}

// Decodificar el JSON
$formData = json_decode($_POST['jsonData'], true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error al decodificar JSON: ' . json_last_error_msg());
}

// Almacenar en sesión para todas las páginas
$_SESSION['datos_contrato'] = $formData;


try {
    ob_end_clean(); 
    ob_start();
    include './reporte-contrato.php';
    $html = ob_get_clean();
    $pdf = new Html2Pdf('P', 'A4', 'es');
    $pdf->writeHTML($html);
    $pdf->output('reporte.pdf'); // Descarga el archivo PDF
} catch (Exception $e) {
    echo 'Error al generar el PDF: ' . $e->getMessage();
}

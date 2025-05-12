<?php
session_start();
require_once '../../includes/header.php';
require_once "../../includes/config.php";

$idcontrato = $_GET['idcontrato'] ?? null;

if (!$idcontrato) {
    die('Error: No se proporcionó ID de contrato');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title>Generando PDF del Contrato</title>
    <script src="<?= BASE_URL ?>app/js/generarPDF.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h3>Generando PDF del Contrato...</h3>
                <p>Por favor espere un momento mientras se genera el documento.</p>
            </div>
        </div>
    </div>
</body>
</html> 
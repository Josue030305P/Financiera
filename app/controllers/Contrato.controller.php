<?php
require_once "../models/Contrato.php";

header('Content-Type: application/json; charset=utf-8');

$contrato = new Contrato();
$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo == "POST") {
    $registro = [
        "idasesor"       => $_POST["idasesor"] ?? null,
        "idinversionista"=> $_POST["idinversionista"] ?? null,
        "idconyuge"      => $_POST["idconyuge"] ?? null,
        "fechainicio"    => $_POST["fechainicio"] ?? null,
        "duracionmeses"  => $_POST["duracionmeses"] ?? null,
        "moneda"         => $_POST["moneda"] ?? null,
        "diapago"        => $_POST["diapago"] ?? null,
        "interes"        => $_POST["interes"] ?? null,
        "capital"        => $_POST["capital"] ?? null,
        "tiporetorno"    => $_POST["tiporetorno"] ?? null,
        "periodopago"    => $_POST["periodopago"] ?? null,
        "observacion"    => $_POST["observacion"] ?? null,
        "impuestorenta"  => $_POST["impuestorenta"] ?? null,
        "toleranciadias" => $_POST["toleranciadias"] ?? null
    ];

    $status = $contrato->add($registro);
    
    http_response_code(200);
    echo json_encode($status);
}
?>

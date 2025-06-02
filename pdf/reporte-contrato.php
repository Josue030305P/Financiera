<?php 


// Incluir estilos
include './style.html';

// Función para obtener datos fácilmente
function getDato($categoria, $campo, $default = '') {
    return $_SESSION['datos_contrato'][$categoria][$campo] ?? $default;
}

$condiciones = $_SESSION['datos_contrato']['condiciones'];

$condicionesMutuatario = [];
$condicionesMutuante = [];


// Las condiciones del Mutuatario
$condicionesMutuatario = array_filter($condiciones, function($condicion) {
    return $condicion['entidad'] === 'Mutuatario';
});

// Las condiciones del Mutuante
$condicionesMutuante = array_filter($condiciones, function($condicion) {
    return $condicion['entidad'] === 'Mutuante';
});


$condicionesMutuatario = array_values($condicionesMutuatario);
$condicionesMutuante = array_values($condicionesMutuante);



?>



<page>
    <page_footer>
        Página [[page_cu]] de [[page_nb]]
    </page_footer>
    <?php include 'contrato-pg1.php'; ?>
</page>

<page>
    <page_footer>
        Página [[page_cu]] de [[page_nb]]
    </page_footer>
    <?php include 'contrato-pg2.php'; ?>
</page>

<page>
    <page_footer>
        Página [[page_cu]] de [[page_nb]]
    </page_footer>
    <?php include 'contrato-pg3.php'; ?>
</page>

<page>
    <page_footer>
        Página [[page_cu]] de [[page_nb]]
    </page_footer>
    <?php include 'contrato-pg4.php'; ?>
</page>

<page>
    <page_footer>
        Página [[page_cu]] de [[page_nb]]
    </page_footer>
    <?php include 'contrato-pg5.php'; ?>
</page>
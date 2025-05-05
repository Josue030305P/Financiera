<?php session_start();  

if (!isset($_SESSION['nombre'])) {
    header('Location:../'); 
    exit();
}
?>
<?php require_once __DIR__ . "/../../includes/header.php"; ?>
<?php
$tipo = 'Contratos';

$configuracionTabla = [
  'columnas' => [
      'ID',
      'Inversionista',
      'Fecha inicio',
      'Fecha fin',
      'Moneda',
      'Capital',
      'Tipo de retorno',
      'Asesor',
      'Banco',
      'Garantía',
      '% de garantía',
  ],
  'mapeo' => [
      'ID' => 'idcontrato',
      'Inversionista' => 'nombreinversionista',
      'Fecha inicio' => 'fechainicio',
      'Fecha fin' => 'fechafin',
      'Moneda' => 'moneda',
      'Capital' => 'capital',
      'Tipo de retorno' => 'tiporetorno',
      'Asesor' => 'nombreasesor',
      'Banco' => 'banco',
      'Garantía' => 'garantia',
      '% de garantía' => 'porcentaje_garantia',
      
      
  ]
];



$columnas = $configuracionTabla['columnas'];

$links = [
  "Contratos" => BASE_URL . "app/views/contratos/contrato.add"
];

?>

<body>
    <div class="page-flex">
        <?php require_once "../../includes/sidebar.php"; ?>
        <div class="main-wrapper">
            <?php require_once "../../includes/navbar.php"; ?>
            <?php require_once "../../includes/table.php" ?>
          
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>app/js/dataTable.js"></script>
    <script>
    new DataTable({
        tableId: 'dataTable',
        apiUrl: 'controllers/ContratoController.php',
        tipo: 'contratos',
        columnas: <?= json_encode($configuracionTabla['columnas']) ?>,
        mapeo: <?= json_encode($configuracionTabla['mapeo']) ?>,
        baseUrl: '<?= BASE_URL ?>',
        idField: 'idcontrato',
       
    });

    
</script>



<script>
    document.addEventListener('DOMContentLoaded', e => {
      exportExcel("<?= $tipo  ?>");
    })
  </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>
    
    

   
</body>




</body>
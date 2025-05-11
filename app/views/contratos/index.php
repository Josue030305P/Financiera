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
      'Asesor',
      'Inversionista',
      'Inicio',
      'Fin',
      'Moenda',
      'Capital',
      'Interes',
      'Período',
      'Estado',
      'Acciones'
   
  ],

  'mapeo' => [
     'ID' => 'ID_Contrato',
      'Asesor' => 'Asesor',
      'Inversionista' => 'Inversionista',
      'Inicio' => 'Inicio',
      'Fin' => 'Fin',
      'Moenda' => 'Moneda',
      'Capital' => 'Capital',
      'Interes' => 'Interes_Porcentaje',
      'Período' => 'Periodo',
      'Estado' => 'Estado'
      
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

<script src="<?= BASE_URL ?>app/js/contratoFiltros.js"></script>



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
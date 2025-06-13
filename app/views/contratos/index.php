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
      'DNI Asesor',
      'Inversionista',
      'DNI Inversionista',
      'Inicio',
      'Fin',
      'Moneda',
      'Capital',
      'Interes',
      'Período',
      'Estado',
      'Acciones'
   
  ],

  'mapeo' => [
     'ID' => 'ID_Contrato',
      'Asesor' => 'Asesor',
      'DNI Asesor' => 'dniAsesor',
      'Inversionista' => 'Inversionista',
      'DNI Inversionista' => 'dniInver',
      'Inicio' => 'Inicio',
      'Fin' => 'Fin',
      'Moneda' => 'Moneda',
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
<link rel="stylesheet" href="<?= BASE_URL?>app/css/cronograma-contratos.css">

<body>
    <div class="page-flex">
        <?php require_once "../../includes/sidebar.php"; ?>
        <div class="main-wrapper">
            <?php require_once "../../includes/navbar.php"; ?>
            <?php require_once "../../includes/table.php" ?>
          
              <div id="modal-cronograma" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h3>Cronograma de Pagos - Contrato <span id="modal-contrato-id"></span></h3>
                <div id="modal-cronograma-body">
                </div>
            </div>
        </div>
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
        idField: 'ID_Contrato',
        customRenderers: {
        "Acciones": function(item) { 
            return window.dataTable.renderizarAcciones(item); 
        }
    }
       
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
    <script src="<?= BASE_URL ?>app/js/generarPDF.js"></script>
    

    
    

   
</body>





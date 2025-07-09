<?php  session_start(); ?>
<?php require_once __DIR__ . "/../../includes/header.php"; ?>

<?php

$tipo = 'Inversionistas';

$configuracionTabla = [
  'columnas' => [
    'ID',
    'Nombres y apellidos',
    'Capital',
    'N° cuenta',
    'CCI',
    'Entidad',
    'Nombre de entidad',
    'Asesor',
    'Acciones'
  ],
  'mapeo' => [
    'ID' => 'idinversionista',
    'Nombres y apellidos' => 'nombrecompleto',
    'Capital' => 'capital',
    'N° cuenta' => 'numeros_cuenta',
    'CCI' => 'cci_cuentas',
    'Entidad' => 'tipos_entidad',
    'Nombre de entidad' => 'nombres_entidad',
    'Asesor' => 'nombre_completo_asesor'
  ]
];


$columnas = $configuracionTabla['columnas'];

$links = [
  "Inversionistas" => BASE_URL . "/app/views/inversionistas/inversionista.add"
];
?>



<body>

  <div class="page-flex">

    <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

    <div class="main-wrapper">

      <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

      <?php

      require_once __DIR__ . "/../../includes/table.php"
      ?>
    </div>

  </div>

  <script src="<?= BASE_URL ?>app/js/dataTable.js"></script>
  <script>
    new DataTable({
      tableId: 'dataTable',
      apiUrl: 'controllers/InversionistaController.php',
      tipo: 'Inversionistas',
      columnas: <?= json_encode($configuracionTabla['columnas']) ?>,
      mapeo: <?= json_encode($configuracionTabla['mapeo']) ?>,
      baseUrl: '<?= BASE_URL ?>',
      idField: 'idinversionista',
       customRenderers: {
        "Acciones": function(item) { 
            return window.dataTable.renderizarAcciones(item); 
        }
    }
    });
  </script>





  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

  <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>


  <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>


  <script src="<?= BASE_URL ?>app/js/script.js"></script>
  <script src="<?= BASE_URL ?>app/js/export-excel.js"></script>
  <script src="<?= BASE_URL ?>app/js/inactividad.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', e => {
      exportExcel("<?= $tipo  ?>");
    })
  </script>




</body>
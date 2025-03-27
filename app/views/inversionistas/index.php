<?php require_once __DIR__ . "/../../includes/header.php"; ?>

<?php
$tipo = 'Inversionistas';

$encabezados = [
  'Inversionistas' => ['DNI', 'Apellidos y nombres', 'Fecha de inicio', 'Mes', 'Fecha de termino', 'Capital', '%', 'Monto', 'N° cuenta', 'CCI', 'Entidad', 'Fecha', 'Observacion', 'Garantía', 'Asesor', 'Acciones']
];

$links = [
  "Inversionistas" => "inversionista.add",
];
$columnas = isset($encabezados[$tipo]) ? $encabezados[$tipo] : [];

$datos = [
  'Inversionistas' => [
    'DNI' => '12345678',
    'Apellidos y nombres' => 'González Pérez, Juan',
    'Fecha de inicio' => '15/03/2025',
    'Mes' => 'Marzo',
    'Fecha de termino' => '15/09/2025',
    'Capital' => 'S/ 10,000',
    '%' => '5%',
    'Monto' => 'S/ 500',
    'N° cuenta' => '123-456789-0-12',
    'CCI' => '002-123456789012345678-90',
    'Entidad' => 'Banco XYZ',
    'Fecha' => '15/03/2025',
    'Observacion' => 'Ninguna',
    'Garantía' => 'Sí',
    'Asesor' => 'María López',
    'Acciones' => [
      'editar' => [BASE_URL . 'app/img/svg/Bulk/Edit-white.svg', BASE_URL . 'app/views/leads/inversionistas.update.php'],
      'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
    ]

  ]
  ]

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



  <!-- Chart library -->
  <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>

  <!-- Icons library -->
  <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>

  <!-- Custom scripts -->
  <script src="<?= BASE_URL ?>app/js/script.js"></script>





</body>
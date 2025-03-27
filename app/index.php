<?php require_once './includes/header.php'; ?>

<?php require_once "./includes/config.php"; ?>



<?php
$tipo = 'Leads';
$encabezados = [

  'Leads' => ['Fecha de cita', 'Hora', 'Prioridad', 'Apellidos y nombres', 'Teléfono', 'Correo', 'Asesor', 'Acciones']
];


$links = [

  "Leads" => BASE_URL . "/app/views/leads/leads.add",

];

$columnas = isset($encabezados[$tipo]) ? $encabezados[$tipo] : [];


$datos = [

  'Leads' => [
    'Fecha de cita' => '21/03/2025',
    'Hora' => '15:30pm',
    'Apellidos y nombres' => 'Pilpe Yataco, Josué Isai',
    'Prioridad' => 'Alta',
    'Teléfono' => '919482381',
    'Correo' => 'josue96@gmail.com',
    'Asesor' => 'Julia',
    'Acciones' => [
      'editar' => [BASE_URL . 'app/img/svg/Bulk/Edit-white.svg', BASE_URL . 'app/views/leads/leads.update.php'],
      'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
    ]

  ]


];
?>


<body>
  <div class="page-flex">

    <?php require_once "./includes/sidebar.php"; ?>

    <div class="main-wrapper">

      <?php require_once "./includes/navbar.php"; ?>

      <?php
      $tipo = "Leads";
      require_once "./includes/table.php"
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
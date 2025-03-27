
<?php require_once __DIR__ . "/../../includes/header.php"; ?>



<?php
$tipo = 'Contratos';

$encabezados = [
 
  'Contratos' => ['Asesor', 'Apellidos y nombres', 'DNI', 'Teléfono', 'Correo', 'Fecha de inicio', 'Duración meses', 'Moneda', 'Día de pago', 'Interés', 'Capital', 'Tipo de retorno', 'Período de pago', 'Impuesto de renta', 'Tolerancia de días', 'Versión de contrato', 'N° Cuenta', 'CCI', 'Acciones']
];

$links = [
  
  "Contratos" => BASE_URL . "/app/views/contratos/contratos.add"
];




$columnas = isset($encabezados[$tipo]) ? $encabezados[$tipo] : [];




$datos = [
  'Contratos' => [
    'Asesor' => 'María',
    'Apellidos y nombres' => 'Pilpe Yataco Josué Isai',
    'DNI' => '71882015',
    'Teléfono' => '919482381',
    'Correo' => 'josueyataco96@gamil.com',
    'Fecha de inicio' => '18-02-2025',
    'Duración meses' => '12 Meses',
    'Moneda' => 'PEN',
    'Día de pago' => '1',
    'Interés' => 3,
    'Capital' => 15000,
    'Tipo de retorno' => 'Fijo',
    'Período de pago' => 'Mensual',
    'Impuesto de renta' => 3,
    'Tolerania de días' => 3,
    'Versión de contrato' => 1.0,
    'N° Cuenta' => '145255855555',
    'CCI' => '14545455555555',
    'Acciones' => [
      'editar' => [BASE_URL . 'app/img/svg/Bulk/Edit-white.svg', BASE_URL . 'app/views/leads/contactos.update.php'],
      'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
    ]],




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



    <!-- Chart library -->
  <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>

  <!-- Icons library -->
  <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>

  <!-- Custom scripts -->
  <script src="<?= BASE_URL ?>app/js/script.js"></script>


  <script>

    

  </script>




</body>
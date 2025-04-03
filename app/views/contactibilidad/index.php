
<?php require_once __DIR__ . "/../../includes/header.php"; ?>

<?php
$tipo = 'Contactos';

$encabezados = [
  
  'Contactos' => ['Apellidos y nombres', 'Asesor', 'Correo', 'Teléfono', 'Ocupación', 'Fecha', 'Hora', 'Comentarios', 'Estado', 'Acciones']
];
 

$links = [
 
  "Contactos" => BASE_URL . "/app/views/contactibilidad/contactos.add"
 
];



$columnas = isset($encabezados[$tipo]) ? $encabezados[$tipo] : [];




$datos = [
  

  'Contactos' => [
    'Apellidos y nombres' => 'Pilpe Yataco, Josué Isai',
    'Asesor' => 'Julia',
    'Correo' => 'josue96@gmail.com',
    'Teléfono' => '919482381',
    'Ocupación' => 'Contador',
    'Fecha' => '21/03/2025',
    'Hora' => '15:30pm',
    'Comentarios' => 'Muy interesado en el contrato a firmar',
    'Estado' => 'Cerrado',
    'Acciones' => [
      'editar' => [BASE_URL . 'app/img/svg/Bulk/Edit-white.svg', BASE_URL . 'app/views/leads/contactos.update.php'],
      'eliminar' => BASE_URL . 'app/img/svg/Bulk/Delete.svg'
    ]
  ]

  

];
?>



<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <?php 
              $tipo = "Contactos";
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
  <script src="<?= BASE_URL?>app/js/export-excel.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', e => {
            exportExcel("<?= $tipo	?>");
        })
    </script>






</body>
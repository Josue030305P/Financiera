<?php require_once '../../includes/header.php'; ?>
<?php require_once "../../includes/config.php"; ?>

<?php
$tipo = 'Contactos';

$configuracionTabla = [
    'columnas' => [
        'ID',
        'Nombre y Apellidos',
        'Teléfono',
        'Correo',
        'Ocupación',
        'Fecha',
        'Hora',
        'Comentarios',
        'Asesor',
        'Estado',
        'Acciones'
    ],
    'mapeo' => [
        'ID' => 'idcontactibilidad',
        'Nombre y Apellidos' => ['nombre_completo'],
        'Teléfono' => 'telefono',
        'Correo' => 'email',
        'Ocupación' => 'ocupacion',
        'Fecha' => 'fecha',
        'Hora' => 'hora',
        'Comentarios'  => 'comentarios',
        'Estado' => 'estado',
        'Asesor' => 'asesor'
    ]
];


$columnas = $configuracionTabla['columnas'];

$links = [
    "Contactos" => BASE_URL . "app/views/contactibilidad/contacto.add"
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

  
    <script src="<?= BASE_URL ?>app/js/dataTable.js"></script>
    <script>
    new DataTable({
        tableId: 'dataTable',
        apiUrl: 'controllers/ContactibilidadController.php',
        tipo: 'contactos',
        columnas: <?= json_encode($configuracionTabla['columnas']) ?>,
        mapeo: <?= json_encode($configuracionTabla['mapeo']) ?>,
        baseUrl: '<?= BASE_URL ?>',
        idField: 'idcontactibilidad',
       
    });

    
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>
    
    

   
</body>
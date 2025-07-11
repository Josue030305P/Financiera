<?php session_start();  

if (!isset($_SESSION['nombre'])) {
    header('Location:../'); 
    exit();
}
?>

<?php  require_once '../../includes/header.php' ?>
<?php require_once  '../../includes/config.php' ?>



<?php
$tipo = 'Leads';

$configuracionTabla = [
    'columnas' => [
        'ID',
        'Nombre y Apellidos',
        'Correo',
        'Teléfono',
        'Canal de contacto',
        'Registro',
        'Prioridad',
        'Estado',
        'Asesor',
        'Acciones'
    ],
    'mapeo' => [
        'ID' => 'idlead',
        'Nombre y Apellidos' => ['nombre_completo'],
        'Correo' => 'email',
        'Teléfono' => 'telprincipal',
        'Canal de contacto' => 'canal_contacto',
        'Registro' => 'fecharegistro',
        'Prioridad' => 'prioridad',
        'Estado' => 'estado',
        'Asesor' => 'asesor'
    ]
];

$columnas = $configuracionTabla['columnas'];

$links = [
    "Leads" => BASE_URL . "app/views/leads/leads.add"
];
?>

<body>
    
    <div class="page-flex">
        <?php require_once "../../includes/sidebar.php"; ?>

        <div class="main-wrapper">
            
            <?php require_once "../../includes/table.php" ?>
          
        </div>
    </div>


    <script src="<?= BASE_URL ?>app/js/dataTable.js"></script>
    
    <script>
   new DataTable({
    tableId: 'dataTable',
    apiUrl: 'controllers/LeadController.php',
    tipo: 'leads',
    columnas: <?= json_encode($configuracionTabla['columnas']) ?>,
    mapeo: <?= json_encode($configuracionTabla['mapeo']) ?>,
    baseUrl: '<?= BASE_URL ?>',
    idField: 'idlead',
    customRenderers: { 
      "Acciones": function(item) {
            
            return window.dataTable.renderizarAcciones(item); 
        }  
    }
});

    
</script>

<script src="<?= BASE_URL ?>app/js/leadsFiltros.js"></script>



 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
    <!-- <script src="<?= BASE_URL ?>app/js/test-cronograma.js"></script> -->
    

    
</body>
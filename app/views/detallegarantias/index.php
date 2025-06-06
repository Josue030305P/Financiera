<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>


<link href="<?= BASE_URL ?>app/css/detallegarantia.index.css" rel="stylesheet"> 
<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> 

<meta name="base-url" content="<?= BASE_URL ?>">

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">
            <div class="table-container">
                <div class="table-header-section">
                    <h2 class="table-title">Listado de Garantías</h2>
                    <!-- <a href="<?= BASE_URL ?>app/views/detallegarantia/add.php" class="btn-add">
                        <i class="fas fa-plus-circle"></i> Nueva Garantía
                    </a> -->
                </div>

                <div id="message-container" class="message-container"></div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID Detalle</th>
                                <th>Tipo Garantía</th>
                                <th>Porcentaje</th>
                                <th>Observaciones</th>
                                <th>ID Contrato</th>
                                <th>Inversionista</th>
                                <th>Capital</th>
                                <th>Inicio Contrato</th>
                                <th>Fin Contrato</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="garantias-table-body">
                            
                            <tr>
                                <td colspan="10" style="text-align: center;">Cargando garantías...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>
    
    
    <script src="<?= BASE_URL ?>app/js/detallegarantia.index.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
</body>
</html>
<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/cronograma-pagos.actualizado.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="base-url" content="<?= BASE_URL ?>">

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <div id="cronograma-page-content">

                <div class="container">
                    <h1>Cronograma de Pagos</h1>
                    <h1>Inversionista: <span id="inversionista-display"></span></h1>
                    <h1>DNI: <span id="dni-display"></span></h1>

                 
                    <div class="pdf-export-controls">
                        <button id="pdf-export-button" class="btn-pdf-export">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </button>
                    </div>
                        
                    <div class="tabla-responsive">
                        <table id="tabla-cronograma">
                            <thead>
                                <tr>
                                    <th>Cuota #</th>
                                    <th>Vencimiento</th>
                                    <th>Total Neto</th>
                                    <th>Amortización</th>
                                    <th>Restante</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                          
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/cronograma-actualizado.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>

</body>
<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/historial-pagos.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="base-url" content="<?= BASE_URL ?>">

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <div id="historial-pagos-content">
                <div class="container">
                    <h1 class="page-title">Historial de Pagos del Contrato</h1>
                    
                    <div class="inversionista-detalle">
                        <p><strong>Inversionista:</strong> <span id="inversionista-nombre"></span></p>
                        <p><strong>DNI:</strong> <span id="inversionista-dni"></span></p>
                        <p><strong>ID Contrato:</strong> <span id="contrato-id"></span></p>
                    </div>

                    <div class="historial-controls">
                        <button id="export-pdf-historial" class="btn-export-pdf">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </button>
                        <a href="<?= BASE_URL ?>app/views/cronograma-pagos/" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Volver a Cronograma
                        </a>
                    </div>

                    <div class="tabla-responsive">
                        <table id="tabla-historial-pagos">
                            <thead>
                                <tr>
                                    <th>Cuota #</th>
                                    <th>Monto Pagado</th>
                                    <th>Total Cuota</th> <th>Fecha Pago</th>
                                    <th>Cuenta Depositada</th>
                                    <th>Entidad</th>
                                    <th>N° Transacción</th>
                                    <th>Observaciones</th>
                                    <th>Estado Cuota</th>
                                    <th>Comprobante</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                        </table>
                        <p id="mensaje-sin-historial" style="display: none; text-align: center; margin-top: 20px;">No se encontraron pagos para este contrato.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="comprobanteModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <img id="modalComprobanteImage" src="" alt="Comprobante de Pago">
    </div>
</div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.js"></script>
    <script src="<?= BASE_URL ?>app/js/historial.pagos.js"></script>

</body>
</html>
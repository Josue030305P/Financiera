<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>


<link href="<?= BASE_URL ?>app/css/detallegarantia.add.css" rel="stylesheet">
<meta name="base-url" content="<?= BASE_URL ?>">



<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">
            <div class="form-container-wrapper">
                <div class="card-pago"> 
                    <div class="form-header">
                        Agregar Detalle de Garantía
                    </div>
                    <div class="form-body">
                        <form id="formAddDetalleGarantia">
                            
                            <div class="form-grid"> 
                                <div class="form-group">
                                    <label for="idgarantia" class="form-label">Tipo de Garantía:</label>
                                    <select class="form-select form-control" id="idgarantia" name="idgarantia" required>
                                        <option value="">Cargando tipos de garantía...</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="porcentaje" class="form-label">Porcentaje (%):</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-input form-control" id="porcentaje" name="porcentaje" placeholder="Ej: 75.50" required>
                                </div>

                                <div class="form-group form-group-full-width"> 
                                    <label for="observaciones" class="form-label">Observaciones (Opcional):</label>
                                    <textarea class="form-textarea form-control textarea-large" id="observaciones" name="observaciones" rows="3" placeholder="Añade cualquier observación relevante"></textarea>
                                </div>
                            </div> <!-- Fin form-grid -->

                            <div id="form-messages" class="form-message-container"></div> 
                            
                            <div class="form-actions"> 
                                <button type="submit" class="btn btn-primary btn-submit"> 
                                    <i class="fas fa-plus-circle"></i> Registrar Garantía
                                </button>
                                <a href="<?= BASE_URL ?>app/views/contratos/" class="btn btn-secondary btn-secondary-link"> 
                                    <i class="fas fa-arrow-alt-circle-left"></i> Volver a Contratos
                                </a>
                            </div>
                        </form>
                    </div> <!-- Fin form-body -->
                </div> <!-- Fin card-pago -->
            </div> <!-- Fin form-container-wrapper -->
        </div> <!-- Fin main-wrapper -->
    </div> <!-- Fin page-flex -->

  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/detallegarantia.add.js"></script> 
    
</body>
</html>
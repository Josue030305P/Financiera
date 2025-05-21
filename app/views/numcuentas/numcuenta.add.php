<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/numcuenta.add.css">
<meta name="base-url" content="<?= BASE_URL ?>">

<body>

    <body>
        <div class="page-flex">
            <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

            <div class="main-wrapper">
                <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

                <div id="add-numcuenta-page-content">
                    <div class="container">
                        <h1>Agregar Número de Cuenta</h1>

                        <form id="addNumCuentaForm">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="tipo_entidad">Tipo de Entidad:</label>
                                    <select id="tipo_entidad" name="tipo_entidad" required>
                                        <option value="">Cargando tipos...</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="identidad">Entidad Bancaria:</label>
                                    <select id="identidad" name="identidad" required disabled>
                                        <option value="">Seleccione un tipo primero</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="numcuenta">Número de Cuenta:</label>
                                    <input type="text" id="numcuenta" name="numcuenta"
                                        placeholder="Ingrese número de cuenta" required>
                                </div>

                                <div class="form-group">
                                    <label for="cci">CCI (Código de Cuenta Interbancario):</label>
                                    <input type="text" id="cci" name="cci" placeholder="Ingrese CCI" required>
                                </div>

                                <div class="form-group full-width-observations">
                                    <label for="observaciones">Observaciones:</label>
                                    <textarea id="observaciones" name="observaciones"
                                        placeholder="Notas adicionales sobre la cuenta (opcional)"></textarea>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit">Agregar Cuenta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
        <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
        <script src="<?= BASE_URL ?>app/js/script.js"></script>
        <script src="<?= BASE_URL ?>app/js/numcuenta.js"></script>

    </body>
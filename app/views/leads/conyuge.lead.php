<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once '../../includes/config.php' ?>

<meta name="base-url" content="<?= BASE_URL ?>">
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/form.lead.css">

<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>
        <div class="main-wrapper">
            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <div id="lead-form" class="form-container form">
                <h2 class="form-title">Agregar Nuevo Conyuge</h2>
                <div class="form-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" id="apellidos" placeholder="Ingrese sus apellidos" class="apellidos" required>
                        </div>

                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" id="nombres" placeholder="Ingrese sus nombres" class="nombres" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" id="correo" name="email" placeholder="Ingrese su correo" class="correo" required>
                        </div>


                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" placeholder="Ingrese su teléfono" class="telefono" maxlength="9" required>
                        </div>

                        <div class="form-group">
                            <label for="pais">País</label>
                            <select name="pais" id="pais" class="select-box" required>
                                <option value="">Seleccione un país</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipodocumento">Tipo de documento</label>
                            <select name="tipodocumento" id="tipodocumento" class="select-box" required>
                                <option value="DNI">DNI</option>
                                <option value="PSP">PSP</option>
                                <option value="CEX">CEX</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="domicilio">Domicilio</label>
                            <input type="text" id="domicilio" name="domicilio" placeholder="Ingrese el domicilio" class="domicilio">
                        </div>

                        <div class="form-group">
                            <label for="numdocumento">N° documento</label>
                            <input type="text" id="numdocumento" name="numdocumento" placeholder="Ingrese el n° de documento"
                                class="numdocumento" required="true" maxlength="12">
                        </div>

                    </div>

                    <div class="form-footer">
                        <button type="button" class="add-btn">Agregar Conyuge</button>
                        <button type="button" class="reset-btn">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>



    <script src="<?= BASE_URL ?>app/js/conyuge.form.js"></script>

</body>
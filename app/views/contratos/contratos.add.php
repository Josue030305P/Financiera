<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/inversionistas/form.add.css">

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>


            <div  class="form-container form">
                <h2 class="form-title">Agregar Contrato</h2>
                <div class="form-header">



                    <div class="form-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" id="apellidos" placeholder="Ingrese sus apellidos" class="apellidos">
                            </div>

                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input type="text" id="nombres" placeholder="Ingrese sus nombres" class="nombres">
                            </div>

                            <div class="form-group">
                                <label for="numdocumento">Documento</label>
                                <input type="text" id="numdocumento" placeholder="Ingrese su documento" class="numdocumento">
                            </div>

                            <div class="form-group">
                                <label for="fechanacimiento">Fecha de Nacimiento</label>
                                <input type="date" id="fechanacimiento" class="fechanacimiento">
                            </div>

                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" placeholder="Ingrese su teléfono" class="telefono">
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" id="correo" placeholder="Ingrese su correo" class="correo">
                            </div>

                            <div class="form-group">
                                <label for="pais">País</label>
                                <select id="pais" class="select-box">
                                    <option value="Perú">Perú</option>
                                    <option value="Chile">Chile</option>
                                    <option value="Venezuela">Venezuela</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="nombreempresa">Empresa (Opcional)</label>
                                <input type="text" id="nombreempresa" placeholder="Ingrese nombre de la empresa" class="nombreempresa">
                            </div>

                            <div class="form-group full-width">
                                <label for="ruc">RUC (Opcional)</label>
                                <input type="text" id="ruc" placeholder="Ingrese RUC de la empresa" class="ruc">
                            </div>

                            <div class="form-group">
                                <label for="pais">Asesor</label>
                                <select id="pais" class="select-box">
                                    <option value="María">María</option>
                                    <option value="Paola">Paola</option>
                                    <option value="Julio">Julio</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select id="estado" class="select-box">
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-footer">
                            <button class="add-btn">Agregar Inversionista</button>
                            <button class="reset-btn disabled">Cancelar</button>
                        </div>
                    </div>

                </div>


            </div>


        </div>


        <!-- Chart library -->
        <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>

        <!-- Icons library -->
        <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>

        <!-- Custom scripts -->
        <script src="<?= BASE_URL ?>app/js/script.js"></script>


</body>
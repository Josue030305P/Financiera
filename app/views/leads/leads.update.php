<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/form.lead.css">

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>


    <div id="lead-form" class="form-container">
    <h2 class="form-title">Actualizar</h2>
    <div class="form-header">
        
        <a href="<?=BASE_URL?>app/"><span class="regresar-btn"> ⬅️ Lista de leads</span></a>
    </div>

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
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" placeholder="Ingrese su teléfono" class="telefono">
            </div>

            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" id="correo" placeholder="Ingrese su correo" class="correo">
            </div>

            <div class="form-group">
                <label for="pais">País</label>
                <select name="pais" id="pais" class="select-box">
                    <option value="Alta">Perú</option>
                    <option value="Media">Chile</option>
                    <option value="Baja">Venezuela</option>
                </select>
            </div>

            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <select name="prioridad" id="prioridad" class="select-box">
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label for="ocupacion">Ocupación</label>
                <input type="text" id="ocupacion" placeholder="Ingrese una ocupación" class="ocupacion">
            </div>

            <div class="form-group full-width">
                <label for="comentarios">Comentarios</label>
                <textarea name="comentarios" id="comentarios" class="textarea-box" placeholder="Ingrese algún comentario"></textarea>
            </div>
        </div>

        <div class="form-footer">
            <button class="add-btn">Agregar lead</button>
            <button class=" disabled reset-btn" >Cancelar</button>
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



</html>
<?php require_once '../../includes/header.php'; ?>
<?php require_once "../../includes/config.php"; ?>


<meta name="base-url" content="<?= BASE_URL ?>">
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/form.lead.css">

<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>
        <div class="main-wrapper">
            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <div id="lead-form" class="form-container form">
                <h2 class="form-title">Actualizar Contacto</h2>
                <div class="form-header">
                    <a href="<?=BASE_URL?>app/views/contactibilidad/"><span class="regresar-btn"> ⬅️ Lista de contactos </span></a>
                </div>

                <div class="form-body">
                    <div class="form-grid">
                    

                        <div class="form-group">
                            <label for="correo">Hora</label>
                            <input type="time" id="hora" placeholder="Ingrese la hora" class="hora" required>
                        </div>

                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <select name="fecha" id="fecha" class="select-box" required>
                                <option value="">Seleccione una fecha</option>
                            </select>
                        </div>

                        

                        <div class="form-group">
                            <label for="estaod">Estado</label>
                            <select name="asesor" id="asesor" class="select-box" required>
                                <option value="">Seleccione un estado</option>
                            </select>
                        </div>



                        <div class="form-group full-width">
                            <label for="comentarios">Comentarios</label>
                            <textarea name="comentarios" id="comentarios" class="textarea-box"></textarea>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="button" class="add-btn">Actualizar lead</button>
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
 
    

    <script src="<?= BASE_URL ?>app/js/lead.form.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            const urlParams = new URLSearchParams(window.location.search);
            const leadId = urlParams.get('id');
            
            if (leadId) {
                
                new LeadForm(leadId, true);
            } else {
                alert('ID de lead no proporcionado');
                window.location.href = '<?= BASE_URL ?>app/';
            }
        });
    </script>
</body>



</html>
<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php  require_once '../../includes/config.php' ?>

<meta name="base-url" content="<?= BASE_URL ?>">
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/form.lead.css">

<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>
        <div class="main-wrapper">
        

            <div id="lead-form" class="form-container form">
                <h2 class="form-title">Agregar Nuevo Lead</h2>
                <div class="form-header">
                    <a href="<?=BASE_URL?>app/views/leads"><span class="regresar-btn"> ⬅️ Lista de leads</span></a>
                </div>

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
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" placeholder="Ingrese su teléfono" class="telefono" maxlength="9" required>
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" placeholder="Ingrese su correo" class="correo" required>
                        </div>

                        <div class="form-group">
                            <label for="pais">País</label>
                            <select name="pais" id="pais" class="select-box" required>
                                <option value="">Seleccione un país</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="prioridad">Prioridad</label>
                            <select name="prioridad" id="prioridad" class="select-box" required>
                                <option value="">Seleccione prioridad</option>
                                <option value="Alto">Alto</option>
                                <option value="Medio">Medio</option>
                                <option value="Bajo">Bajo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="asesor">Asesor</label>
                            <select name="asesor" id="asesor" class="select-box" required>
                                <option value="">Cargando asesores...</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="canal">Canal</label>
                            <select name="canal" id="canal" class="select-box" required>
                                <option value="">Seleccione un canal</option>
                                <option value="1">Facebook</option>
                               <option value="2">WhatsApp</option>
                                <option value="3">Instagram</option>
                                
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="ocupacion">Ocupación</label>
                            <input type="text" id="ocupacion" placeholder="Ingrese una ocupación" class="ocupacion">
                        </div>

                        <div class="form-group full-width">
                            <label for="comentarios">Comentarios</label>
                            <textarea name="comentarios" id="comentarios" class="textarea-box"></textarea>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="button" class="add-btn">Agregar lead</button>
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
            new LeadForm();
        });
    </script>
</body>




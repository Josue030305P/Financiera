<?php
session_start();
require_once '../../includes/header.php';
require_once __DIR__ . "/../../includes/config.php";


$idLead = $_GET['idlead'] ?? null;
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/contactibilidad.add.css">
<meta name="base-url" content="<?= BASE_URL ?>">

<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">
            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <div id="add-contactibilidad-page-content">
                <div class="container">
                    <h1>Registrar Contacto</h1>

                    <form id="addContactibilidadForm">
                        <div class="form-grid">
                            <input type="hidden" name="idlead" value="<?= htmlspecialchars($idLead) ?>">

                            <div class="form-group">
                                <label for="fecha_contacto">Fecha de Contacto:</label>
                                <input type="date" id="fecha_contacto" name="fecha_contacto" required>
                            </div>

                            <div class="form-group">
                                <label for="hora_contacto">Hora de Contacto:</label>
                                <input type="time" id="hora_contacto" name="hora_contacto" required>
                            </div>

                            <div class="form-group">
                                <label for="estado_contactibilidad">Estado de la Contactibilidad:</label>
                                <select id="estado_contactibilidad" name="estado_contactibilidad" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="Realizado">Realizado</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Reprogramado">Reprogramado</option>
                                </select>
                            </div>

                            <div class="form-group full-width-comments">
                                <label for="comentarios">Comentarios:</label>
                                <textarea id="comentarios" name="comentarios" placeholder="Notas detalladas sobre la interacción (ej. 'Interesado en inversión a corto plazo, llamar el lunes')"></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit">Registrar Contacto</button>
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
    <script src="<?= BASE_URL ?>app/js/contactibilidad.js"></script>

</body>


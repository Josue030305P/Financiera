<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/cronograma-pagos.css">
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

                    <div class="filtros">
                        <div class="filter-group">
                            <label for="filtro-estado">Estado:</label>
                            <select id="filtro-estado">
                                <option value="">Todos</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Pagado">Pagado</option>
                                <option value="Vencido">Vencido</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filtro-id-contrato">ID Contrato:</label>
                            <input type="number" id="filtro-id-contrato" placeholder="Ingrese ID">
                        </div>

                        <div class="filter-group">
                            <label for="filtro-dni">DNI Inversionista:</label>
                            <input type="text" id="filtro-dni" placeholder="Ingrese DNI" maxlength="8">
                        </div>

                        <button id="btn-filtrar">Filtrar</button>
                        <button id="btn-limpiar-filtro">Limpiar Filtros</button>
                    </div>

                    <div class="tabla-responsive">
                        <table id="tabla-cronograma">
                            <thead>
                                <tr>
                                    <th>Contrato</th>
                                    <th>Resumen</th>
                                    <th>Total Bruto Contrato</th>
                                    <th>Inversionista</th>
                                    <th>DNI</th>
                                    <th>Cuota #</th>
                                    <th>Vencimiento</th>
                                    <th>Total Neto</th>
                                    <th>Amortización</th>
                                    <th>Restante</th>
                                    <th>Estado</th>
                                    <th>Detalles..</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                   
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

           

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/filtrosCronogramas.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>
    <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>

</body>
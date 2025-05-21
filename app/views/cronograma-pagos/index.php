<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/cronograma-pagos.css">
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
                                    <td>1</td>
                                    <td>1 pagos</td>
                                    <td>865.00</td>
                                    <td>Estrella Xiomara Saravia Guerrero</td>
                                    <td>44433322</td>
                                    <td>1</td>
                                    <td>12-08-2025</td>
                                    <td>865.00</td>
                                    <td>0.00</td>
                                    <td>865.00</td>
                                    <td><span class="estado-pendiente">Pendiente</span></td>
                                    <td>
                                        <div class="acciones-tabla">
                                            <button class="btn-expandir">+</button>
                                            <button class="btn-exportar-excel">Excel</button>
                                        </div>
                                    </td>
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
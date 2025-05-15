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
                        <label for="filtro-estado">Estado:</label>
                        <select id="filtro-estado">
                            <option value="">Todos</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Pagado">Pagado</option>
                            <option value="Vencido">Vencido</option>
                        </select>

                        <label for="filtro-fecha-inicio">Fecha Inicio:</label>
                        <input type="date" id="filtro-fecha-inicio">

                        <label for="filtro-fecha-fin">Fecha Fin:</label>
                        <input type="date" id="filtro-fecha-fin">

                        <label for="filtro-id-contrato">ID Contrato:</label>
                        <input type="number" id="filtro-id-contrato" placeholder="Ingrese ID">

                        <label for="filtro-dni">DNI Inversionista:</label>
                        <input type="text" id="filtro-dni" placeholder="Ingrese DNI">

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
                                    <th>Fecha Inicio Contrato</th>
                                    <th>Fecha Fin Contrato</th>
                                    <th>Detalles..</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>


    </div>


    <script src="<?= BASE_URL ?>app/js/filtrosCronogramas.js"></script>

</body>
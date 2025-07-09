<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>/app/css/detallepagos.css">
<meta name="base-url" content="<?= BASE_URL ?>">

<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">
            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <div id="detalle-pagos-page-content">
                <div class="container">
                    <h1>Detalle de Pagos Realizados</h1>

                    <div class="filtros" style="display: none;">
                        <div class="filter-group">
                            <label for="filtro-estado-cuota">Estado Cuota:</label>
                            <select id="filtro-estado-cuota">
                                <option value="">Todos</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Pagado">Pagado</option>
                                <option value="Vencido">Vencido</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filtro-dni-inversionista">DNI Inversionista:</label>
                            <input type="text" id="filtro-dni-inversionista" placeholder="Ingrese DNI" maxlength="8">
                        </div>

                        <div class="filter-group">
                            <label for="filtro-n-transaccion">N° Transacción:</label>
                            <input type="text" id="filtro-n-transaccion" placeholder="Ingrese N° Transacción">
                        </div>

                        <button id="btn-filtrar-detalle">Filtrar</button>
                        <button id="btn-limpiar-filtro-detalle">Limpiar Filtros</button>
                    </div>

                    <div class="tabla-responsive">
                        <table id="tabla-detalle-pagos">
                            <thead>
                                <tr>
                       
                                    <th>Inversionista</th>
                                    <th>DNI</th>
                                    <th>Cuenta Depositada</th>
                                    <th>Entidad</th>
                                    <th>N° Transacción</th>
                                    <th>Monto Pagado</th>
                                    <th>Observaciones</th>
                                    <th>N° Cuota</th>
                                    <th>Total Cuota</th>
                                    <th>Estado Cuota</th>
                                    <th>Usuario</th>
                                    <th>Fecha Pago</th>
                                    <th>FV.Cuota</th>
                                    <th>Acciones</th> </tr>
                            </thead>
                            <tbody id="paymentDetailsTableBody">
                                </tbody>
                        </table>
                        <p id="mensaje-sin-resultados" style="display:none; text-align:center; margin-top:20px;">No hay detalles de pagos para mostrar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="<?= BASE_URL ?>app/js/detallepago.index.js"></script>
    <script src="<?= BASE_URL ?>app/js/inactividad.js"></script>

</body>

</html>
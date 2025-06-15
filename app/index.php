<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header('Location:../');
    exit();
}

require_once './includes/header.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="base-url" content="<?= BASE_URL ?>" charset="UTF-8">
    <title>Dashboard | Plataforma de Inversiones</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= BASE_URL ?>app/css/dashboard.css">

</head>

<body>
    <div class="page-flex">
        <?php require_once "./includes/sidebar.php"; ?>
        <div class="main-wrapper">
            <div class="content-area">

                <h2 class="dashboard-title">DASHBOARD</h2>
                <div class="summary-widgets-grid" id="dashboard-summary-widgets">
                    <!-- Las tarjetas de resumen se cargarán aquí dinámicamente con JS -->
                </div>

                <hr class="section-divider">

                <h2 class="dashboard-title" id="detalle-tablas-titulo" style="display: none;">Detalle Completo</h2>
                <div id="detalle-tablas-container" class="list-sections-grid" style="display: none;">

                    <div id="detalle-contratos_activos-table-section" class="detalle-table-section">
                        <div class="card-header header-primary">
                            <h5 class="card-title"><i class="fas fa-file-contract icon-margin"></i>Detalle de Contratos Activos</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-contratos_activos-table-body" data-title="Contratos_Activos">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Inversionista</th>
                                            <th>DNI</th>
                                            <th>Monto Invertido</th>
                                            <th>Inicio Contrato</th>
                                            <th>Fin Contrato</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-contratos_activos-table-body">
                                        <!-- Table rows will be filled by JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- SECCIÓN PARA EL GRÁFICO DE MONTO TOTAL INVERTIDO (ANTES ERA UNA TABLA) -->
                    <div id="detalle-monto_total_invertido-chart-section" class="detalle-chart-section" style="display: none;">
                        <div class="card-header header-info">
                            <h5 class="card-title"><i class="fas fa-wallet icon-margin"></i>Monto Invertido por Contrato Activo</h5>
                            <!-- No hay botón de exportar PDF directo para el gráfico, si se necesita se implementaría una exportación de imagen -->
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:300px; width:100%;">
                                <!-- El canvas donde se dibujará el gráfico -->
                                <canvas id="montoTotalInvertidoChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- FIN SECCIÓN GRÁFICO -->

                    <div id="detalle-proximos_pagos-table-section" class="detalle-table-section">
                        <div class="card-header header-warning">
                            <h5 class="card-title"><i class="fas fa-calendar-alt icon-margin"></i>Detalle de Próximos Pagos Pendientes</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-proximos_pagos-table-body" data-title="Proximos_Pagos_Pendientes">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Inversionista</th>
                                            <th>DNI</th>
                                            <th>N° Cuota</th>
                                            <th>Monto Cuota</th>
                                            <th>Fecha Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-proximos_pagos-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="detalle-leads_en_proceso-table-section" class="detalle-table-section">
                        <div class="card-header header-secondary">
                            <h5 class="card-title"><i class="fas fa-handshake icon-margin"></i>Detalle de Leads en Proceso</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-leads_en_proceso-table-body" data-title="Leads_en_Proceso">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre Lead</th>
                                            <th>Teléfono Lead</th>
                                            <th>Asesor Asignado</th>
                                            <th>Estado Lead</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-leads_en_proceso-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="detalle-contratos_por_vencer-table-section" class="detalle-table-section">
                        <div class="card-header header-danger">
                            <h5 class="card-title"><i class="fas fa-hourglass-end icon-margin"></i>Detalle de Contratos por Vencer Pronto</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-contratos_por_vencer-table-body" data-title="Contratos_por_Vencer">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Inversionista</th>
                                            <th>DNI</th>
                                            <th>Monto Invertido</th>
                                            <th>Fecha Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-contratos_por_vencer-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="detalle-colaboradores_activos-table-section" class="detalle-table-section">
                        <div class="card-header header-info">
                            <h5 class="card-title"><i class="fas fa-user-tie icon-margin"></i>Detalle de Colaboradores Activos</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-colaboradores_activos-table-body" data-title="Colaboradores_Activos">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Colaborador</th>
                                            <th>DNI</th>
                                            <th>Rol</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-colaboradores_activos-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="detalle-pagos_hoy-table-section" class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-money-bill-wave icon-margin"></i>Detalle de Pagos Realizados Hoy</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_hoy-table-body" data-title="Pagos_Realizados_Hoy">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Inversionista</th>
                                            <th>DNI</th>
                                            <th>Monto Pagado</th>
                                            <th>Fecha/Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-pagos_hoy-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- NUEVAS SECCIONES DE TABLA PARA PAGOS DE AYER, SEMANA ACTUAL Y MES ACTUAL -->
                    <div id="detalle-pagos_ayer-table-section" class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-calendar-day icon-margin"></i>Detalle de Pagos Realizados Ayer</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_ayer-table-body" data-title="Pagos_Realizados_Ayer">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Inversionista</th>
                                            <th>DNI</th>
                                            <th>Monto Pagado</th>
                                            <th>Fecha/Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-pagos_ayer-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="detalle-pagos_semana_actual-table-section" class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-calendar-week icon-margin"></i>Detalle de Pagos Realizados Semana Actual</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_semana_actual-table-body" data-title="Pagos_Realizados_Semana_Actual">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Inversionista</th>
                                            <th>DNI</th>
                                            <th>Monto Pagado</th>
                                            <th>Fecha/Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-pagos_semana_actual-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="detalle-pagos_mes_actual-table-section" class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-calendar-alt icon-margin"></i>Detalle de Pagos Realizados Mes Actual</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_mes_actual-table-body" data-title="Pagos_Realizados_Mes_Actual">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th>Inversionista</th>
                                            <th>DNI</th>
                                            <th>Monto Pagado</th>
                                            <th>Fecha/Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle-pagos_mes_actual-table-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- FIN NUEVAS SECCIONES DE TABLA -->

                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.js"></script>
    <!-- Incluye Chart.js antes de tu script de dashboard.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= BASE_URL ?>app/js/script.js"></script>
    <script src="<?= BASE_URL ?>app/js/dashboard.js"></script>

</body>

</html>
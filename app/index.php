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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= BASE_URL ?>app/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
    <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">
    <style>
        .introjs-tooltip {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: none;
            padding: 15px 20px;
            font-family: 'Inter', sans-serif;
            text-align: center;
        }

        .custom-tooltip {
            background-color: #1a202c !important;
            color: #fff !important;
            font-size: 15px;
            border-radius: 8px;
            padding: 15px;
            max-width: 300px;
            line-height: 1.6;
            position: relative;
        }

        .custom-highlight {
            box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.7), 0 0 0 10000px rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
        }

        .introjs-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .introjs-button:hover {
            background-color: #45a049;
        }

        .introjs-prevbutton {
            background-color: #4a5568;
        }

        .introjs-prevbutton:hover {
            background-color: #2d3748;
        }

        .introjs-skipbutton {
            background-color: transparent;
            color: #a0aec0;

            position: absolute;
            top: 10px;
            right: 15px;
            padding: 5px 10px;
            font-size: 13px;
            border-radius: 5px;
            z-index: 1000;
        }

        .introjs-skipbutton:hover {
            color: #e2e8f0;
            border-color: #e2e8f0;
        }

        .introjs-donebutton {
            background-color: #007bff;
            color: white;
        }

        .introjs-donebutton:hover {
            background-color: #0056b3;
        }

        .introjs-bullets {
            text-align: center;
            padding: 10px 0;
        }

        .introjs-bullets ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: inline-block;
        }

        .introjs-bullets li {
            display: inline-block;
            margin: 0 5px;
        }

        .introjs-bullets a {
            display: block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #cbd5e0;
            transition: background-color 0.3s ease;
        }

        .introjs-bullets a.active {
            background-color: #4CAF50;
            border: 2px solid #38a169;
        }

        .introjs-arrow {
            border: none !important;
        }

        .introjs-arrow.top {
            border-bottom-color: #1a202c !important;
        }

        .introjs-arrow.bottom {
            border-top-color: #1a202c !important;
        }

        .introjs-arrow.left {
            border-right-color: #1a202c !important;
        }

        .introjs-arrow.right {
            border-left-color: #1a202c !important;
        }

        .introjs-overlay {
            opacity: 0.6 !important;
        }

        .introjs-tooltip-header {
            position: relative;
            padding-top: 20px;
        }
    </style>

</head>


<body>
    <div class="page-flex">
        <?php require_once "./includes/sidebar.php"; ?>
        <div class="main-wrapper">
            <div class="content-area">

                <h2 class="dashboard-title"
                    data-intro="Este es el panel principal donde visualizas el estado de la plataforma." data-step="1">
                    DASHBOARD</h2>
                <div class="summary-widgets-grid" id="dashboard-summary-widgets"
                    data-intro="Aquí se muestran los indicadores clave como contratos, pagos, leads, etc."
                    data-step="2">
                    <!-- Las tarjetas de resumen se cargarán aquí dinámicamente con JS -->
                </div>

                <hr class="section-divider">

                <h2 class="dashboard-title"
                    data-intro="Esta sección aparece cuando haces clic en una tarjeta para ver los datos detallados."
                    data-step="3" id="detalle-tablas-titulo" style="display: none;">Detalle Completo</h2>
                <div id="detalle-tablas-container" class="list-sections-grid" style="display: none;">

                    <div id="detalle-contratos_activos-table-section"
                        data-intro="Aquí puedes ver todos los contratos que están actualmente activos." data-step="4"
                        class="detalle-table-section">
                        <div class="card-header header-primary">
                            <h5 class="card-title"><i class="fas fa-file-contract icon-margin"></i>Detalle de Contratos
                                Activos</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-contratos_activos-table-body"
                                data-title="Contratos_Activos">
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
                    <div id="detalle-monto_total_invertido-chart-section"
                        data-intro="Este gráfico muestra el monto total invertido por cada contrato activo."
                        data-step="5" class="detalle-chart-section" style="display: none;">
                        <div class="card-header header-info">
                            <h5 class="card-title"><i class="fas fa-wallet icon-margin"></i>Monto Invertido por Contrato
                                Activo</h5>
                            <!-- No hay botón de exportar PDF directo para el gráfico, si se necesita se implementaría una exportación de imagen -->
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:300px; width:100%;">
                                <!-- El canvas donde se dibujará el gráfico -->
                                <div id="montoTotalInvertidoChart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN SECCIÓN GRÁFICO -->

                    <div id="detalle-proximos_pagos-table-section"
                        data-intro="Aquí puedes ver los pagos que están por vencer pronto." data-step="6"
                        class="detalle-table-section">
                        <div class="card-header header-warning">
                            <h5 class="card-title"><i class="fas fa-calendar-alt icon-margin"></i>Detalle de Próximos
                                Pagos Pendientes</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-proximos_pagos-table-body"
                                data-title="Proximos_Pagos_Pendientes">
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

                    <div id="detalle-leads_en_proceso-table-section"
                        data-intro="Muestra los leads que aún están en proceso de cierre." data-step="7"
                        class="detalle-table-section">
                        <div class="card-header header-secondary">
                            <h5 class="card-title"><i class="fas fa-handshake icon-margin"></i>Detalle de Leads en
                                Proceso</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-leads_en_proceso-table-body"
                                data-title="Leads_en_Proceso">
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

                    <div id="detalle-contratos_por_vencer-table-section"
                        data-intro="Aquí se listan los contratos que están cerca a vencerse." data-step="8"
                        class="detalle-table-section">
                        <div class="card-header header-danger">
                            <h5 class="card-title"><i class="fas fa-hourglass-end icon-margin"></i>Detalle de Contratos
                                por Vencer Pronto</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-contratos_por_vencer-table-body"
                                data-title="Contratos_por_Vencer">
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

                    <div id="detalle-colaboradores_activos-table-section"
                        data-intro="Lista de los asesores o usuarios activos actualmente." data-step="9"
                        class="detalle-table-section">
                        <div class="card-header header-info">
                            <h5 class="card-title"><i class="fas fa-user-tie icon-margin"></i>Detalle de Colaboradores
                                Activos</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-colaboradores_activos-table-body"
                                data-title="Colaboradores_Activos">
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

                    <div id="detalle-pagos_hoy-table-section" data-intro="Resumen de pagos realizados en el día de hoy."
                        data-step="10" class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-money-bill-wave icon-margin"></i>Detalle de Pagos
                                Realizados Hoy</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_hoy-table-body"
                                data-title="Pagos_Realizados_Hoy">
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
                    <div id="detalle-pagos_ayer-table-section" data-intro="Pagos realizados en la jornada anterior."
                        data-step="11" class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-calendar-day icon-margin"></i>Detalle de Pagos
                                Realizados Ayer</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_ayer-table-body"
                                data-title="Pagos_Realizados_Ayer">
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

                    <div id="detalle-pagos_semana_actual-table-section"
                        data-intro="Pagos registrados en la semana actual." data-step="12"
                        class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-calendar-week icon-margin"></i>Detalle de Pagos
                                Realizados Semana Actual</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_semana_actual-table-body"
                                data-title="Pagos_Realizados_Semana_Actual">
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

                    <div id="detalle-pagos_mes_actual-table-section"
                        data-intro="Total de pagos efectuados durante este mes." data-step="13"
                        class="detalle-table-section">
                        <div class="card-header header-success">
                            <h5 class="card-title"><i class="fas fa-calendar-alt icon-margin"></i>Detalle de Pagos
                                Realizados Mes Actual</h5>
                            <button class="btn btn-export-pdf" data-table-id="detalle-pagos_mes_actual-table-body"
                                data-title="Pagos_Realizados_Mes_Actual">
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

    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.js"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <script src="<?= BASE_URL ?>app/js/dashboard.js"></script>
        <script src="<?= BASE_URL ?>app/js/inactividad.js"></script>
    <script>
        function iniciarTourIntroJS() {
            introJs().setOptions({
                nextLabel: 'Siguiente',
                prevLabel: 'Anterior',
                doneLabel: 'Finalizar',
                skipLabel: 'Saltar',
                tooltipClass: 'custom-tooltip',
                highlightClass: 'custom-highlight'
            }).onchange(function (element) {
                mostrarDetallePorPaso(element);
            }).start();
        }



        function mostrarDetallePorPaso(elemento) {
            // Mostrar el contenedor general y el título del detalle
            const contenedor = document.getElementById('detalle-tablas-container');
            const titulo = document.getElementById('detalle-tablas-titulo');
            titulo.style.display = 'block';
            contenedor.style.display = 'grid';

            // Ocultar todas las secciones antes de mostrar la actual
            document.querySelectorAll('.detalle-table-section, .detalle-chart-section').forEach(seccion => {
                seccion.style.display = 'none';
            });

            // Mostrar la sección actual si está en el listado
            const id = elemento.id;

            const seccionesValidas = [
                "detalle-contratos_activos-table-section",
                "detalle-monto_total_invertido-chart-section",
                "detalle-proximos_pagos-table-section",
                "detalle-leads_en_proceso-table-section",
                "detalle-contratos_por_vencer-table-section",
                "detalle-colaboradores_activos-table-section",
                "detalle-pagos_hoy-table-section",
                "detalle-pagos_ayer-table-section",
                "detalle-pagos_semana_actual-table-section",
                "detalle-pagos_mes_actual-table-section"
            ];

            if (seccionesValidas.includes(id)) {
                const target = document.getElementById(id);
                target.style.display = 'block';
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }


        // Mostrar el tour SOLO una vez por navegador
        setTimeout(() => {
            if (!localStorage.getItem('tour_tabla_realizado')) {
                iniciarTourTabla();
                localStorage.setItem('tour_tabla_realizado', 'true');
            }
        }, 1000);

    </script>



</body>

</html>
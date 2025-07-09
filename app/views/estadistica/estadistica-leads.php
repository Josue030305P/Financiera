<?php session_start(); ?>
<?php require_once '../../includes/header.php'; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>
<meta name="base-url" content="<?= BASE_URL ?>">

<style>
    body {
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        
        font-weight: 600;
        
        color: #1e90ff;;
    }

    .chart-container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .btn-export {
        display: block;
        margin: 0 auto 20px auto;
        padding: 10px 20px;
        background-color: #1e90ff;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-export:hover {
        background-color: #0f72d1;
    }
</style>

<body>
    <div class="page-flex">
        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>
        <div class="main-wrapper">

            <div class="chart-container">
                <h2>Distribución de Leads por Canal</h2>
                <button id="btn-download-leads" class="btn-export">Descargar Gráfico</button>
                <div id="chart-leads-canal"></div>
            </div>

            <div class="chart-container">
                <h2>Leads que se convirtieron en Inversionistas</h2>
                <div id="chart-leads-convertidos"></div>
                <div id="total-convertidos" style="text-align: center; font-weight: bold; margin-top: 10px;"></div>
            </div>


            <div class="chart-container">
                <h2>Inversionistas por Asesor</h2>
                <div id="chart-inversionistas-asesor"></div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="<?= BASE_URL ?>app/js/inactividad.js"></script>
<script>
        const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
        let chartLeadsCanal = null;

        async function cargarGraficoLeads() {
            try {
                const response = await fetch(`${baseUrl}app/controllers/EstadisticaController.php`);
                const data = await response.json();

                const canales = data.map(item => item.canal);
                const cantidades = data.map(item => item.total);

                const options = {
                    chart: {
                        type: 'donut',
                        height: 350,
                        id: 'grafico-leads'
                    },
                    series: cantidades,
                    labels: canales,
                    legend: {
                        position: 'bottom'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: { width: 300 }
                        }
                    }]
                };

                chartLeadsCanal = new ApexCharts(document.querySelector("#chart-leads-canal"), options);
                chartLeadsCanal.render();
            } catch (error) {
                console.error("Error al cargar gráfico de leads:", error);
            }
        }
        async function cargarGraficoConvertidos() {
            try {
                const response = await fetch(`${baseUrl}app/controllers/EstadisticaController.php?tipo=convertidos`);
                const data = await response.json();

                const canales = data.map(item => item.canal);
                const cantidades = data.map(item => item.total);
                const totalConvertidos = cantidades.reduce((sum, val) => sum + val, 0);

                document.getElementById("total-convertidos").innerText = `Total: ${totalConvertidos} leads convertidos`;

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: 'Convertidos',
                        data: cantidades
                    }],
                    xaxis: {
                        categories: canales
                    },
                    plotOptions: {
                        bar: {
                            distributed: true, // 💡 Hace que cada barra tenga su propio color
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: [
                        '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728',
                        '#9467bd', '#8c564b', '#e377c2', '#7f7f7f',
                        '#bcbd22', '#17becf'
                    ],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return val;
                        },
                        offsetY: -10,
                        style: {
                            fontSize: '12px',
                            colors: ["#333"]
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#chart-leads-convertidos"), options);
                chart.render();
            } catch (error) {
                console.error("Error al cargar gráfico de convertidos:", error);
            }
        }

        async function cargarGraficoInversionistas() {
            try {
                const response = await fetch(`${baseUrl}app/controllers/EstadisticaController.php?tipo=inversionistas_por_asesor`);
                const data = await response.json();

                const asesores = data.map(item => item.usuario);
                const cantidades = data.map(item => item.total);

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: 'Inversionistas',
                        data: cantidades
                    }],
                    xaxis: {
                        categories: asesores,
                        title: { text: 'Asesores' }
                    }, plotOptions: {
                        bar: {
                            distributed: true, // 💡 Hace que cada barra tenga su propio color
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: [
                        '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728',
                        '#9467bd', '#8c564b', '#e377c2', '#7f7f7f',
                        '#bcbd22', '#17becf'
                    ],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return val;
                        },
                        offsetY: -10,
                        style: {
                            fontSize: '12px',
                            colors: ["#333"]
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector("#chart-inversionistas-asesor"), options);
                chart.render();
            } catch (error) {
                console.error("Error al cargar gráfico de inversionistas:", error);
            }
        }

        // Descargar el primer gráfico como imagen PNG
        document.getElementById('btn-download-leads').addEventListener('click', function () {
            if (chartLeadsCanal) {
                chartLeadsCanal.dataURI().then(({ imgURI }) => {
                    const link = document.createElement('a');
                    link.href = imgURI;
                    link.download = "grafico-leads-canal.png";
                    link.click();
                });
            }
        });

        cargarGraficoLeads();
        cargarGraficoConvertidos();
        cargarGraficoInversionistas();
    </script>
</body>
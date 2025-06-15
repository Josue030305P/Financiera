document.addEventListener('DOMContentLoaded', () => {

    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
    let activeSectionId = null;
    let montoTotalInvertidoChartInstance = null;

    const formatCurrency = (value) => {
        return parseFloat(value || 0).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    const fetchDashboardData = async () => {
        try {
            const response = await fetch(`${baseUrl}app/controllers/DashboardController.php`);
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP Error! Status: ${response.status} - ${response.statusText}. Server response: ${errorText}`);
            }
            const apiResponse = await response.json();

            if (apiResponse && apiResponse.status === true && apiResponse.data) {
                const transformedData = {
                    summary: {
                        contratosActivos: apiResponse.data.resumen.contratos_activos || 0,
                        montoTotalInvertido: apiResponse.data.resumen.monto_total_invertido || "0.00",
                        proximosPagosPendientes: apiResponse.data.resumen.proximos_pagos_cantidad || 0,
                        leadsEnProceso: apiResponse.data.resumen.leads_en_proceso || 0,
                        contratosPorVencer: apiResponse.data.resumen.contratos_por_vencer || 0,
                        colaboradoresActivos: apiResponse.data.resumen.colaboradores_activos || 0,
                        pagosHoy: apiResponse.data.resumen.total_pagos_hoy || "0.00", // This is now count
                        pagosAyer: apiResponse.data.resumen.total_monto_pagado_ayer || "0.00",
                        pagosSemanaActual: apiResponse.data.resumen.total_monto_pagado_semana_actual || "0.00",
                        pagosMesActual: apiResponse.data.resumen.total_monto_pagado_mes_actual || "0.00"
                    },
                    details: {
                        contratosActivos: apiResponse.data.listados.contratos_activos.map(item => ({
                            idcontrato: item.idcontrato,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            monto_invertido: item.monto_invertido,
                            fecha_inicio: item.fecha_inicio_contrato,
                            fecha_fin: item.fecha_fin_contrato,
                            interes_contrato: item.interes_contrato
                        })),
                        proximosPagos: apiResponse.data.listados.proximos_pagos.map(item => ({
                            idcronogramapago: item.idcronogramapago,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            numero_cuota: item.numcuota,
                            monto_cuota: item.monto_cuota,
                            fecha_vencimiento: item.fecha_vencimiento_cuota
                        })),
                        leadsEnProceso: apiResponse.data.listados.leads_en_proceso.map(item => ({
                            idlead: item.idlead,
                            nombre_lead: `${item.lead_nombres} ${item.lead_apellidos}`,
                            telefono_lead: item.lead_telefono,
                            prioridad: item.prioridad,
                            estado_lead: item.estado_lead,
                            asesor_asignado_nombre: item.asesor_asignado
                        })),
                        contratosPorVencer: apiResponse.data.listados.contratos_por_vencer.map(item => ({
                            idcontrato: item.idcontrato,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            monto_invertido: item.monto_invertido,
                            fecha_vencimiento: item.fecha_fin_contrato
                        })),
                        colaboradoresActivos: apiResponse.data.listados.colaboradores_activos.map(item => ({
                            idcolaborador: item.idcolaborador,
                            nombre_colaborador: `${item.colaborador_nombres} ${item.colaborador_apellidos}`,
                            dni_colaborador: item.colaborador_dni,
                            rol_colaborador: item.rol_colaborador
                        })),
                        pagosHoy: apiResponse.data.listados.pagos_hoy.map(item => ({
                            idpago: item.iddetallepago,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            monto_pagado: item.monto_pagado,
                            fecha_hora_pago: item.fecha_hora_pago
                        })),
                        pagosAyer: apiResponse.data.listados.pagos_ayer.map(item => ({
                            idpago: item.iddetallepago,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            monto_pagado: item.monto_pagado,
                            fecha_hora_pago: item.fecha_hora_pago
                        })),
                        pagosSemanaActual: apiResponse.data.listados.pagos_semana_actual.map(item => ({
                            idpago: item.iddetallepago,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            monto_pagado: item.monto_pagado,
                            fecha_hora_pago: item.fecha_hora_pago
                        })),
                        pagosMesActual: apiResponse.data.listados.pagos_mes_actual.map(item => ({
                            idpago: item.iddetallepago,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            monto_pagado: item.monto_pagado,
                            fecha_hora_pago: item.fecha_hora_pago
                        }))
                    }
                };
                return transformedData;
            } else {
                console.error("Unexpected dashboard data format or false status:", apiResponse);
                return null;
            }
        } catch (error) {
            console.error("Error fetching dashboard data:", error);
            Swal.fire({
                icon: 'error',
                title: 'Load Error',
                text: 'Could not load dashboard data. Please try again later.'
            });
            return null;
        }
    };

    const renderSummaryWidgets = (data) => {
        const summaryWidgetsGrid = document.getElementById('dashboard-summary-widgets');
        if (!summaryWidgetsGrid || !data || !data.summary) {
            console.warn("No summary data to render widgets.");
            return;
        }

        summaryWidgetsGrid.innerHTML = `
            <div class="card widget-card" data-target-section="detalle-contratos_activos-table-section">
                <div class="card-header header-primary">
                    <h5 class="card-title"><i class="fas fa-file-contract icon-margin"></i>Contratos Activos</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.contratosActivos || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-section="detalle-monto_total_invertido-chart-section">
                <div class="card-header header-info">
                    <h5 class="card-title"><i class="fas fa-wallet icon-margin"></i>Monto Total Invertido</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">S/ ${formatCurrency(data.summary.montoTotalInvertido)}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-section="detalle-proximos_pagos-table-section">
                <div class="card-header header-warning">
                    <h5 class="card-title"><i class="fas fa-calendar-alt icon-margin"></i>Próximos Pagos Pendientes</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.proximosPagosPendientes || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-section="detalle-pagos_hoy-table-section">
                <div class="card-header header-success">
                    <h5 class="card-title"><i class="fas fa-money-bill-wave icon-margin"></i>Pagos Realizados Hoy</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.pagosHoy || 0}</p>
                </div>
            </div>
            
            <div class="card widget-card" data-target-section="detalle-pagos_ayer-table-section">
                <div class="card-header header-success">
                    <h5 class="card-title"><i class="fas fa-calendar-day icon-margin"></i>Pagos Realizados Ayer</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">S/ ${formatCurrency(data.summary.pagosAyer)}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-section="detalle-pagos_semana_actual-table-section">
                <div class="card-header header-success">
                    <h5 class="card-title"><i class="fas fa-calendar-week icon-margin"></i>Pagos Esta Semana</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">S/ ${formatCurrency(data.summary.pagosSemanaActual)}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-section="detalle-pagos_mes_actual-table-section">
                <div class="card-header header-success">
                    <h5 class="card-title"><i class="fas fa-calendar-alt icon-margin"></i>Pagos Este Mes</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">S/ ${formatCurrency(data.summary.pagosMesActual)}</p>
                </div>
            </div>

            <div class="card widget-card" data-target-section="detalle-leads_en_proceso-table-section">
                <div class="card-header header-secondary">
                    <h5 class="card-title"><i class="fas fa-handshake icon-margin"></i>Leads en Proceso</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.leadsEnProceso || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-section="detalle-contratos_por_vencer-table-section">
                <div class="card-header header-danger">
                    <h5 class="card-title"><i class="fas fa-hourglass-end icon-margin"></i>Contratos por Vencer</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.contratosPorVencer || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-section="detalle-colaboradores_activos-table-section">
                <div class="card-header header-info">
                    <h5 class="card-title"><i class="fas fa-user-tie icon-margin"></i>Colaboradores Activos</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.colaboradoresActivos || 0}</p>
                </div>
            </div>
        `;

        document.querySelectorAll('.widget-card').forEach(card => {
            card.addEventListener('click', () => {
                const targetSectionId = card.dataset.targetSection;
                toggleDetailSection(targetSectionId, card, data);
            });
        });
    };

    const fillTable = (tableBodyId, items, columns) => {
        const tableBody = document.getElementById(tableBodyId);
        if (!tableBody) return;

        tableBody.innerHTML = '';
        if (!items || items.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="${columns.length}" style="text-align: center; padding: 15px; color: #777;">No data available.</td></tr>`;
            return;
        }
        items.forEach(item => {
            const row = document.createElement('tr');
            columns.forEach(col => {
                let value = item[col.key];
                if (col.format) {
                    value = col.format(value === undefined || value === null ? 0 : value);
                }
                row.innerHTML += `<td>${value || 'N/A'}</td>`;
            });
            tableBody.appendChild(row);
        });
    };

    const renderMontoTotalInvertidoChart = (contratosData) => {
        let canvas = document.getElementById('montoTotalInvertidoChart');
        const chartContainer = canvas ? canvas.closest('.chart-container') : null;

        if (!chartContainer) {
            console.error("Chart container 'montoTotalInvertidoChart' not found.");
            return;
        }

        if (montoTotalInvertidoChartInstance) {
            montoTotalInvertidoChartInstance.destroy();
            montoTotalInvertidoChartInstance = null;
        }

        if (!contratosData || contratosData.length === 0) {
            chartContainer.innerHTML = '<p class="text-center py-4 text-gray-500">No hay datos de contratos activos para mostrar el gráfico de monto invertido.</p>';
            if (canvas) {
                canvas.remove();
            }
            return;
        } else {
            if (!canvas || chartContainer.querySelector('p.text-gray-500')) {
                chartContainer.innerHTML = '';
                const newCanvas = document.createElement('canvas');
                newCanvas.id = 'montoTotalInvertidoChart';
                chartContainer.appendChild(newCanvas);
                canvas = newCanvas;
            }
        }
        
        const dataByYear = {};
        let totalInvestedAmount = 0;
        contratosData.forEach(item => {
            const year = new Date(item.fecha_inicio).getFullYear();
            const monto = parseFloat(item.monto_invertido || 0);
            if (!isNaN(monto)) {
                dataByYear[year] = (dataByYear[year] || 0) + monto;
                totalInvestedAmount += monto;
            }
        });

        const sortedYears = Object.keys(dataByYear).sort((a, b) => parseInt(a) - parseInt(b));
        const labels = sortedYears.map(year => `Año ${year}`);
        const dataValues = sortedYears.map(year => dataByYear[year]);

        montoTotalInvertidoChartInstance = new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monto Total Invertido (S/)',
                    data: dataValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(240, 102, 47)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(235, 54, 54)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(235, 54, 54)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto (S/)'
                        },
                        ticks: {
                            callback: function(value) {
                                return `S/ ${formatCurrency(value)}`;
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Año'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: `Evolución del Monto Total Invertido por Año (Total: S/ ${formatCurrency(totalInvestedAmount)})`
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += `S/ ${formatCurrency(context.parsed.y)}`;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    };

    const renderDetailSections = (data) => {
        if (!data || !data.details || Object.keys(data.details).length === 0) {
            console.warn("No detail data available to render sections.");
            return;
        }

        fillTable('detalle-contratos_activos-table-body', data.details.contratosActivos, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_invertido', format: (val) => `S/ ${formatCurrency(val)}` },
            { key: 'fecha_inicio' },
            { key: 'fecha_fin' }
        ]);

        fillTable('detalle-proximos_pagos-table-body', data.details.proximosPagos, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'numero_cuota' },
            { key: 'monto_cuota', format: (val) => `S/ ${formatCurrency(val)}` },
            { key: 'fecha_vencimiento' }
        ]);

        fillTable('detalle-leads_en_proceso-table-body', data.details.leadsEnProceso, [
            { key: 'nombre_lead' },
            { key: 'telefono_lead' },
            { key: 'asesor_asignado_nombre' },
            { key: 'estado_lead' }
        ]);

        fillTable('detalle-contratos_por_vencer-table-body', data.details.contratosPorVencer, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_invertido', format: (val) => `S/ ${formatCurrency(val)}` },
            { key: 'fecha_vencimiento' }
        ]);

        fillTable('detalle-colaboradores_activos-table-body', data.details.colaboradoresActivos, [
            { key: 'nombre_colaborador' },
            { key: 'dni_colaborador' },
            { key: 'rol_colaborador' }
        ]);

        fillTable('detalle-pagos_hoy-table-body', data.details.pagosHoy, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_pagado', format: (val) => `S/ ${formatCurrency(val)}` }, 
            { key: 'fecha_hora_pago' }
        ]);

        fillTable('detalle-pagos_ayer-table-body', data.details.pagosAyer, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_pagado', format: (val) => `S/ ${formatCurrency(val)}` },
            { key: 'fecha_hora_pago' }
        ]);

        fillTable('detalle-pagos_semana_actual-table-body', data.details.pagosSemanaActual, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_pagado', format: (val) => `S/ ${formatCurrency(val)}` },
            { key: 'fecha_hora_pago' }
        ]);

        fillTable('detalle-pagos_mes_actual-table-body', data.details.pagosMesActual, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_pagado', format: (val) => `S/ ${formatCurrency(val)}` },
            { key: 'fecha_hora_pago' }
        ]);
    };

    const toggleDetailSection = (sectionId, clickedCard, allDashboardData) => {
        const detalleTablasTitulo = document.getElementById('detalle-tablas-titulo');
        const detalleTablasContainer = document.getElementById('detalle-tablas-container');

        document.querySelectorAll('.detalle-table-section, .detalle-chart-section').forEach(section => {
            section.style.display = 'none';
        });
        document.querySelectorAll('.widget-card').forEach(card => {
            card.classList.remove('active-card');
        });

        if (montoTotalInvertidoChartInstance) {
            montoTotalInvertidoChartInstance.destroy();
            montoTotalInvertidoChartInstance = null;
        }

        if (activeSectionId === sectionId) {
            detalleTablasTitulo.style.display = 'none';
            detalleTablasContainer.style.display = 'none';
            activeSectionId = null;
        } else {
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.style.display = 'block';
                detalleTablasTitulo.style.display = 'block';
                detalleTablasContainer.style.display = 'grid';

                const existingTotalParagraph = targetSection.querySelector('.total-amount-display');
                if (existingTotalParagraph) {
                    existingTotalParagraph.remove();
                }

                let totalValue = "0.00"; 
                let titleText = "";
                let isCurrency = true; 

                if (sectionId === 'detalle-pagos_hoy-table-section') {
                    
                    const sumHoy = allDashboardData.details.pagosHoy.reduce((sum, item) => sum + parseFloat(item.monto_pagado || 0), 0);
                    totalValue = sumHoy.toFixed(2); 
                    titleText = "Monto Total Pagado Hoy";
                    isCurrency = true; 
                } else if (sectionId === 'detalle-pagos_ayer-table-section') {
                    totalValue = allDashboardData.summary.pagosAyer;
                    titleText = "Total Pagado Ayer";
                    isCurrency = true;
                } else if (sectionId === 'detalle-pagos_semana_actual-table-section') {
                    totalValue = allDashboardData.summary.pagosSemanaActual;
                    titleText = "Total Pagado Esta Semana";
                    isCurrency = true;
                } else if (sectionId === 'detalle-pagos_mes_actual-table-section') {
                    totalValue = allDashboardData.summary.pagosMesActual;
                    titleText = "Total Pagado Este Mes";
                    isCurrency = true;
                }

                if (sectionId.startsWith('detalle-pagos_') && parseFloat(totalValue) !== 0) { 
                    const totalParagraph = document.createElement('p');
                    totalParagraph.classList.add('total-amount-display');
                    totalParagraph.style.cssText = `
                        text-align: center;
                        font-size: 1.2em;
                        font-weight: bold;
                        color:rgb(255, 51, 0);
                        margin: 20px 0 15px 0;
                        padding: 10px;
                        border: 1px solid #007bff;
                        border-radius: 8px;
                        background-color: #e7f3ff;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    `;
                    totalParagraph.innerHTML = `<strong>${titleText}:</strong> S/ ${formatCurrency(totalValue)}`;
                    targetSection.querySelector('.card-body').prepend(totalParagraph);
                }

                if (sectionId === 'detalle-monto_total_invertido-chart-section') {
                    renderMontoTotalInvertidoChart(allDashboardData.details.contratosActivos);
                }

                clickedCard.classList.add('active-card');
                activeSectionId = sectionId;
                
                detalleTablasTitulo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    };

    const showInitialAlerts = (summaryData) => {
        let alertMessage = "";
        let showWarning = false;

        if (summaryData.contratosPorVencer > 0) {
            alertMessage += `¡ATENCIÓN! Hay <span style="font-weight: bold; color: #dc3545;">${summaryData.contratosPorVencer}</span> contrato(s) por vencer pronto.`;
            showWarning = true;
        }

        if (summaryData.proximosPagosPendientes > 0) {
            if (alertMessage !== "") alertMessage += "<br><br>";
            alertMessage += `Tienes <span style="font-weight: bold; color: #ffc107;">${summaryData.proximosPagosPendientes}</span> pago(s) pendiente(s) próximo(s) a vencer.`;
            showWarning = true;
        }

        if (showWarning) {
            Swal.fire({
                icon: 'warning',
                title: 'Notificaciones Importantes',
                html: alertMessage,
                confirmButtonText: 'Ver Detalles',
                showCancelButton: true,
                cancelButtonText: 'Entendido',
                customClass: {
                    container: 'alert-container-class',
                    popup: 'alert-popup-class',
                    confirmButton: 'alert-confirm-button',
                    cancelButton: 'alert-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const dataToPass = initialDashboardData;
                    if (summaryData.contratosPorVencer > 0) {
                        const card = document.querySelector('.widget-card[data-target-section="detalle-contratos_por_vencer-table-section"]');
                        if (card) toggleDetailSection('detalle-contratos_por_vencer-table-section', card, dataToPass);
                    } else if (summaryData.proximosPagosPendientes > 0) {
                        const card = document.querySelector('.widget-card[data-target-section="detalle-proximos_pagos-table-section"]');
                        if (card) toggleDetailSection('detalle-proximos_pagos-table-section', card, dataToPass);
                    }
                }
            });
        }
    };

    const exportTableToPdf = (tableBodyId, title, totalAmountToExport = null, isCount = false) => {
        const tableBody = document.getElementById(tableBodyId);
        if (!tableBody) {
            Swal.fire({
                icon: 'error',
                title: 'Export Error',
                text: 'Table not found for export.'
            });
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'letter');

        const headers = Array.from(tableBody.previousElementSibling.querySelectorAll('th')).map(th => th.innerText);

        const data = [];
        const noDataRow = tableBody.querySelector('tr td[colspan]');
        if (noDataRow && noDataRow.innerText.includes("No data available")) {
            Swal.fire({
                icon: 'info',
                title: 'Empty Table',
                text: 'No data to export in this table.'
            });
            return;
        }

        Array.from(tableBody.children).forEach(row => {
            const rowData = [];
            Array.from(row.children).forEach(cell => {
                rowData.push(cell.innerText);
            });
            data.push(rowData);
        });

        let currentY = 40;
        doc.setFontSize(16);
        doc.text(title.replace(/_/g, ' '), 40, currentY);
        currentY += 20;

        if (totalAmountToExport !== null) {
            doc.setFontSize(12);
            doc.setTextColor(0, 123, 255);
            let displayText = '';
            if (isCount) {
                displayText = `Cantidad Total: ${totalAmountToExport}`;
            } else {
                displayText = `Monto Total: S/ ${formatCurrency(totalAmountToExport)}`;
            }
            doc.text(displayText, 40, currentY);
            currentY += 20;
            doc.setTextColor(30, 30, 30);
        }

        doc.autoTable({
            startY: currentY + 10,
            head: [headers],
            body: data,
            theme: 'striped',
            styles: {
                font: 'helvetica',
                fontSize: 9,
                cellPadding: 4,
                textColor: [30, 30, 30],
                lineColor: [200, 200, 200],
                lineWidth: 0.5
            },
            headStyles: {
                fillColor: [52, 152, 219],
                textColor: [255, 255, 255],
                fontStyle: 'bold'
            },
            alternateRowStyles: {
                fillColor: [240, 240, 240]
            },
            margin: { top: currentY + 10 }
        });

        doc.save(`${title}.pdf`);
    };

    let initialDashboardData = null;

    const loadDashboard = async () => {
        initialDashboardData = await fetchDashboardData();
        if (initialDashboardData) {
            renderSummaryWidgets(initialDashboardData);
            renderDetailSections(initialDashboardData);

            document.getElementById('detalle-tablas-titulo').style.display = 'none';
            document.getElementById('detalle-tablas-container').style.display = 'none';

            showInitialAlerts(initialDashboardData.summary);

            document.querySelectorAll('.btn-export-pdf').forEach(button => {
                button.addEventListener('click', function() {
                    const tableId = this.dataset.tableId;
                    const title = this.dataset.title;
                    let totalAmount = null;
                    let isCount = false;

                    if (tableId === 'detalle-pagos_hoy-table-body') {
                        
                        const sumHoy = initialDashboardData.details.pagosHoy.reduce((sum, item) => sum + parseFloat(item.monto_pagado || 0), 0);
                        totalAmount = sumHoy.toFixed(2);
                        isCount = false; // It's a sum of amounts, not a count of payments
                    } else if (tableId === 'detalle-pagos_ayer-table-body') {
                        totalAmount = initialDashboardData.summary.pagosAyer;
                        isCount = false;
                    } else if (tableId === 'detalle-pagos_semana_actual-table-body') {
                        totalAmount = initialDashboardData.summary.pagosSemanaActual;
                        isCount = false;
                    } else if (tableId === 'detalle-pagos_mes_actual-table-body') {
                        totalAmount = initialDashboardData.summary.pagosMesActual;
                        isCount = false;
                    }
                    exportTableToPdf(tableId, title, totalAmount, isCount);
                });
            });
        }
    };

    loadDashboard();
});
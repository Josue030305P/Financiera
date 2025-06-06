document.addEventListener('DOMContentLoaded', () => {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";

    const fetchDashboardData = async () => {
        try {
            const response = await fetch(`${baseUrl}app/controllers/DashboardController.php`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Error fetching dashboard data:", error);
            return null;
        }
    };

    const renderSummaryWidgets = (data) => {
        const summaryWidgetsGrid = document.getElementById('dashboard-summary-widgets');
        if (!summaryWidgetsGrid || !data || !data.summary) return;

        summaryWidgetsGrid.innerHTML = `
            <div class="card widget-card" data-target-table="detalle-contratos_activos-table-section">
                <div class="card-header header-primary">
                    <h5 class="card-title"><i class="fas fa-file-contract icon-margin"></i>Contratos Activos</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.contratosActivos || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-table="detalle-monto_total_invertido-table-section">
                <div class="card-header header-info">
                    <h5 class="card-title"><i class="fas fa-wallet icon-margin"></i>Monto Total Invertido</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">S/ ${parseFloat(data.summary.montoTotalInvertido || 0).toFixed(2)}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-table="detalle-proximos_pagos-table-section">
                <div class="card-header header-warning">
                    <h5 class="card-title"><i class="fas fa-calendar-alt icon-margin"></i>Próximos Pagos Pendientes</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.proximosPagosPendientes || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-table="detalle-pagos_hoy-table-section">
                <div class="card-header header-success">
                    <h5 class="card-title"><i class="fas fa-money-bill-wave icon-margin"></i>Pagos Realizados Hoy</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">S/ ${parseFloat(data.summary.pagosHoy || 0).toFixed(2)}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-table="detalle-leads_en_proceso-table-section">
                <div class="card-header header-secondary">
                    <h5 class="card-title"><i class="fas fa-handshake icon-margin"></i>Leads en Proceso</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.leadsEnProceso || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-table="detalle-contratos_por_vencer-table-section">
                <div class="card-header header-danger">
                    <h5 class="card-title"><i class="fas fa-hourglass-end icon-margin"></i>Contratos por Vencer</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.contratosPorVencer || 0}</p>
                </div>
            </div>
            <div class="card widget-card" data-target-table="detalle-colaboradores_activos-table-section">
                <div class="card-header header-info">
                    <h5 class="card-title"><i class="fas fa-user-tie icon-margin"></i>Colaboradores Activos</h5>
                </div>
                <div class="card-body text-center">
                    <p class="widget-value">${data.summary.colaboradoresActivos || 0}</p>
                </div>
            </div>
        `;

        // Añadir event listeners a los nuevos widgets
        document.querySelectorAll('.widget-card').forEach(card => {
            card.addEventListener('click', () => {
                const targetTableId = card.dataset.targetTable;
                showDetailTable(targetTableId);
            });
        });
    };

    const renderDetailTables = (data) => {
        const detalleTablasTitulo = document.getElementById('detalle-tablas-titulo');
        const detalleTablasContainer = document.getElementById('detalle-tablas-container');

        // Ocultar todas las tablas al inicio
        document.querySelectorAll('.detalle-table-section').forEach(section => {
            section.style.display = 'none';
        });

        if (!data || !data.details || Object.keys(data.details).length === 0) {
            detalleTablasTitulo.style.display = 'none';
            detalleTablasContainer.style.display = 'none';
            return;
        }

        const fillTable = (tableBodyId, items, columns) => {
            const tableBody = document.getElementById(tableBodyId);
            if (!tableBody) return;
            tableBody.innerHTML = '';
            if (!items || items.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="${columns.length}" style="text-align: center; padding: 15px;">No hay datos disponibles.</td></tr>`;
                return;
            }
            items.forEach(item => {
                const row = document.createElement('tr');
                columns.forEach(col => {
                    let value = item[col.key];
                    if (col.format) {
                        value = col.format(value);
                    }
                    row.innerHTML += `<td>${value || 'N/A'}</td>`;
                });
                tableBody.appendChild(row);
            });
        };

        fillTable('detalle-contratos_activos-table-body', data.details.contratosActivos, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_invertido', format: (val) => `S/ ${parseFloat(val).toFixed(2)}` },
            { key: 'fecha_inicio' },
            { key: 'fecha_fin' }
        ]);

        fillTable('detalle-monto_total_invertido-table-body', data.details.montoTotalInvertido, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_invertido', format: (val) => `S/ ${parseFloat(val).toFixed(2)}` },
            { key: 'fecha_inicio' },
            { key: 'fecha_fin' }
        ]);

        fillTable('detalle-proximos_pagos-table-body', data.details.proximosPagos, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'numero_cuota' },
            { key: 'monto_cuota', format: (val) => `S/ ${parseFloat(val).toFixed(2)}` },
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
            { key: 'monto_invertido', format: (val) => `S/ ${parseFloat(val).toFixed(2)}` },
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
            { key: 'monto_pagado', format: (val) => `S/ ${parseFloat(val).toFixed(2)}` },
            { key: 'fecha_hora_pago' }
        ]);
    };

    const showDetailTable = (tableId) => {
        const detalleTablasTitulo = document.getElementById('detalle-tablas-titulo');
        const detalleTablasContainer = document.getElementById('detalle-tablas-container');

        // Ocultar todas las tablas de detalle primero
        document.querySelectorAll('.detalle-table-section').forEach(section => {
            section.style.display = 'none';
        });

        // Mostrar el título y el contenedor de tablas de detalle
        detalleTablasTitulo.style.display = 'block';
        detalleTablasContainer.style.display = 'grid'; 

        // Mostrar solo la tabla específica
        const targetTableSection = document.getElementById(tableId);
        if (targetTableSection) {
            targetTableSection.style.display = 'block';
        }
    };

    const loadDashboard = async () => {
        const data = await fetchDashboardData();
        if (data) {
            renderSummaryWidgets(data);
            renderDetailTables(data); 
        }
    };

    loadDashboard();
});
document.addEventListener('DOMContentLoaded', () => {

    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
    let activeTableSectionId = null; // Variable para rastrear la tabla actualmente abierta

    const fetchDashboardData = async () => {
        try {
            const response = await fetch(`${baseUrl}app/controllers/DashboardController.php`);
            if (!response.ok) {
                
                throw new Error(`Error HTTP! Estado: ${response.status} - ${response.statusText}`);
            }
            const apiResponse = await response.json(); // Parsea la respuesta JSON

            if (apiResponse && apiResponse.status === true && apiResponse.data) {
                // Transforma los datos de la API para un formato más fácil de usar en el frontend
                const transformedData = {
                    summary: {
                        contratosActivos: apiResponse.data.resumen.contratos_activos || 0,
                        montoTotalInvertido: apiResponse.data.resumen.monto_total_invertido || "0.00",
                        proximosPagosPendientes: apiResponse.data.resumen.proximos_pagos_cantidad || 0,
                        leadsEnProceso: apiResponse.data.resumen.leads_en_proceso || 0,
                        contratosPorVencer: apiResponse.data.resumen.contratos_por_vencer || 0,
                        colaboradoresActivos: apiResponse.data.resumen.colaboradores_activos || 0,
                        pagosHoy: apiResponse.data.resumen.total_pagos_hoy || "0.00"
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

                        // montoTotalInvertido usa los mismos datos que contratosActivos para esta vista de detalle
                        montoTotalInvertido: apiResponse.data.listados.contratos_activos.map(item => ({
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
                            idpago: item.idpago,
                            inversionista_nombre: `${item.inversionista_nombres} ${item.inversionista_apellidos}`,
                            inversionista_dni: item.inversionista_dni,
                            monto_pagado: item.monto_pagado,
                            fecha_hora_pago: item.fecha_hora_pago
                        }))
                    }
                };
                return transformedData;
            } else {
                console.error("Formato de datos de dashboard inesperado o status falso:", apiResponse);
                return null;
            }
        } catch (error) {
            console.error("Error al obtener datos del dashboard:", error);
            // Puedes mostrar una alerta al usuario si la carga inicial falla
            Swal.fire({
                icon: 'error',
                title: 'Error de carga',
                text: 'No se pudieron cargar los datos del dashboard. Inténtalo de nuevo más tarde.'
            });
            return null;
        }
    };

    const renderSummaryWidgets = (data) => {
        const summaryWidgetsGrid = document.getElementById('dashboard-summary-widgets');
        if (!summaryWidgetsGrid || !data || !data.summary) {
            console.warn("No hay datos de resumen para renderizar los widgets.");
            return;
        }

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
                    <p class="widget-value">${parseInt(data.summary.pagosHoy || 0)}</p>
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
                toggleDetailTable(targetTableId, card);
            });
        });
    };

    const fillTable = (tableBodyId, items, columns) => {
        const tableBody = document.getElementById(tableBodyId);
        if (!tableBody) {
            console.warn(`Elemento con ID ${tableBodyId} no encontrado.`);
            return;
        }
        tableBody.innerHTML = ''; // Limpia el contenido actual de la tabla
        if (!items || items.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="${columns.length}" style="text-align: center; padding: 15px; color: #777;">No hay datos disponibles.</td></tr>`;
            return;
        }
        items.forEach(item => {
            const row = document.createElement('tr');
            columns.forEach(col => {
                let value = item[col.key];
                if (col.format) {
                    // Asegura que parseFloat reciba un número válido o un 0 si es undefined/null
                    value = col.format(value === undefined || value === null ? 0 : value);
                }
                row.innerHTML += `<td>${value || 'N/A'}</td>`;
            });
            tableBody.appendChild(row);
        });
    };

    const renderDetailTables = (data) => {
        if (!data || !data.details || Object.keys(data.details).length === 0) {
            console.warn("No hay datos de detalle disponibles para renderizar las tablas.");
            return;
        }

        // Detalle de Contratos Activos
        fillTable('detalle-contratos_activos-table-body', data.details.contratosActivos, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_invertido', format: (val) => `S/ ${parseFloat(val || 0).toFixed(2)}` },
            { key: 'fecha_inicio' },
            { key: 'fecha_fin' }
        ]);

        // Detalle de Monto Total Invertido (usa los mismos datos que contratos activos)
        fillTable('detalle-monto_total_invertido-table-body', data.details.montoTotalInvertido, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_invertido', format: (val) => `S/ ${parseFloat(val || 0).toFixed(2)}` },
            { key: 'fecha_inicio' },
            { key: 'fecha_fin' }
        ]);

        // Detalle de Próximos Pagos Pendientes
        fillTable('detalle-proximos_pagos-table-body', data.details.proximosPagos, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'numero_cuota' },
            { key: 'monto_cuota', format: (val) => `S/ ${parseFloat(val || 0).toFixed(2)}` },
            { key: 'fecha_vencimiento' }
        ]);

        // Detalle de Leads en Proceso
        fillTable('detalle-leads_en_proceso-table-body', data.details.leadsEnProceso, [
            { key: 'nombre_lead' },
            { key: 'telefono_lead' },
            { key: 'asesor_asignado_nombre' },
            { key: 'estado_lead' }
        ]);

        // Detalle de Contratos por Vencer
        fillTable('detalle-contratos_por_vencer-table-body', data.details.contratosPorVencer, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_invertido', format: (val) => `S/ ${parseFloat(val || 0).toFixed(2)}` },
            { key: 'fecha_vencimiento' }
        ]);

        // Detalle de Colaboradores Activos
        fillTable('detalle-colaboradores_activos-table-body', data.details.colaboradoresActivos, [
            { key: 'nombre_colaborador' },
            { key: 'dni_colaborador' },
            { key: 'rol_colaborador' }
        ]);

        // Detalle de Pagos Realizados Hoy
        fillTable('detalle-pagos_hoy-table-body', data.details.pagosHoy, [
            { key: 'inversionista_nombre' },
            { key: 'inversionista_dni' },
            { key: 'monto_pagado', format: (val) => `S/ ${parseFloat(val || 0).toFixed(2)}` },
            { key: 'fecha_hora_pago' }
        ]);
    };

    // Función para alternar la visibilidad de las tablas de detalle
    const toggleDetailTable = (tableId, clickedCard) => {
        const detalleTablasTitulo = document.getElementById('detalle-tablas-titulo');
        const detalleTablasContainer = document.getElementById('detalle-tablas-container');
        const targetTableSection = document.getElementById(tableId);

        // Ocultar todas las secciones de tabla de detalle y quitar la clase 'active' de todos los cards
        document.querySelectorAll('.detalle-table-section').forEach(section => {
            section.style.display = 'none';
        });
        document.querySelectorAll('.widget-card').forEach(card => {
            card.classList.remove('active-card');
        });

        if (activeTableSectionId === tableId) {
            // Si se hace clic en el mismo card, ocultar el título y el contenedor, y limpiar el estado activo
            detalleTablasTitulo.style.display = 'none';
            detalleTablasContainer.style.display = 'none';
            activeTableSectionId = null;
        } else {
            // Mostrar la tabla objetivo y establecer el estado activo
            if (targetTableSection) {
                targetTableSection.style.display = 'block';
                detalleTablasTitulo.style.display = 'block';
                detalleTablasContainer.style.display = 'grid'; // Asegura que el contenedor se muestre como grid
                clickedCard.classList.add('active-card'); // Añadir clase 'active' al card
                activeTableSectionId = tableId; // Establecer la tabla activa
                // Desplazarse suavemente a la sección de tablas
                detalleTablasTitulo.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    };

    // Función para mostrar alertas iniciales al cargar la aplicación
    const showInitialAlerts = (summaryData) => {
        let alertMessage = "";
        let showWarning = false;

        // Alerta para Contratos por Vencer
        if (summaryData.contratosPorVencer > 0) {
            alertMessage += `¡ATENCIÓN! Hay <span style="font-weight: bold; color: #dc3545;">${summaryData.contratosPorVencer}</span> contrato(s) por vencer pronto.`;
            showWarning = true;
        }

        // Alerta para Próximos Pagos Pendientes
        if (summaryData.proximosPagosPendientes > 0) {
            if (alertMessage !== "") alertMessage += "<br><br>"; // Nueva línea si ya hay un mensaje
            alertMessage += `Tienes <span style="font-weight: bold; color: #ffc107;">${summaryData.proximosPagosPendientes}</span> pago(s) pendiente(s) próximo(s) a vencer.`;
            showWarning = true;
        }

        if (showWarning) {
            Swal.fire({
                icon: 'warning',
                title: 'Notificaciones Importantes',
                html: alertMessage, // SweetAlert2 interpreta <br> en 'html'
                confirmButtonText: 'Ver Detalles',
                showCancelButton: true,
                cancelButtonText: 'Entendido',
                customClass: {
                    container: 'alert-container-class', // Clase CSS opcional para el contenedor
                    popup: 'alert-popup-class',         // Clase CSS opcional para el popup
                    confirmButton: 'alert-confirm-button', // Clase CSS opcional para el botón de confirmar
                    cancelButton: 'alert-cancel-button'   // Clase CSS opcional para el botón de cancelar
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Decide a qué sección llevar al usuario
                    // Prioridad: Contratos por Vencer > Próximos Pagos Pendientes
                    if (summaryData.contratosPorVencer > 0) {
                        const card = document.querySelector('.widget-card[data-target-table="detalle-contratos_por_vencer-table-section"]');
                        if (card) toggleDetailTable('detalle-contratos_por_vencer-table-section', card);
                    } else if (summaryData.proximosPagosPendientes > 0) {
                        const card = document.querySelector('.widget-card[data-target-table="detalle-proximos_pagos-table-section"]');
                        if (card) toggleDetailTable('detalle-proximos_pagos-table-section', card);
                    }
                }
            });
        }
    };

    // Función para exportar la tabla a PDF
    const exportTableToPdf = (tableBodyId, title) => {
        const tableBody = document.getElementById(tableBodyId);
        if (!tableBody) {
            Swal.fire({
                icon: 'error',
                title: 'Error de exportación',
                text: 'No se encontró la tabla para exportar.'
            });
            return;
        }

        const { jsPDF } = window.jspdf; // Obtener jsPDF del objeto global
        const doc = new jsPDF('p', 'pt', 'letter'); // 'p' para retrato, 'pt' para puntos, 'letter' tamaño de papel

        // Obtener encabezados de la tabla (asumiendo que están en el thead justo antes del tbody)
        const headers = Array.from(tableBody.previousElementSibling.querySelectorAll('th')).map(th => th.innerText);

        // Obtener datos de la tabla (tbody)
        const data = [];
        // Verificar si la tabla tiene el mensaje de "No hay datos disponibles"
        const noDataRow = tableBody.querySelector('tr td[colspan]');
        if (noDataRow && noDataRow.innerText.includes("No hay datos disponibles")) {
            Swal.fire({
                icon: 'info',
                title: 'Tabla Vacía',
                text: 'No hay datos para exportar en esta tabla.'
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

        doc.setFontSize(16);
        doc.text(title.replace(/_/g, ' '), 40, 40); // Título del documento, reemplaza guiones bajos por espacios

        doc.autoTable({
            startY: 60, // Comienza la tabla debajo del título
            head: [headers],
            body: data,
            theme: 'striped', // Tema de la tabla (opcional: 'striped', 'grid', 'plain')
            styles: {
                font: 'helvetica',
                fontSize: 9, // Reducir un poco el tamaño de la fuente para más contenido
                cellPadding: 4,
                textColor: [30, 30, 30],
                lineColor: [200, 200, 200],
                lineWidth: 0.5
            },
            headStyles: {
                fillColor: [52, 152, 219], // Color de cabecera (azul)
                textColor: [255, 255, 255],
                fontStyle: 'bold'
            },
            alternateRowStyles: {
                fillColor: [240, 240, 240] // Color de filas alternas
            },
            margin: { top: 50 } // Margen para la tabla, si necesitas más espacio
        });

        doc.save(`${title}.pdf`); // Descargar el PDF con el título proporcionado
    };


    const loadDashboard = async () => {
        const data = await fetchDashboardData();
        if (data) {
            renderSummaryWidgets(data);
            renderDetailTables(data);

            // Ocultar las tablas de detalle y el título al cargar la página inicialmente
            document.getElementById('detalle-tablas-titulo').style.display = 'none';
            document.getElementById('detalle-tablas-container').style.display = 'none';

            // Mostrar alertas iniciales
            showInitialAlerts(data.summary);

            // Añadir event listeners para los botones de exportar PDF después de que se rendericen las tablas
            document.querySelectorAll('.btn-export-pdf').forEach(button => {
                button.addEventListener('click', function() {
                    const tableId = this.dataset.tableId;
                    const title = this.dataset.title;
                    exportTableToPdf(tableId, title);
                });
            });
        }
    };

    loadDashboard();
});
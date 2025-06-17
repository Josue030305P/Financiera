class DataTable {
    constructor(options) {
        this.tableId = options.tableId;
        this.apiUrl = options.apiUrl;
        this.tipo = options.tipo;
        this.columnas = options.columnas;
        this.mapeo = options.mapeo;
        this.baseUrl = options.baseUrl;
        this.idField = options.idField || "id";
        this.customRenderers = options.customRenderers || {};
        this.dataOriginal = [];
        this.modalCronograma = document.getElementById("modal-cronograma");
        this.modalCronogramaBody = document.getElementById("modal-cronograma-body");
        this.modalContratoIdSpan = document.getElementById("modal-contrato-id");

        window.dataTable = this;

        this.init();
    }

    init() {
        this.cargarDatos();
        this.initEventListeners();
        this.initHeader();
        this.initModalEventListeners();

        if (this.tipo === "leads") {
            this.initLeadFilterEventListeners();
        } else if (this.tipo === "contratos") {
            this.initContratoFilterEventListeners();
        }
    }

    initHeader() {
        const tableHeader = document.querySelector(".table-header");
        if (tableHeader && this.tipo === "contratos") {
            const nuevoButton = tableHeader.querySelector(".create-lead");
            if (nuevoButton) {
                nuevoButton.href =
                    this.links && this.links[this.tipo] ? this.links[this.tipo] : "#";
                nuevoButton.textContent = `+ Nuevo ${this.tipo}`;
            }
        }
    }

    initModalEventListeners() {
        if (this.modalCronograma) {
            const closeModalButton =
                this.modalCronograma.querySelector(".close-button");
            const modalContent = this.modalCronograma.querySelector(".modal-content"); 

            if (closeModalButton) {
                closeModalButton.addEventListener("click", () => {
                    this.modalCronograma.style.display = "none";
                });
            }
            window.addEventListener("click", (event) => {
                if (event.target == this.modalCronograma) {
                    this.modalCronograma.style.display = "none";
                }
            });
            if (modalContent) {
                modalContent.addEventListener("click", (event) => {
                    event.stopPropagation();
                });
            }
        }
    }

    async cargarDatos() {
        try {
            const response = await fetch(`${this.baseUrl}app/${this.apiUrl}`);
            const data = await response.json();
            this.dataOriginal = [...data];
            this.renderizarTabla(data);

            if (this.tipo === "leads") {
                this.popularFiltroAsesor();
            } else if (this.tipo === "contratos") {
                this.popularFiltroAsesorContratos();
            }
        } catch (error) {
            console.error("Error al cargar datos:", error);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error al cargar los datos",
                confirmButtonColor: "#3085d6",
            });
        }
    }

    renderizarTabla(data) {
        const tbody = document.querySelector(`#${this.tableId} tbody`);
        const thead = document.querySelector(`#${this.tableId} thead tr`);
        tbody.innerHTML = "";

        if (thead) {
            thead.className = "users-table-info";
            thead.querySelectorAll("th").forEach((th) => {
                th.style.fontWeight = "500";
                th.style.padding = "10px";
            });
        }

        if (data && Array.isArray(data)) {
            data.forEach((item) => {
                const row = document.createElement("tr");
                row.className = "users-table-row";
                row.dataset.id = item[this.idField];

                this.columnas.forEach((columna) => {
                    const td = document.createElement("td");
                    td.className = "td-item";
                    td.style.padding = "10px";

                    if (this.customRenderers[columna]) {
                        td.innerHTML = this.customRenderers[columna](item);
                    } else {
                        switch (columna) {
                            case "Prioridad":
                                const prioridad = this.obtenerValorCampo(item, columna);
                                const clasePrioridad =
                                    {
                                        Alto: "badge badge-active",
                                        Medio: "badge badge-pending",
                                        Bajo: "badge badge-trashed",
                                    }[prioridad] || "";
                                td.innerHTML = `<span class="${clasePrioridad}">${prioridad}</span>`;
                                break;
                            case "Estado":
                                const estado = this.obtenerValorCampo(item, columna);
                                let claseEstado = "";

                                if (this.tipo === "leads") {
                                    claseEstado =
                                        {
                                            "Nuevo contacto": "badge-info",
                                            "En proceso": "badge-pending",
                                            Inversionista: "badge-success",
                                            Inactivo: "badge-trashed",
                                        }[estado] || "";
                                } else if (this.tipo === "contactos") {
                                    claseEstado =
                                        {
                                            Realizado: "badge-active",
                                            Pendiente: "badge-pending",
                                            Reprogramado: "badge-trashed",
                                        }[estado] || "";
                                } else if (this.tipo === "contratos") {
                                    claseEstado =
                                        {
                                            Vigente: "badge-active",
                                            Completado: "badge-trashed",
                                        }[estado] || "";
                                } else {
                                    claseEstado = "badge-default";
                                }

                                td.innerHTML = `<span class="badge ${claseEstado}">${estado}</span>`;
                                break;
                            case "Acciones":
                                td.innerHTML = this.renderizarAcciones(item);
                                break;
                            case "Nº cuenta": // <--- Nuevo case para manejar "Nº cuenta"
                            case "CCI":      // <--- Nuevo case para manejar "CCI"
                            case "Entidad":  // <--- Nuevo case para manejar "Entidad"
                            case "Nombre de entidad": // <--- Nuevo case para manejar "Nombre de entidad"
                                // Usamos obtenerValorCampo para que muestre "NO ASIGNADO" si está vacío
                                td.textContent = this.obtenerValorCampo(item, columna);
                                break;
                            default:
                                td.textContent = this.obtenerValorCampo(item, columna);
                        }
                    }
                    row.appendChild(td);
                });

                tbody.appendChild(row);
            });
        } else {
            console.error(
                "Error: Los datos para renderizar la tabla no son un array o son undefined.",
                data
            );
            tbody.innerHTML = `<tr><td colspan="${this.columnas.length}" style="text-align: center; padding: 15px; color: #777;">No hay datos disponibles.</td></tr>`;
        }
    }

    obtenerValorCampo(item, columna) {
        const campo = this.mapeo[columna];
        // Si el campo es un array (para concatenar múltiples propiedades)
        if (Array.isArray(campo)) {
            // Filtra los valores nulos/undefined/vacíos antes de unirlos
            const valores = campo.map((c) => item[c]).filter(v => v !== undefined && v !== null && String(v).trim() !== "");
            return valores.length > 0 ? valores.join(" ") : "NO ASIGNADO";
        } 
        // Si el campo es una sola propiedad
        else if (campo && item[campo] !== undefined && item[campo] !== null && String(item[campo]).trim() !== "") {
            return item[campo];
        }
        // Si el campo no está definido en el mapeo, o el valor es undefined, null o una cadena vacía/espacios en blanco
        return "NO ASIGNADO";
    }

    renderizarAcciones(item) {
        let acciones = `<div class="actions">`;
        const id = item[this.idField];

        if (this.tipo === "leads") {
            if (item.puede_ser_inversionista) {
                acciones += `
                    <a href="${this.baseUrl}app/views/${this.tipo}/${this.tipo}.update.php?id=${id}" class="action-button" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                `;
            }
            acciones += `
                <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;" class="action-button" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a href="${this.baseUrl}app/views/contactibilidad/contacto.add?idlead=${id}" class="action-button" title="Contactibilidad">
                    <i class="fas fa-user-plus"></i>
                </a>
            `;
        }

        if (this.tipo === "contratos") {
            acciones += `
                <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;" class="action-button" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a href="#" class="action-button ver-cronograma-modal" style="cursor: pointer;" data-contrato-id="${id}" title="Ver Cronograma">
                    <i class="fas fa-calendar-alt"></i>
                </a>
                <a href="${this.baseUrl}app/views/contratos/generar-pdf.php?idcontrato=${id}" target="_blank" class="action-button" title="Generar PDF">
                    <i class="fas fa-file-pdf"></i>
                </a>
                <a href="${this.baseUrl}app/views/numcuentas/numcuenta.add.php?idcontrato=${id}" class="action-button" title="Asociar número de cuenta">
                    <i class="fas fa-credit-card"></i>
                </a>
                <a href="${this.baseUrl}app/views/detallegarantias/detallegarantias.add.php?idcontrato=${id}" class="action-button" title="Asociar garantía">
                    <i class="fas fa-shield-alt"></i>
                </a>
            `;
        }

        if (this.tipo === "contactos") {
            acciones += `
                <a href="${this.baseUrl}app/views/contactibilidad/contactos.update.php?id=${id}" class="action-button" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;" class="action-button" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                </a>
            `;
        }

        if (this.tipo === "Inversionistas") {
            acciones += `
                
                <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;" class="action-button" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                </a>
            `;
        }

        acciones += `</div>`;
        return acciones;
    }

    async confirmarEliminacion(id) {
        const result = await Swal.fire({
            title: "¿Eliminar?",
            text: `¿Estás seguro de que deseas eliminar este registro? ${id}`,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        });

        if (result.isConfirmed) {
            await this.eliminarRegistro(id);
        }
    }

    async eliminarRegistro(id) {
        try {
            const response = await fetch(
                `${this.baseUrl}app/${this.apiUrl}?id=${id}`, {
                    method: "DELETE"
                }
            );
            const result = await response.json();

            if (result.status === "success" || result.success == true) {
                await Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "Registro eliminado correctamente",
                    confirmButtonColor: "#3085d6",
                });
                this.cargarDatos();
            } else {
                await Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al eliminar: " + result.message,
                    confirmButtonColor: "#3085d6",
                });
            }
        } catch (error) {
            console.error("Error al eliminar:", error);
            await Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error al eliminar el registro",
                confirmButtonColor: "#3085d6",
            });
        }
    }

    initEventListeners() {
        const tableBody = document.querySelector(`#${this.tableId} tbody`);
        if (tableBody) {
            tableBody.addEventListener("click", (event) => {
                const target = event.target.closest(".ver-cronograma-modal");
                if (target) {
                    const contratoId = target.dataset.contratoId;
                    if (contratoId) {
                        event.stopPropagation();
                        this.abrirModalCronograma(contratoId);
                    }
                }
            });
        }
    }

    abrirModalCronograma(idContrato) {
        if (
            this.modalCronograma &&
            this.modalCronogramaBody &&
            this.modalContratoIdSpan
        ) {
            this.modalContratoIdSpan.textContent = idContrato;
            this.modalCronogramaBody.innerHTML = "<p>Cargando cronograma...</p>";
            this.modalCronograma.style.display = "flex"; 

            fetch(
                    `${this.baseUrl}app/controllers/CronogramaPago.Controller.php?idcontrato=${idContrato}`
                )
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    this.renderizarCronogramaEnModal(data.data);
                })
                .catch((error) => {
                    console.error("Error al cargar el cronograma:", error);
                    this.modalCronogramaBody.innerHTML =
                        "<p>Error al cargar el cronograma.</p>";
                });
        }
    }

    renderizarCronogramaEnModal(cronograma) {
        let tablaHTML = "<table>";
        tablaHTML +=
            "<thead><tr><th>Cuota #</th><th>Fecha de Pago</th><th>Total Bruto (S/)</th><th>Total Neto (S/)</th></tr></thead>";
        tablaHTML += "<tbody>";

        if (cronograma && cronograma.length > 0) {
            cronograma.forEach((pago) => {
                tablaHTML += `
                                <tr>
                                    <td>${pago.numcuota}</td>
                                    <td>${pago.fechavencimiento}</td>
                                    <td>${pago.totalbruto}</td>
                                    <td>${pago.totalneto}</td>
                                </tr>
                                `;
            });
        } else {
            tablaHTML +=
                '<tr><td colspan="4">No se encontraron pagos para este contrato.</td></tr>';
        }

        tablaHTML += "</tbody></table>";
        this.modalCronogramaBody.innerHTML = tablaHTML;
    }

    // ** FUNCIONES DE FILTRADO PARA LEADS - INTEGRADO **
    popularFiltroAsesor() {
        const filtroAsesorSelect = document.getElementById("filtro-asesor-lead");
        if (!filtroAsesorSelect) {
            console.warn("Elemento SELECT con ID 'filtro-asesor-lead' no encontrado.");
            return;
        }

        filtroAsesorSelect.innerHTML = '<option value="">Todos</option>';
        const asesoresUnicos = new Set();
        if (this.dataOriginal && Array.isArray(this.dataOriginal)) {
            this.dataOriginal.forEach(lead => {
                try {
                    const asesorNombre = this.obtenerValorCampo(lead, 'Asesor');
                    if (asesorNombre && asesorNombre !== "NO ASIGNADO" && asesorNombre.trim() !== "") {
                        asesoresUnicos.add(asesorNombre);
                    }
                } catch (e) {
                    console.error("Error al obtener asesor para el lead (ID:", lead.idlead, "):", e);
                }
            });
        }
        Array.from(asesoresUnicos).sort().forEach(asesor => {
            const option = document.createElement("option");
            option.value = asesor;
            option.textContent = asesor;
            filtroAsesorSelect.appendChild(option);
        });
    }

    filtrarLeads() {
        let datosFiltrados = [...this.dataOriginal];
        const filtroPrioridad = document.getElementById("filtro-estado-lead")?.value;
        const filtroAsesor = document.getElementById("filtro-asesor-lead")?.value;

        if (filtroPrioridad) {
            datosFiltrados = datosFiltrados.filter(lead => {
                const prioridadDelLead = this.obtenerValorCampo(lead, 'Prioridad');
                return prioridadDelLead && prioridadDelLead.toLowerCase() === filtroPrioridad.toLowerCase();
            });
        }
        if (filtroAsesor) {
            datosFiltrados = datosFiltrados.filter(lead => {
                const asesorDelLead = this.obtenerValorCampo(lead, 'Asesor');
                return asesorDelLead && asesorDelLead.toLowerCase() === filtroAsesor.toLowerCase();
            });
        }
        this.renderizarTabla(datosFiltrados);
    }

    resetearFiltrosLeads() {
        const filtroPrioridadSelect = document.getElementById("filtro-estado-lead");
        if (filtroPrioridadSelect) {
            filtroPrioridadSelect.value = "";
        }
        const filtroAsesorSelect = document.getElementById("filtro-asesor-lead");
        if (filtroAsesorSelect) {
            filtroAsesorSelect.value = "";
        }
        this.renderizarTabla(this.dataOriginal);
    }

    initLeadFilterEventListeners() {
        const aplicarFiltrosLeadBtn = document.getElementById("aplicar-filtros-lead");
        if (aplicarFiltrosLeadBtn) {
            aplicarFiltrosLeadBtn.addEventListener("click", this.filtrarLeads.bind(this));
        }
        const resetearFiltrosLeadBtn = document.getElementById("resetear-filtros-lead");
        if (resetearFiltrosLeadBtn) {
            resetearFiltrosLeadBtn.addEventListener("click", this.resetearFiltrosLeads.bind(this));
        }
    }

    // ** FUNCIONES DE FILTRADO PARA CONTRATOS - INTEGRADO **
    popularFiltroAsesorContratos() {
        const filtroAsesorContratoSelect = document.getElementById("filtro-asesor-contrato");
        if (!filtroAsesorContratoSelect) {
            console.warn("Elemento SELECT con ID 'filtro-asesor-contrato' no encontrado.");
            return;
        }

        filtroAsesorContratoSelect.innerHTML = '<option value="">Todos</option>';
        const asesoresUnicos = new Set();
        if (this.dataOriginal && Array.isArray(this.dataOriginal)) {
            this.dataOriginal.forEach(contrato => {
                try {
                    const asesorNombre = this.obtenerValorCampo(contrato, 'Asesor');
                    if (asesorNombre && asesorNombre !== "NO ASIGNADO" && asesorNombre.trim() !== "") {
                        asesoresUnicos.add(asesorNombre);
                    }
                } catch (e) {
                    console.error("Error al obtener asesor para el contrato (ID:", contrato.idcontrato, "):", e);
                }
            });
        }
        Array.from(asesoresUnicos).sort().forEach(asesor => {
            const option = document.createElement("option");
            option.value = asesor;
            option.textContent = asesor;
            filtroAsesorContratoSelect.appendChild(option);
        });
    }

    filtrarContratos() {
        let datosFiltrados = [...this.dataOriginal];
        const filtroVencimiento = document.getElementById("filtro-vencimiento")?.value;
        const filtroEstado = document.getElementById("filtro-estado")?.value;
        const filtroAsesorNombre = document.getElementById("filtro-asesor-contrato")?.value.trim().toLowerCase();
        const filtroDniInversionista = document.getElementById("filtro-dni-inversionista")?.value.trim().toLowerCase();
        const filtroAnio = document.getElementById("filtro-anio")?.value;

        if (filtroAsesorNombre) {
            datosFiltrados = datosFiltrados.filter(contrato => {
                const asesorDelContrato = this.obtenerValorCampo(contrato, 'Asesor');
                return asesorDelContrato && asesorDelContrato.toLowerCase().includes(filtroAsesorNombre);
            });
        }
        if (filtroDniInversionista) {
            datosFiltrados = datosFiltrados.filter(contrato => contrato['dniInver'] && contrato['dniInver'].toLowerCase().includes(filtroDniInversionista));
        }
        if (filtroVencimiento) {
            const hoy = new Date();
            let fechaFinComparacion;
            switch (filtroVencimiento) {
                case 'proximos_30_dias':
                    fechaFinComparacion = new Date(hoy);
                    fechaFinComparacion.setDate(hoy.getDate() + 30);
                    break;
                case 'proximos_60_dias':
                    fechaFinComparacion = new Date(hoy);
                    fechaFinComparacion.setDate(hoy.getDate() + 60);
                    break;
                case 'proximos_90_dias':
                    fechaFinComparacion = new Date(hoy);
                    fechaFinComparacion.setDate(hoy.getDate() + 90);
                    break;
                default:
                    fechaFinComparacion = null;
                    break;
            }
            if (fechaFinComparacion) {
                datosFiltrados = datosFiltrados.filter(contrato => {
                    const fechaFin = new Date(contrato['Fin']);
                    return fechaFin >= hoy && fechaFin <= fechaFinComparacion;
                });
            }
        }
        if (filtroEstado) {
            datosFiltrados = datosFiltrados.filter(contrato => contrato['Estado'] === filtroEstado);
        }
        if (filtroAnio) {
            datosFiltrados = datosFiltrados.filter(contrato => {
                const anioContrato = new Date(this.obtenerValorCampo(contrato, 'Inicio')).getFullYear();
                return String(anioContrato) === filtroAnio;
            });
        }
        this.renderizarTabla(datosFiltrados);
    }

    resetearFiltros() {
        Swal.fire({
            toast: true,
            position: "top-end",
            title: "Filtros",
            text: "¿Desea quitar los filtros?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí",
            cancelButtonText: "No",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("filtro-vencimiento").value = "";
                document.getElementById("filtro-estado").value = "";
                document.getElementById("filtro-asesor-contrato").value = ""; 
                document.getElementById("filtro-dni-inversionista").value = "";
                document.getElementById("filtro-anio").value = "";
                this.renderizarTabla(this.dataOriginal);
            }
        });
    }

    initContratoFilterEventListeners() {
        const aplicarFiltrosBtn = document.getElementById("aplicar-filtros");
        if (aplicarFiltrosBtn) {
            aplicarFiltrosBtn.addEventListener("click", this.filtrarContratos.bind(this));
        }
        const resetearFiltrosBtn = document.getElementById("resetear-filtros");
        if (resetearFiltrosBtn) {
            resetearFiltrosBtn.addEventListener("click", this.resetearFiltros.bind(this));
        }
    }
}
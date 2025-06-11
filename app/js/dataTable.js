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
            //console.log("Datos originales cargados en dataTable:", this.dataOriginal);
            this.renderizarTabla(data);
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
                                const prioridad = item[this.mapeo[columna]];
                                const clase =
                                    {
                                        Alto: "badge badge-active",
                                        Medio: " badge badge-pending",
                                        Bajo: "badge badge-trashed",
                                    }[prioridad] || "";
                                td.innerHTML = `<span class="${clase}">${prioridad}</span>`;
                                break;
                            case "Estado":
                                const estado = item[this.mapeo[columna]];
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
                                // Aquí se pasa el objeto completo 'item' a renderizarAcciones para que tenga acceso a 'item.puede_ser_inversionista'
                                td.innerHTML = this.renderizarAcciones(item);
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
        }
    }
    obtenerValorCampo(item, columna) {
        const campo = this.mapeo[columna];
        if (Array.isArray(campo)) {
            return campo.map((c) => item[c]).join(" ");
        } else if (campo) {
            return item[campo] || "NO ASIGNADO";
        }
        return "—";
    }

    renderizarAcciones(item) {
        
        let acciones = ``;
        const id = item[this.idField]; 
        console.log(id, 'id')



        if (this.tipo === "leads") {


            if (item.puede_ser_inversionista) {
                acciones += `
                        <a href="${this.baseUrl}app/views/${this.tipo}/${this.tipo}.update.php?id=${id}">
                        <img src="${this.baseUrl}app/img/png/editar.png" alt="Editar" class="icon-acciones">
                    </a>
                    `;
            }

            acciones += `
                    
                    <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;">
                        <img src="${this.baseUrl}app/img/png/eliminar.png" alt="Eliminar" class="icon-acciones">
                    </a>
                    <a href="${this.baseUrl}app/views/contactibilidad/contacto.add?idlead=${id}">
                        <button class="btn-addInversionista">
                            <img src="${this.baseUrl}app/img/svg/Bulk/3-User-white.svg" alt="Contactibilidad" class="icon-inversionista">
                        </button>
                    </a>
                `;


        }

        if (this.tipo === "contratos") {
            acciones = `
                    <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;">
                        <img src="${this.baseUrl}app/img/png/eliminar.png" alt="Eliminar" class="icon-acciones">
                    </a>
                    <a href="#" class="ver-cronograma-modal" style="cursor: pointer;" data-contrato-id="${id}">
                        <img src="${this.baseUrl}app/img/png/cronograma-pagos.png" alt="Ver Cronograma" title="Ver cronograma">
                    </a>
                    <a href="${this.baseUrl}app/views/contratos/generar-pdf.php?idcontrato=${id}" target="_blank">
                        <img src="${this.baseUrl}app/img/png/pdf.png" alt="Generar PDF" class="icon-acciones" title="Generar PDF">
                    </a>
                    <a href="${this.baseUrl}app/views/numcuentas/numcuenta.add.php?idcontrato=${id}">
                        <img src="${this.baseUrl}app/img/png/tarjeta-banco.png" alt="Asociar número de cuenta" class="icon-acciones" title="Asociar número de cuenta">
                    </a>

                    <a href="${this.baseUrl}app/views/detallegarantias/detallegarantias.add.php?idcontrato=${id}">
                        <img src="${this.baseUrl}app/img/png/garantia.png" alt="Asociar garantía" class="icon-acciones" title="Asociar garantía">
                    </a>
                `;
        }

        if (this.tipo === "contactos") {
            acciones = `
                    <a href="${this.baseUrl}app/views/contactibilidad/contactos.update.php?id=${id}">
                        <img src="${this.baseUrl}app/img/png/editar.png" alt="Editar" class="icon-acciones">
                    </a>
                    <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;">
                        <img src="${this.baseUrl}app/img/png/eliminar.png" alt="Eliminar" class="icon-acciones">
                    </a>
                `;
        }

        if (this.tipo === "Inversionistas") {
            acciones = `
                    <a href="${this.baseUrl}app/views/contactibilidad/inversionista.update.php?id=${id}">
                        <img src="${this.baseUrl}app/img/png/editar.png" alt="Editar" class="icon-acciones">
                    </a>
                    <a href="#" onclick="window.dataTable.confirmarEliminacion(${id}); return false;">
                        <img src="${this.baseUrl}app/img/png/eliminar.png" alt="Eliminar" class="icon-acciones">
                    </a>
                `;
        }

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

            if (result.status === "success") {
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
    // EVALUAR EL CRONOGRAMA
    abrirModalCronograma(idContrato) {
        if (
            this.modalCronograma &&
            this.modalCronogramaBody &&
            this.modalContratoIdSpan
        ) {
            this.modalContratoIdSpan.textContent = idContrato;
            this.modalCronogramaBody.innerHTML = "<p>Cargando cronograma...</p>";
            this.modalCronograma.style.display = "flex"; // Cambiado a 'flex' para usar el centrado CSS

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
}
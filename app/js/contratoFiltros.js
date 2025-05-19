(() => {
    const dataTableInstance = window.dataTable;

    if (dataTableInstance) {
        dataTableInstance.filtrarContratos = function () {
            let datosFiltrados = [...this.dataOriginal];

            const filtroVencimiento = document.getElementById("filtro-vencimiento")?.value;
            const filtroEstado = document.getElementById("filtro-estado")?.value;
            const filtroDniAsesor = document.getElementById("filtro-dni-asesor")?.value.trim().toLowerCase();
            const filtroDniInversionista = document.getElementById("filtro-dni-inversionista")?.value.trim().toLowerCase();
            const filtroAnio = document.getElementById("filtro-anio")?.value; // ¡Aquí obtenemos el valor del filtro de año!

            if (filtroDniAsesor) {
                datosFiltrados = datosFiltrados.filter(contrato => contrato['dniAsesor'] && contrato['dniAsesor'].toLowerCase().includes(filtroDniAsesor));
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
                    const anioContrato = new Date(contrato['Inicio']).getFullYear();
                    return String(anioContrato) === filtroAnio;
                });
            }

            this.renderizarTabla(datosFiltrados);
        };

        dataTableInstance.resetearFiltros = function () {
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
                    document.getElementById("filtro-dni-asesor").value = "";
                    document.getElementById("filtro-dni-inversionista").value = "";
                    document.getElementById("filtro-anio").value = "";
                    this.renderizarTabla(this.dataOriginal);
                }
            });
        };

        dataTableInstance.initFilterEventListeners = function() {
            const aplicarFiltrosBtn = document.getElementById("aplicar-filtros");
            if (aplicarFiltrosBtn) {
                aplicarFiltrosBtn.addEventListener("click", this.filtrarContratos.bind(this));
            }

            const resetearFiltrosBtn = document.getElementById("resetear-filtros");
            if (resetearFiltrosBtn) {
                resetearFiltrosBtn.addEventListener("click", this.resetearFiltros.bind(this));
            }
        };

        dataTableInstance.initFilterEventListeners();
    }
})();
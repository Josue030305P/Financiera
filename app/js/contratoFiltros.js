(function() {
    const dataTableInstance = window.dataTable;

    if (dataTableInstance) {
        dataTableInstance.allContratos = [];

        const originalRenderizarTabla = dataTableInstance.renderizarTabla.bind(dataTableInstance);

        dataTableInstance.renderizarTabla = function(data) {
            this.allContratos = [...data];
            originalRenderizarTabla(data);
        };

        dataTableInstance.filtrarContratos = function() {
            let datosFiltrados = [...this.allContratos];

            const filtroVencimiento = document.getElementById("filtro-vencimiento")?.value;
            const filtroEstado = document.getElementById("filtro-estado")?.value;
            const filtroAsesor = document.getElementById("filtro-asesor")?.value.toLowerCase();
            const filtroMoneda = document.getElementById("filtro-moneda")?.value;

            if (filtroVencimiento === 'proximos_30_dias') {
                const hoy = new Date();
                const dentroDe30Dias = new Date();
                dentroDe30Dias.setDate(hoy.getDate() + 30);
                datosFiltrados = datosFiltrados.filter(contrato => {
                    const fechaFin = new Date(contrato['Fin']);
                    return fechaFin >= hoy && fechaFin <= dentroDe30Dias;
                });
            }

            if (filtroEstado) {
                datosFiltrados = datosFiltrados.filter(contrato => contrato['Estado'] === filtroEstado);
            }

            if (filtroAsesor) {
                datosFiltrados = datosFiltrados.filter(contrato => contrato['Asesor'].toLowerCase().includes(filtroAsesor));
            }

            if (filtroMoneda) {
                datosFiltrados = datosFiltrados.filter(contrato => contrato['Moneda'] === filtroMoneda);
            }

            this.renderizarTabla(datosFiltrados);
        };

        dataTableInstance.resetearFiltros = function() {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esto reseteará los filtros y recargará la tabla a su estado original.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, resetear",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("filtro-vencimiento").value = "";
                    document.getElementById("filtro-estado").value = "";
                    document.getElementById("filtro-asesor").value = "";
                    document.getElementById("filtro-moneda").value = "";
                    // Aquí deberías llamar a la función para renderizar la tabla con los datos originales
                    dataTableInstance.renderizarTabla(dataTableInstance.dataOriginal);
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
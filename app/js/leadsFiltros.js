(() => {
    console.log('Jola')
    const dataTableInstance = window.dataTable;
    if (dataTableInstance) {
        dataTableInstance.filtrarLeads = function () {
            let datosFiltrados = [...this.dataOriginal];
            const filtroEstadoLead = document.getElementById("filtro-estado-lead")?.value;

            if (filtroEstadoLead) {
                datosFiltrados = datosFiltrados.filter(lead => lead['Prioridad'].toLowerCase() === filtroEstadoLead.toLowerCase());
            }

            this.renderizarTabla(datosFiltrados);
        };

        dataTableInstance.resetearFiltrosLeads = function () {
            document.getElementById("filtro-estado-lead").value = "";
            this.renderizarTabla(this.dataOriginal);
        };

        dataTableInstance.initLeadFilterEventListeners = function() {
            const aplicarFiltrosLeadBtn = document.getElementById("aplicar-filtros-lead");
            if (aplicarFiltrosLeadBtn) {
                aplicarFiltrosLeadBtn.addEventListener("click", this.filtrarLeads.bind(this));
            }

            const resetearFiltrosLeadBtn = document.getElementById("resetear-filtros-lead");
            if (resetearFiltrosLeadBtn) {
                resetearFiltrosLeadBtn.addEventListener("click", this.resetearFiltrosLeads.bind(this));
            }
        };

        dataTableInstance.initLeadFilterEventListeners();
    }
})();

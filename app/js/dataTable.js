class DataTable {

    constructor(options) {
        this.tableId = options.tableId || 'posts-table';
        this.apiUrl = options.apiUrl;
        this.tipo = options.tipo;
        this.columnas = options.columnas;
        this.mapeo = options.mapeo;
        this.baseUrl = options.baseUrl;
        this.init();
    }

// Inicializar
    init() {
        this.cargarDatos();
        this.initBuscador();
    }

    obtenerValorCampo(item, columna) {
        
        if (!this.mapeo[columna]) return '—';

      
        if (Array.isArray(this.mapeo[columna])) {
            return this.mapeo[columna]
                .map(campo => item[campo])
                .filter(val => val)
                .join(', ');
        }

       
        return item[this.mapeo[columna]] || '—';
    }
    async cargarDatos() {
        try {
            const response = await fetch(this.apiUrl);
            const data  =  await response.json();
            this.renderizarDatos(data);

        } catch(error) {
            console.error("Error: " , error);
        }
    }

    renderizarDatos(datos) {
        const tbody = document.querySelector('#' + this.tableId + ' tbody');
        tbody.innerHTML = '';

        if (!datos || !datos.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="${this.columnas.length}" class="text-center">
                        No hay datos disponibles
                    </td>
                </tr>`;
            return;
        }

        datos.forEach(item => {
            const row = document.createElement('tr');
            row.className = 'tr-item';

            this.columnas.forEach(columna => {
                const td = document.createElement('td');
                td.className = 'td-item';

                switch(columna) {
                    case 'Prioridad':
                        td.innerHTML = this.renderizarPrioridad(item.prioridad);
                        break;
                    case 'Estado':
                        td.innerHTML = this.renderizarEstado(item.estado);
                        break;
                    case 'Acciones':
                        td.innerHTML = this.renderizarAcciones(item.idlead);
                        break;
                    default:
                        td.textContent = this.obtenerValorCampo(item, columna);
                }
                row.appendChild(td);
            });

            tbody.appendChild(row);
        });
    }

    renderizarPrioridad(prioridad) {
        const clase = {
            'alto': 'prioridad-alta',
            'medio': 'prioridad-media',
            'bajo': 'prioridad-baja'
        }[prioridad?.toLowerCase()] || '';
        
        return `<span class="badge ${clase}">${prioridad || '—'}</span>`;
    }

    renderizarEstado(estado) {
        const clase = {
            'activo': 'badge-active',
            'pendiente': 'badge-pending',
            'eliminado': 'badge-trashed'
        }[estado?.toLowerCase()] || '';
        return `<span class="${clase}">${estado || '—'}</span>`;
    }

    renderizarAcciones(id) {
        return `
            <a href="${this.baseUrl}/views/${this.tipo}/${this.tipo}.update.php?id=${id}">
                <img src="${this.baseUrl}app/img/svg/Bulk/Edit-white.svg" alt="Editar" class="edit-lead">
            </a>
            <a href="#" onclick="return confirm('¿Eliminar?') && this.eliminarRegistro(${id})">
                <img src="${this.baseUrl}app/img/svg/Bulk/Delete.svg" alt="Eliminar" class="delete-lead">
            </a>
        `;
    }

    initBuscador() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const busqueda = e.target.value.toLowerCase();
                const filas = document.querySelectorAll('.tr-item');
                
                filas.forEach(fila => {
                    const texto = fila.textContent.toLowerCase();
                    fila.style.display = texto.includes(busqueda) ? '' : 'none';
                });
            });
        }
    }
    
    async eliminarRegistro(id) {
        if (!confirm('¿Está seguro de eliminar este registro?')) return;
    
        try {
            const response = await fetch(`${this.apiUrl}/${id}`, {
                method: 'DELETE'
            });
            const data = await response.json();
            
            if (data.status === 'success') {
                this.cargarDatos();
            } else {
                alert('Error al eliminar');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
}













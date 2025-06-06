

document.addEventListener('DOMContentLoaded', () => {
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
    const tableBody = document.getElementById('garantias-table-body');
    const messageContainer = document.getElementById('message-container');

    const CONTROLLER_URL = `${baseUrl}app/controllers/DetalleGarantiaController.php`;

    const showToast = async (icon, title, position = "top-end") => {
        Swal.fire({
            icon: icon,
            title: title,
            toast: true,
            position: position,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });
    };

    const displayMessage = (message, type) => {
        messageContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        setTimeout(() => {
            messageContainer.innerHTML = '';
        }, 5000);
    };

    // Función para renderizar las garantías en la tabla
    const renderGarantias = (garantias) => {
        tableBody.innerHTML = ''; // Limpiar filas existentes

        if (!garantias || garantias.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 20px;">No se encontraron garantías.</td></tr>`;
            return;
        }

        garantias.forEach(garantia => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${garantia.iddetallegarantia}</td>
                <td>${garantia.tipogarantia}</td>
                <td>${garantia.porcentaje}%</td>
                <td>${garantia.observaciones || 'N/A'}</td>
                <td>${garantia.idcontrato}</td>
                <td>${garantia.nombre_completo_inversionista}</td>
                <td>S/ ${parseFloat(garantia.capital).toFixed(2)}</td>
                <td>${garantia.fechainicio}</td>
                <td>${garantia.fechafin}</td>
                <td class="actions-column">
                    <a href="${baseUrl}app/views/detallegarantia/edit.php?id=${garantia.iddetallegarantia}" class="action-btn edit-btn" title="Editar">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <button class="action-btn delete-btn" data-id="${garantia.iddetallegarantia}" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Adjuntar event listeners a los botones de eliminar
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (event) => {
                const idToDelete = event.currentTarget.dataset.id;
                confirmDelete(idToDelete);
            });
        });
    };

    // Función para obtener las garantías del controlador
    const fetchGarantias = async () => {
        try {
            // El controlador espera un GET sin action, que devolverá la vista
            const response = await fetch(CONTROLLER_URL); 
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const data = await response.json();

            if (data.status && data.data) {
                renderGarantias(data.data);
            } else {
                displayMessage('Error al cargar garantías: ' + (data.message || 'Error desconocido.'), 'danger');
                renderGarantias([]); // Mostrar tabla vacía si hay error
            }
        } catch (error) {
            console.error('Error fetching garantías:', error);
            displayMessage('Problema de conexión al cargar las garantías.', 'danger');
            renderGarantias([]); // Mostrar tabla vacía en caso de error de red/servidor
        }
    };

    // Confirmación de eliminación con SweetAlert2
    const confirmDelete = (id) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteGarantia(id);
            }
        });
    };

    // Función para eliminar una garantía
    const deleteGarantia = async (id) => {
        try {
            const response = await fetch(CONTROLLER_URL, {
                method: 'POST', // Tu controlador PHP para eliminar espera un POST
                headers: {
                    'Content-Type': 'application/json', // O 'application/x-www-form-urlencoded' si prefieres $_POST
                },
                body: JSON.stringify({ action: 'delete', id: id }) // Envía 'action' y 'id' como JSON
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const result = await response.json();

            if (result.status) {
                showToast('success', result.message || 'Garantía eliminada con éxito.');
                fetchGarantias(); // Recargar la tabla
            } else {
                showToast('error', result.message || 'Error al eliminar la garantía.');
            }
        } catch (error) {
            console.error('Error deleting garantía:', error);
            showToast('error', 'Problema al conectar con el servidor para eliminar.');
        }
    };

    // Cargar las garantías al inicio
    fetchGarantias();
});
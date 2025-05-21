document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    const updateForm = document.getElementById('updateContactibilidadForm');

    if (updateForm) {
        const idcontactibilidadInput = document.getElementById('idcontactibilidad');
        const urlParams = new URLSearchParams(window.location.search);
        const idcontactibilidad = urlParams.get('id');

        if (idcontactibilidadInput) {
            idcontactibilidadInput.value = idcontactibilidad;
        }

        async function loadContactData(id) {
            if (!id) {
                Swal.fire({
                    icon: 'error',
                    title: 'ID no encontrado',
                    text: 'No se proporcionó un ID de contacto para la actualización.',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = `${baseUrl}app/views/contactibilidad/`;
                });
                return;
            }

            try {
                const response = await fetch(`${baseUrl}app/controllers/ContactibilidadController.php?id=${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.status === 'success' && result.data) {
                    document.getElementById('fecha_contacto').value = result.data.fecha || '';
                    document.getElementById('hora_contacto').value = result.data.hora || '';
                    document.getElementById('comentarios').value = result.data.comentarios || '';
                    document.getElementById('estado_contactibilidad').value = result.data.estado || '';

                    
                    const estadoSelect = document.getElementById('estado_contactibilidad');
                    if (result.data.estado) {
                        for (let i = 0; i < estadoSelect.options.length; i++) {
                            if (estadoSelect.options[i].value === result.data.estado) {
                                estadoSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de carga',
                        text: result.message || 'No se pudieron cargar los datos del contacto.',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        window.location.href = `${baseUrl}app/views/contactibilidad/`;
                    });
                }
            } catch (error) {
                console.error('Error al cargar datos:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor para cargar los datos.',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = `${baseUrl}app/views/contactibilidad/`;
                });
            }
        }

        // Cargar los datos al iniciar la página de actualización
        loadContactData(idcontactibilidad);

        updateForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                fecha: document.getElementById('fecha_contacto').value.trim(),
                hora: document.getElementById('hora_contacto').value.trim(),
                comentarios: document.getElementById('comentarios').value.trim(),
                estado: document.getElementById('estado_contactibilidad').value.trim()
            };

            try {
                if (!formData.fecha || !formData.hora || !formData.estado) {
                    await Swal.fire({
                        icon: 'warning',
                        title: 'Campos Requeridos',
                        text: 'Por favor, complete la fecha, hora y estado.',
                    });
                    return;
                }

                if (!idcontactibilidad) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error de actualización',
                        text: 'ID de contacto no disponible para la actualización.',
                    });
                    return;
                }

                const response = await fetch(`${baseUrl}app/controllers/ContactibilidadController.php?id=${idcontactibilidad}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error en la respuesta del servidor.');
                }

                const result = await response.json();

                if (result.status === 'success') {
                    await Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: "Éxito",
                        text: result.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                    window.location.href = `${baseUrl}app/views/contactibilidad/`;
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Hubo un problema al actualizar el contacto.',
                        confirmButtonColor: '#3085d6'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar el contacto: ' + error.message,
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    }
});
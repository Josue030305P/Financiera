document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addContactibilidadForm');
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

    const fechaInput = document.getElementById('fecha_contacto');
    const horaInput = document.getElementById('hora_contacto');
    const now = new Date();

    fechaInput.value = now.toISOString().split('T')[0];
    horaInput.value = now.toTimeString().split(' ')[0].substring(0, 5);

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            idlead: document.querySelector('input[name="idlead"]').value.trim(),
            fecha: document.getElementById('fecha_contacto').value.trim(),
            hora: document.getElementById('hora_contacto').value.trim(),
            comentarios: document.getElementById('comentarios').value.trim(),
            estado: document.getElementById('estado_contactibilidad').value.trim()
        };

        try {
            if (!formData.idlead || !formData.fecha || !formData.hora || !formData.estado) {
                await Swal.fire({
                    icon: 'warning',
                    title: 'Campos Requeridos',
                    text: 'Por favor, complete la fecha, hora, estado y asegúrese de que el ID del Lead esté presente.',
                });
                return;
            }

            formData.idlead = parseInt(formData.idlead);
            if (isNaN(formData.idlead)) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error de Lead',
                    text: 'El ID del Lead no es un número válido.',
                });
                return;
            }

       
            const response = await fetch(`${baseUrl}app/controllers/ContactibilidadController.php`, {
                method: 'POST',
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
                    text: result.message || 'Hubo un problema al registrar el contacto.',
                    confirmButtonColor: '#3085d6'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al registrar el contacto: ' + error.message,
                confirmButtonColor: '#3085d6'
            });
        }
    });








    
    











});
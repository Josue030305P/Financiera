document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('addNumCuentaForm');
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || "";
    const selectorTipoEntidad = document.getElementById('tipo_entidad');
    const selectorEntidad = document.getElementById('identidad');

    
    const showToast = (icon, title, position = 'top-end') => {
        Swal.fire({
            icon: icon,
            title: title,
            toast: true,
            position: position,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    };

    const paramsURL = new URLSearchParams(window.location.search);
    const idContratoURL = paramsURL.get('idcontrato');


    async function cargarTiposEntidad() {
        selectorTipoEntidad.innerHTML = '<option value="">Cargando tipos...</option>';
        selectorTipoEntidad.disabled = true;

        const urlTipos = `${baseUrl}app/controllers/EntidadController.php?action=get_types`;

        try {
            const respuestaTipos = await fetch(urlTipos);
            const datosTipos = await respuestaTipos.json();

            selectorTipoEntidad.innerHTML = '<option value="">Seleccione un tipo</option>';

            if (datosTipos.status === 'success' && datosTipos.data && datosTipos.data.length > 0) {
                datosTipos.data.forEach(tipo => {
                    const opcion = document.createElement('option');
                    opcion.value = tipo;
                    opcion.textContent = tipo;
                    selectorTipoEntidad.appendChild(opcion);
                });
                selectorTipoEntidad.disabled = false;
            } else {
                selectorTipoEntidad.innerHTML = '<option value="">No hay tipos de entidad disponibles</option>';
          
            }
        } catch (error) {
            console.error("Error al cargar tipos de entidad:", error);
            selectorTipoEntidad.innerHTML = '<option value="">Error al cargar tipos</option>';
           
            showToast('error', 'Error al cargar los tipos de entidad. Detalles: ' + error.message);
        }
    }

    async function obtenerEntidades(tipo = null) {
        if (!tipo) {
            return [];
        }
        const url = `${baseUrl}app/controllers/EntidadController.php?tipo=${tipo}`;

        try {
            const respuesta = await fetch(url);
            if (!respuesta.ok) {
                throw new Error(`Error al cargar entidades: ${respuesta.statusText}`);
            }
            const datos = await respuesta.json();

            if (datos.status === 'success') {
                return datos.data || [];
            } else {
                console.error("Error en la respuesta del controlador:", datos.message);
            
                showToast('error', `Error al cargar las entidades: ${datos.message}`);
                return [];
            }
        } catch (error) {
            console.error("Error al obtener entidades:", error);
     
            showToast('error', 'Error al cargar las entidades. Detalles: ' + error.message);
            return [];
        }
    }

    async function poblarSelectorEntidad(tipoSeleccionado) {
        selectorEntidad.innerHTML = '<option value="">Cargando...</option>';
        selectorEntidad.disabled = true;

        const entidades = await obtenerEntidades(tipoSeleccionado);

        selectorEntidad.innerHTML = '<option value="">Seleccione una entidad</option>';
        if (entidades.length > 0) {
            entidades.forEach(entidad => {
                const opcion = document.createElement('option');
                opcion.value = entidad.identidad;
                opcion.textContent = entidad.entidad;
                selectorEntidad.appendChild(opcion);
            });
            selectorEntidad.disabled = false;
        } else {
            selectorEntidad.innerHTML = '<option value="">No hay entidades disponibles para este tipo</option>';
           
        }
    }

    selectorTipoEntidad.addEventListener('change', function() {
        const tipoSeleccionado = this.value;
        if (tipoSeleccionado) {
            poblarSelectorEntidad(tipoSeleccionado);
        } else {
            selectorEntidad.innerHTML = '<option value="">Seleccione un tipo primero</option>';
            selectorEntidad.disabled = true;
        }
    });

    cargarTiposEntidad();

    formulario.addEventListener('submit', async function(evento) {
        evento.preventDefault();

        const identidad = selectorEntidad.value;
        const numCuenta = document.getElementById('numcuenta').value;
        const cci = document.getElementById('cci').value;
        const observaciones = document.getElementById('observaciones').value;

        if (!identidad) {
            showToast('warning', "Por favor, seleccione una entidad bancaria.");
            return;
        }

        const cargaUtil = {
            idcontrato: parseInt(idContratoURL),
            identidad: parseInt(identidad),
            numcuenta: numCuenta,
            cci: cci,
            observaciones: observaciones ?? null
        };

        try {
            const respuesta = await fetch(`${baseUrl}app/controllers/NumCuentasController.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cargaUtil)
            });

            if (!respuesta.ok) {
                const errorText = await respuesta.text(); 
                throw new Error(`Error en la respuesta de la red: ${respuesta.statusText} - ${errorText}`);
            }

            const resultado = await respuesta.json();

            if (resultado.status === 'success') {
                
                showToast('success', "Número de cuenta agregado exitosamente.");
                formulario.reset();
                window.location = `${baseUrl}app/views/inversionistas/`;
                selectorEntidad.innerHTML = '<option value="">Seleccione un tipo primero</option>';
                selectorEntidad.disabled = true;
                selectorTipoEntidad.value = "";
                cargarTiposEntidad();
            } else {
            
                showToast('error', `Error: ${resultado.message}`);
            }
        } catch (error) {
            console.error("Error al agregar el número de cuenta:", error);
        
            showToast('error', "Hubo un error al agregar el número de cuenta. Por favor, intente de nuevo. Detalles: " + error.message);
        }
    });
});
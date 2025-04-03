class LeadForm {
    constructor(leadId = null, isUpdate = false) {
        this.baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';
        this.form = document.getElementById('lead-form');
        this.leadId = leadId;
        this.isUpdate = isUpdate;
        this.init();
    }

    async init() {
        await Promise.all([
            this.cargarAsesores(),
            this.cargarPaises()
        ]);
        
        if (this.isUpdate && this.leadId) {
            await this.cargarDatosLead();
        }
        
        this.initEventListeners();
    }

    async cargarAsesores() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/AsesorController.php`);
            const asesores = await response.json();
            
            const selectAsesor = document.getElementById('asesor');
            selectAsesor.innerHTML = '<option value="">Seleccione un asesor</option>';
            
            if (Array.isArray(asesores) && asesores.length > 0) {
                asesores.forEach(asesor => {
                    selectAsesor.innerHTML += `
                        <option value="${asesor.idpersona}">${asesor.nombrecompleto}</option>
                    `;
                });
            }
        } catch (error) {
            console.error('Error al cargar asesores:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar los asesores',
                confirmButtonColor: '#3085d6'
            });
        }
    }

    async cargarPaises() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/PaisController.php`);
            const paises = await response.json();
            
            const selectPais = document.getElementById('pais');
            selectPais.innerHTML = '<option value="">Seleccione un país</option>';
            
            paises.forEach(pais => {
                selectPais.innerHTML += `
                    <option value="${pais.idpais}">${pais.pais}</option>
                `;
            });
        } catch (error) {
            console.error('Error al cargar países:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar los países',
                confirmButtonColor: '#3085d6'
            });
        }
    }

    async cargarDatosLead() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/LeadController.php?id=${this.leadId}`);
            const result = await response.json();
            
            if (result.status === 'success') {
                const lead = result.data;
                
                document.getElementById('apellidos').value = lead.apellidos || '';
                document.getElementById('nombres').value = lead.nombres || '';
                document.getElementById('telefono').value = lead.telprincipal || '';
                document.getElementById('correo').value = lead.email || '';
                document.getElementById('pais').value = lead.idpais || '';
                document.getElementById('prioridad').value = lead.prioridad || '';
                document.getElementById('asesor').value = lead.idasesor || '';
                document.getElementById('canal').value = lead.idcanal || '';
                document.getElementById('ocupacion').value = lead.ocupacion || '';
                document.getElementById('comentarios').value = lead.comentarios || '';
                
                const addBtn = this.form.querySelector('.add-btn');
                addBtn.textContent = 'Actualizar lead';
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar los datos del lead: ' + result.message,
                    confirmButtonColor: '#3085d6'
                });
                window.location.href = `${this.baseUrl}app/`;
            }
        } catch (error) {
            console.error('Error al cargar datos del lead:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar los datos del lead',
                confirmButtonColor: '#3085d6'
            });
            window.location.href = `${this.baseUrl}app/`;
        }
    }

    async initEventListeners() {
        const addBtn = this.form.querySelector('.add-btn');
        const resetBtn = this.form.querySelector('.reset-btn');

        addBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (this.isUpdate) {
                this.actualizarLead();
            } else {
                this.guardarLead();
            }
        });

        resetBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const result = await Swal.fire({
                title: '¿Cancelar?',
                text: "¿Estás seguro de que deseas cancelar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No'
            });

            if (result.isConfirmed) {
                window.location.href = `${this.baseUrl}app/`;
            }
        });
    }

    async guardarLead() {
        try {
            const formData = {
                idpais: document.getElementById('pais').value,
                apellidos: document.getElementById('apellidos').value,
                nombres: document.getElementById('nombres').value,
                email: document.getElementById('correo').value,
                telprincipal: document.getElementById('telefono').value,
                idasesor: document.getElementById('asesor').value,
                idcanal: document.getElementById('canal').value,
                comentarios: document.getElementById('comentarios').value,
                prioridad: document.getElementById('prioridad').value,
                ocupacion: document.getElementById('ocupacion').value
            };
    
            if (!this.validarFormulario(formData)) return;
    
            const response = await fetch(`${this.baseUrl}app/controllers/LeadController.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
    
            const result = await response.json();
    
            if (result.status === 'success') {
                await Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Lead guardado correctamente',
                    confirmButtonColor: '#3085d6'
                });
                window.location.href = `${this.baseUrl}app/`;
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar: ' + result.message,
                    confirmButtonColor: '#3085d6'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar el lead',
                confirmButtonColor: '#3085d6'
            });
        }
    }

    async actualizarLead() {
        try {
            const formData = {
                idpais: document.getElementById('pais').value,
                apellidos: document.getElementById('apellidos').value,
                nombres: document.getElementById('nombres').value,
                email: document.getElementById('correo').value,
                telprincipal: document.getElementById('telefono').value,
                idasesor: document.getElementById('asesor').value,
                idcanal: document.getElementById('canal').value,
                comentarios: document.getElementById('comentarios').value,
                prioridad: document.getElementById('prioridad').value,
                ocupacion: document.getElementById('ocupacion').value
            };
    
            if (!this.validarFormulario(formData)) return;
    
            const response = await fetch(`${this.baseUrl}app/controllers/LeadController.php?id=${this.leadId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
    
            const result = await response.json();
    
            if (result.status === 'success') {
                await Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Lead actualizado correctamente',
                    confirmButtonColor: '#3085d6'
                });
                window.location.href = `${this.baseUrl}app/`;
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar: ' + result.message,
                    confirmButtonColor: '#3085d6'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al actualizar el lead',
                confirmButtonColor: '#3085d6'
            });
        }
    }

    async convertirAInversionista(idlead, idpersona) {
        try {
            const datosAdicionales = {
                idpersona: idpersona,
                tipodocumento: document.getElementById('tipodocumento').value,
                numdocumento: document.getElementById('numdocumento').value,
                iddistrito: document.getElementById('distrito').value,
                domicilio: document.getElementById('domicilio').value,
                telsecundario: document.getElementById('telsecundario').value,
                referencia: document.getElementById('referencia').value
            };

            const response = await fetch(
                `${this.baseUrl}app/controllers/LeadController.php?action=convertir&id=${idlead}`, 
                {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(datosAdicionales)
                }
            );

            const result = await response.json();

            if (result.status === 'success') {
                await Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Lead convertido a inversionista correctamente',
                    confirmButtonColor: '#3085d6'
                });
                window.location.href = `${this.baseUrl}app/views/inversionistas/`;
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + result.message,
                    confirmButtonColor: '#3085d6'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al convertir lead a inversionista',
                confirmButtonColor: '#3085d6'
            });
        }
    }

    async validarFormulario(data) {
        if (!data.apellidos || !data.nombres) {
            await Swal.fire({
                icon: 'warning',
                title: 'Validación',
                text: 'Los nombres y apellidos son obligatorios',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
        if (!data.telprincipal) {
            await Swal.fire({
                icon: 'warning',
                title: 'Validación',
                text: 'El teléfono es obligatorio',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
        if (!data.email) {
            await Swal.fire({
                icon: 'warning',
                title: 'Validación',
                text: 'El correo es obligatorio',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
        if (!data.idasesor) {
            await Swal.fire({
                icon: 'warning',
                title: 'Validación',
                text: 'Debe seleccionar un asesor',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
        if (!data.idpais) {
            await Swal.fire({
                icon: 'warning',
                title: 'Validación',
                text: 'Debe seleccionar un país',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
        return true;
    }
}
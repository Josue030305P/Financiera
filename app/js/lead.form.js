class LeadForm {
    constructor(leadId = null, isUpdate = false) {
        this.baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';
        this.form = document.getElementById('lead-form');
        this.leadId = leadId;
        this.isUpdate = isUpdate;
        this.init();
    }

    init() {
        this.cargarAsesores();
        this.cargarPaises();
        this.initEventListeners();
        
        // Si es una actualización, cargar los datos del lead
        if (this.isUpdate && this.leadId) {
            this.cargarDatosLead();
        }
    }

    async cargarAsesores() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/AsesorController.php`);
            const asesores = await response.json();
            
            const selectAsesor = document.getElementById('asesor');
            selectAsesor.innerHTML = '<option value="">Seleccione un asesor</option>';
            
            asesores.forEach(asesor => {
                selectAsesor.innerHTML += `
                    <option value="${asesor.idpersona}">${asesor.nombrecompleto}</option>
                `;
            });
        } catch (error) {
            console.error('Error al cargar asesores:', error);
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
        }
    }

    async cargarDatosLead() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/LeadController.php?id=${this.leadId}`);
            const result = await response.json();
            
            if (result.status === 'success') {
                const lead = result.data;
                
                // Llenar los campos del formulario con los datos del lead
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
                
                // Cambiar el texto del botón
                const addBtn = this.form.querySelector('.add-btn');
                addBtn.textContent = 'Actualizar lead';
            } else {
                alert('Error al cargar los datos del lead: ' + result.message);
                window.location.href = `${this.baseUrl}app/`;
            }
        } catch (error) {
            console.error('Error al cargar datos del lead:', error);
            alert('Error al cargar los datos del lead');
            window.location.href = `${this.baseUrl}app/`;
        }
    }

    initEventListeners() {
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

        resetBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm('¿Desea cancelar?')) {
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
                alert('Lead guardado correctamente');
                window.location.href = `${this.baseUrl}app/`;
            } else {
                alert('Error al guardar: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al guardar el lead');
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
                alert('Lead actualizado correctamente');
                window.location.href = `${this.baseUrl}app/`;
            } else {
                alert('Error al actualizar: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al actualizar el lead');
        }
    }

    validarFormulario(data) {
        if (!data.apellidos || !data.nombres) {
            alert('Los nombres y apellidos son obligatorios');
            return false;
        }
        if (!data.telprincipal) {
            alert('El teléfono es obligatorio');
            return false;
        }
        if (!data.email) {
            alert('El correo es obligatorio');
            return false;
        }
        if (!data.idasesor) {
            alert('Debe seleccionar un asesor');
            return false;
        }
        if (!data.idpais) {
            alert('Debe seleccionar un país');
            return false;
        }
        return true;
    }
}

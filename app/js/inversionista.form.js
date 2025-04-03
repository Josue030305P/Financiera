class InversionistaForm {
    constructor(inversionistaId = null, isUpdate = false) {
        this.baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';
        this.form = document.querySelector('.form-container');
        this.inversionistaId = inversionistaId;
        this.isUpdate = isUpdate;
        this.init();
    }

    init() {
        this.cargarPaises();
        this.cargarAsesores();
        this.initEventListeners();
        
        if (this.isUpdate && this.inversionistaId) {
            this.cargarDatosInversionista();
        } else {
            
            const urlParams = new URLSearchParams(window.location.search);
            const leadId = urlParams.get('lead_id');
            if (leadId) {
                this.cargarDatosLead(leadId);
            }
        }
    }

    async cargarPaises() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/PaisController.php`);
            const paises = await response.json();
            
            const selectPais = document.getElementById('pais');
            if (selectPais) {
                selectPais.innerHTML = '<option value="">Seleccione un país</option>';
                
                paises.forEach(pais => {
                    selectPais.innerHTML += `
                        <option value="${pais.idpais}">${pais.pais}</option>
                    `;
                });
            }
        } catch (error) {
            console.error('Error al cargar países:', error);
        }
    }

    async cargarAsesores() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/AsesorController.php`);
            const asesores = await response.json();
            
            const selectAsesor = document.getElementById('asesor');
            if (selectAsesor) {
                selectAsesor.innerHTML = '<option value="">Seleccione un asesor</option>';
                
                asesores.forEach(asesor => {
                    selectAsesor.innerHTML += `
                        <option value="${asesor.idpersona}">${asesor.nombrecompleto}</option>
                    `;
                });
            }
        } catch (error) {
            console.error('Error al cargar asesores:', error);
        }
    }

    async cargarDatosInversionista() {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/InversionistaController.php?id=${this.inversionistaId}`);
            const result = await response.json();
            
            if (result.status === 'success') {
                const inversionista = result.data;
                
                document.getElementById('apellidos').value = inversionista.apellidos || '';
                document.getElementById('nombres').value = inversionista.nombres || '';
                document.getElementById('numdocumento').value = inversionista.numdocumento || '';
                document.getElementById('fechanacimiento').value = inversionista.fechanacimiento || '';
                document.getElementById('telefono').value = inversionista.telefono || '';
                document.getElementById('correo').value = inversionista.correo || '';
                document.getElementById('pais').value = inversionista.idpais || '';
                document.getElementById('nombreempresa').value = inversionista.nombreempresa || '';
                document.getElementById('ruc').value = inversionista.ruc || '';
                document.getElementById('asesor').value = inversionista.idasesor || '';
                document.getElementById('estado').value = inversionista.estado || '';
                
                const addBtn = this.form.querySelector('.add-btn');
                addBtn.textContent = 'Actualizar Inversionista';
            } else {
                alert('Error al cargar los datos del inversionista: ' + result.message);
                window.location.href = `${this.baseUrl}app/views/inversionistas/`;
            }
        } catch (error) {
            console.error('Error al cargar datos del inversionista:', error);
            alert('Error al cargar los datos del inversionista');
            window.location.href = `${this.baseUrl}app/views/inversionistas/`;
        }
    }

    async cargarDatosLead(leadId) {
        try {
            const response = await fetch(`${this.baseUrl}app/controllers/InversionistaController.php?lead_id=${leadId}`);
            const result = await response.json();
            
            if (result.status === 'success') {
                const lead = result.data;
                
                document.getElementById('apellidos').value = lead.apellidos || '';
                document.getElementById('nombres').value = lead.nombres || '';
                document.getElementById('telefono').value = lead.telprincipal || '';
                document.getElementById('correo').value = lead.email || '';
                document.getElementById('pais').value = lead.idpais || '';
                document.getElementById('asesor').value = lead.idasesor
                
                
                const leadIdInput = document.createElement('input');
                leadIdInput.type = 'hidden';
                leadIdInput.id = 'lead_id';
                leadIdInput.value = leadId;
                this.form.appendChild(leadIdInput);
            }
        } catch (error) {
            console.error('Error al cargar datos del lead:', error);
        }
    }

    initEventListeners() {
        const addBtn = this.form.querySelector('.add-btn');
        const resetBtn = this.form.querySelector('.reset-btn');

        if (addBtn) {
            addBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (this.isUpdate) {
                    this.actualizarInversionista();
                } else {
                    this.guardarInversionista();
                }
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (confirm('¿Desea cancelar?')) {
                    window.location.href = `${this.baseUrl}app/views/inversionistas/`;
                }
            });
        }
    }

    async guardarInversionista() {
        try {
            
            const apellidos = document.getElementById('apellidos');
            const nombres = document.getElementById('nombres');
            const tipodocumento = document.getElementById('tipodocumento');
            const numdocumento = document.getElementById('numdocumento');
            const fechanacimiento = document.getElementById('fechanacimiento');
            const telefono = document.getElementById('telefono');
            const correo = document.getElementById('correo');
            const pais = document.getElementById('pais');
            const nombreempresa = document.getElementById('nombreempresa');
            const ruc = document.getElementById('ruc');
            const asesor = document.getElementById('asesor');
            const estado = document.getElementById('estado');

            
            if (!apellidos || !nombres || !telefono || !correo || !pais) {
                alert('Error: Faltan campos requeridos en el formulario');
                return;
            }

            const formData = {
                apellidos: apellidos.value,
                nombres: nombres.value,
                tipodocumento: tipodocumento ? tipodocumento.value : '',
                numdocumento: numdocumento ? numdocumento.value : '',
                fechanacimiento: fechanacimiento ? fechanacimiento.value : '',
                telefono: telefono.value,
                correo: correo.value,
                idpais: pais.value,
                nombreempresa: nombreempresa ? nombreempresa.value : '',
                ruc: ruc ? ruc.value : '',
                idasesor: asesor ? asesor.value : '',
                estado: estado ? estado.value : 'Activo'
            };
    
            const leadIdInput = document.getElementById('lead_id');
            if (leadIdInput) {
                formData.lead_id = leadIdInput.value;
            }
    
            if (!this.validarFormulario(formData)) return;
    
            const response = await fetch(`${this.baseUrl}app/controllers/InversionistaController.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
    
            const result = await response.json();
    
            if (result.status === 'success') {
                alert('Inversionista guardado correctamente');
                window.location.href = `${this.baseUrl}app/views/inversionistas/`;
            } else {
                alert('Error al guardar: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al guardar el inversionista');
        }
    }

    async actualizarInversionista() {
        try {
            const formData = {
                apellidos: document.getElementById('apellidos').value,
                nombres: document.getElementById('nombres').value,
                tipodocumento: document.getElementById('tipodocumento').value,
                numdocumento: document.getElementById('numdocumento').value,
                fechanacimiento: document.getElementById('fechanacimiento').value,
                telefono: document.getElementById('telefono').value,
                correo: document.getElementById('correo').value,
                idpais: document.getElementById('pais').value,
                nombreempresa: document.getElementById('nombreempresa').value,
                ruc: document.getElementById('ruc').value,
                idasesor: document.getElementById('asesor').value,
                estado: document.getElementById('estado').value
            };
    
            if (!this.validarFormulario(formData)) return;
    
            const response = await fetch(`${this.baseUrl}app/controllers/InversionistaController.php?id=${this.inversionistaId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
    
            const result = await response.json();
    
            if (result.status === 'success') {
                alert('Inversionista actualizado correctamente');
                window.location.href = `${this.baseUrl}app/views/inversionistas/`;
            } else {
                alert('Error al actualizar: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al actualizar el inversionista');
        }
    }

    validarFormulario(data) {
        if (!data.apellidos || !data.nombres) {
            alert('Los nombres y apellidos son obligatorios');
            return false;
        }
        if (!data.numdocumento) {
            alert('El número de documento es obligatorio');
            return false;
        }
        if (!data.telefono) {
            alert('El teléfono es obligatorio');
            return false;
        }
        if (!data.correo) {
            alert('El correo es obligatorio');
            return false;
        }
        
        if (!data.idpais) {
            alert('Debe seleccionar un país');
            return false;
        }
        return true;
    }
} 
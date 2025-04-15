
function buscarConyuge() {
    const dni = document.getElementById('buscarDNI').value.trim();
    const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';
    
    if (!dni || dni.length !== 8) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Ingrese un DNI válido de 8 dígitos',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        return;
    }


    Swal.fire({
        title: 'Buscando...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`${baseUrl}app/controllers/ContratoController.php?dni=${dni}`)
        .then(response => response.json())
        .then(data => {
            Swal.close(); 
            
            if (data.error || !data.nombres) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'No se encontraron resultados',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                return;
            }
            
            
            document.getElementById('conyuge').value = `${data.nombres || ''} ${data.apellidos || ''}`.trim();
            document.getElementById('telconyuge').value = data.telprincipal || '';
          
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Datos encontrados',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        })
        .catch(error => {
            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Error en la búsqueda',
                text: 'No se encontrarón resultados ',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
            console.error('Error:', error);
        });
}



document.getElementById('buscarDNI').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault(); 
        buscarConyuge();
    }
});


document.getElementById('buscarDNI').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
    if (this.value.length > 8) {
        this.value = this.value.slice(0, 8);
    }
});
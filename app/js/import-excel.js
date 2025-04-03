document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.import-excel').addEventListener('click', () => {
        document.getElementById('excelFileInput').click();
    });

    document.getElementById('excelFileInput').addEventListener('change', function (event) {
        let file = event.target.files[0];
        if (!file) return;

        let reader = new FileReader();
        reader.readAsBinaryString(file);

        reader.onload = function (e) {
            let data = e.target.result;
            let workbook = XLSX.read(data, { type: 'binary' });
            let sheetName = workbook.SheetNames[0];
            let sheet = workbook.Sheets[sheetName];
            let jsonData = XLSX.utils.sheet_to_json(sheet);

            enviarDatos(jsonData);
        };
    });
});

function enviarDatos(data) {
    
    const transformedData = data.map(row => {
        return {
            'País': row['País'] || row['idpais'] || '',
            'Apellidos': row['Apellidos'] || row['apellidos'] || '',
            'Nombres': row['Nombres'] || row['nombres'] || '',
            'Correo': row['Correo'] || row['email'] || '',
            'Teléfono': row['Teléfono'] || row['telprincipal'] || '',
            'Asesor': row['Asesor'] || row['idasesor'] || '',
            'Canal': row['Canal'] || row['idcanal'] || '',
            'Comentarios': row['Comentarios'] || row['comentarios'] || '',
            'Prioridad': row['Prioridad'] || row['prioridad'] || '',
            'Ocupación': row['Ocupación'] || row['ocupacion'] || ''
        };
    });

    fetch('http://localhost/Financiera/app/controllers/LeadController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(transformedData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert(`Importación completada. Éxitos: ${result.success_count}, Errores: ${result.error_count}`);
            if (result.error_count > 0) {
                console.error('Errores:', result.errors);
            }
            location.reload();
        } else {
            alert('Error al importar: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al importar los datos');
    });
}

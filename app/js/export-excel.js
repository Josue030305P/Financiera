function exportExcel(fileName) {
    document.querySelector('.export-excel').addEventListener('click', function() {
    
        const table = document.getElementById('dataTable');
    
        const data = [];
    
        const headers = [];
        let accionesIndex = -1;
        const ths = table.querySelectorAll('thead th');
        ths.forEach((th, index) => {
            const text = th.textContent.trim();
            if(text === 'Acciones'){
                accionesIndex = index;
            } else {
                headers.push(text);
            }
        });
        data.push(headers);
        
      
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            const tds = tr.querySelectorAll('td');
            tds.forEach((td, index) => {
                if(index !== accionesIndex) {
                    row.push(td.textContent.trim());
                }
            });
            data.push(row);
        });
       
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);
        
        XLSX.utils.book_append_sheet(wb, ws, "Datos");
        XLSX.writeFile(wb, `${fileName}.xlsx`);
        
    
    });
}



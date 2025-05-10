
function generarCronograma(capital, interes, duracionMeses, fechaInicio) {
    const cuotas = [];
    const interesDecimal = interes / 100;
    const cuotaBase = capital * interesDecimal;
    console.log('Capital con cobro de interes:', cuotaBase);
    const totalBruto =  cuotaBase - (cuotaBase * 0.05) ; // Aplicando el 5% de retencion

    let fecha = new Date(fechaInicio);

    for (let i = 1; i <= duracionMeses; i++) {
        // Formatear fecha a dd/mm/yyyy
        const fechaStr = fecha.toLocaleDateString('es-ES');
        cuotas.push({
            cuota: i,
            fecha: fechaStr,
            total_bruto: cuotaBase.toFixed(2),
            neto: totalBruto 
        });
    
        fecha.setMonth(fecha.getMonth() + 1);
    }
    return cuotas;
}


const cronograma = generarCronograma(30900, 3, 12, "2025-05-10");
console.table(cronograma);




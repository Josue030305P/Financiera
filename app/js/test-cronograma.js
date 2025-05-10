
function generarCronograma(capital, interes, duracionMeses, fechaInicio) {
    const cuotas = [];
    const interesDecimal = interes / 100;
    const cuotaBase = capital * interesDecimal;
    const totalBruto =  cuotaBase - (cuotaBase * 0.05) ; // Aplicando el 5% de retencion

    console.log('Capital con cobro de interes:', cuotaBase);


    let fecha = new Date(fechaInicio);

    for (let i = 1; i <= duracionMeses; i++) {
        // Formatear fecha a dd/mm/yyyy
        const fechaStr = fecha.toLocaleDateString('es-ES');
        cuotas.push({
            Cuota: i,
            Fecha: fechaStr,
            Total_Bruto: Number(cuotaBase.toFixed(2)),
            Total_Neto: totalBruto 
        });
    
        fecha.setMonth(fecha.getMonth() + 1);
    }
    return cuotas;
}


const cronograma = generarCronograma(30900, 3, 12, "2025-05-10");
console.table(cronograma);



/*
Cuota   Fecha    Total_Bruto  Total_Neto
1	  '9/5/2025'	   927	    880.65
2	  '9/6/2025'	   927	    880.65
3	  '9/7/2025'	   927	    880.65
4	  '9/8/2025'	   927	    880.65
5	  '9/9/2025'	   927	    880.65
6	  '9/10/2025'	   927	    880.65
7	  '9/11/2025'	   927	    880.65
8	  '9/12/2025'	   927	    880.65
9	  '9/1/2026'	   927	    880.65
10	  '9/2/2026'	   927	    880.65
11	  '9/3/2026'	   927	    880.65
12	  '9/4/2026'	   927	    880.65


*/
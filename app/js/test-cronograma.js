const duracionmeses = 12;
const capital = 30900;
const fechainicio = "2025-05-10";
const interes = 5;


cuota = capital / duracionmeses
interes_mensual = (capital * interes) / 100 / duracionmeses
total_bruto = cuota + interes_mensual


function generarCronograma(capital, interes, duracionMeses, fechaInicio) {
    const cuotas = [];
    const interesDecimal = interes / 100;
    const cuotaBase = capital / duracionMeses;
    const interesMensual = capital * interesDecimal / duracionMeses;
    const totalBruto = cuotaBase + interesMensual;

    let fecha = new Date(fechaInicio);

    for (let i = 1; i <= duracionMeses; i++) {
        // Formatear fecha a dd/mm/yyyy
        const fechaStr = fecha.toLocaleDateString('es-ES');
        cuotas.push({
            cuota: i,
            fecha: fechaStr,
            total_bruto: totalBruto.toFixed(2),
            neto: (totalBruto * 0.95).toFixed(2) // Ejemplo: 5% de retención
        });
        // Sumar un mes
        fecha.setMonth(fecha.getMonth() + 1);
    }
    return cuotas;
}

// Ejemplo de uso:
const cronograma = generarCronograma(30900, 3, 12, "2025-05-10");
console.table(cronograma);




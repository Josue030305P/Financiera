function generarCronograma(capital, interes, duracionMeses, fechaInicio) {
  const cuotas = [];
  const interesDecimal = interes / 100;
  const cuotaBase = capital * interesDecimal;
  const totalBruto = cuotaBase - cuotaBase * 0.05; // Aplicando el 5% de retencion

  let fecha = new Date(fechaInicio);

  fecha.setMonth(fecha.getMonth() + 1); // **Incrementamos el mes para la primera cuota**

  for (let i = 1; i <= duracionMeses; i++) {
    let fechaPago = new Date(fecha);
    const diaInicioContrato = new Date(fechaInicio).getDate() + 1; // Obtenemos el día en cada iteración
    fechaPago.setDate(diaInicioContrato); // Establecemos el día del mes al día de inicio del contrato

    // Manejo de fin de mes: si el día de inicio es mayor que los días del mes actual
    if (fechaPago.getMonth() !== fecha.getMonth() && diaInicioContrato > 28) {
      fechaPago.setDate(0); // Retrocede al último día del mes anterior
    }

    // Formatear fecha a dd/mm/yyyy
    const fechaStr = fechaPago.toLocaleDateString("es-ES");
    console.log("FECHA STR:", fechaStr);
    cuotas.push({
      Cuota: i,
      Fecha: fechaStr,
      Total_Bruto: Number(cuotaBase.toFixed(2)),
      Total_Neto: totalBruto,
    });

    fecha.setMonth(fecha.getMonth() + 1);
  }
  return cuotas;
}

console.log('Hola gfg');

const cronograma = generarCronograma(30900, 3, 12, "2025-05-10");



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
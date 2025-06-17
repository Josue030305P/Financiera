<?php

require_once 'formatearFecha.php';


$datosContrato = $_SESSION['datos_contrato'];
$inversionista = $datosContrato['inversionista'];
$contrato = $datosContrato['contrato'];
$cronograma = $contrato['cronograma']; // Aquí están los cronograma_pagos
$tiporetorno = $inversionista['tiporetorno'];
$capital = $contrato['capital']; //  Usar directamente desde $contrato

$ultimaFechaCronograma = null;
if (!empty($cronograma)) {
    $ultimaFecha = end($cronograma)['fecha']; 
    $ultimaFechaCronograma = new DateTime($ultimaFecha);
}

$fechaDevolucionCapital = null;
if ($ultimaFechaCronograma) {
    $fechaDevolucionCapital = clone $ultimaFechaCronograma;
    $fechaDevolucionCapital->modify('+1 month');
    $fechaDevolucionCapital->setDate($fechaDevolucionCapital->format('Y'), $fechaDevolucionCapital->format('m'), 15);
}
$capitalFormateado = 'S/' . number_format($capital, 2, '.', ',');

?>
<div class="container">
    <h5 class="text-center underline uppercase">"Cronograma de Pago del Mutuatario al Mutuante"</h5>

    <div class="container-tables">
        <table class="uppercase bold pagos">
            <thead>
                <tr>
                    <th>Cuotas</th>
                    <th>Fecha de Pago</th>
                    <th>Total, Bruto (S/)</th>
                    <th>Total, Neto (-5%) (S/)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cronograma)): ?>
                    <?php foreach ($cronograma as $pago): ?>
                    <tr>
                        <td><?php echo $pago['numcuota']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($pago['fecha'])); ?></td>
                        <td>S/<?php echo number_format($pago['totalbruto'], 2, '.', ','); ?></td>
                        <td>S/<?php echo number_format($pago['totalneto'], 2, '.', ','); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay cronograma disponible</td>
                    </tr>
                <?php endif; ?>
                
                <?php if ($fechaDevolucionCapital): ?>
                <tr class="total-row">
                    <td></td>
                    <td><?php echo $fechaDevolucionCapital->format('d/m/Y'); ?></td>
                    <td><?php echo $capitalFormateado; ?></td>
                    <td>Devolución de Capital</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h5 class="text-center underline">"INFORMACIÓN DE "EL INVERSIONISTA"</h5>

        <table class="informacion-inversionista">
            <thead>
                <tr>
                    <th class="">NOMBRES Y APELLIDOS</th>
                    <th class="uppercase"><?php echo $inversionista['nombre']; ?></th>
                </tr>
            </thead>
            <tbody class="uppercase bold">
                <tr>
                    <td>DNI N° </td>
                    <td><?php echo $inversionista['documento']; ?></td>
                </tr>
                <tr>
                    <td>DOMICILIO</td>
                    <td><?php echo $inversionista['direccion']; ?></td>
                </tr>
                <?php 
                $ubicacion = explode(' - ', $inversionista['ubicacion']);
                ?>
                <tr>
                    <td>DISTRITO</td>
                    <td><?php echo $ubicacion[0] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>PROVINCIA</td>
                    <td><?php echo $ubicacion[1] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>DEPARTAMENTO</td>
                    <td><?php echo $ubicacion[2] ?? ''; ?></td>
                </tr>
                <tr>
                    <td>NACIONALIDAD</td>
                    <td>eruana</td>
                </tr>
                <tr>
                    <td>MONTO DE INVERSIÓN</td>
                    <td>S/<?php echo number_format($contrato['capital'], 2, '.', ','); ?></td>
                </tr>
                <tr>
                    <td>FECHA DE INVERSIÓN</td>
                    <td><?php echo fechaEnEspanol($inversionista['fechainicio']); ?></td>
                </tr>
                <tr>
                    <td>FECHA DE PAGO</td>
                    <td><?php echo fechaEnEspanol($cronograma[0]['fecha']); ?> - <?php echo fechaEnEspanol($cronograma[count($cronograma)-1]['fecha']); ?></td>
                </tr>
                <tr>
                    <td>TIPO DE INVERSIÓN</td>
                    <td><?php echo count($cronograma); ?> meses</td>
                </tr>
                <tr>
                    <td>PERIODO DE PAGO</td>
                    <td>MENSUAL</td>
                </tr>
                <tr>
                    <td>CANTIDAD DE PAGOS</td>
                    <td><?php echo count($cronograma); ?> pagos</td>
                </tr>
                <tr>
                    <td>RENTABILIDAD</td>
                    <td>5% cada mes</td>
                </tr>
                <tr>
                    <td>MONTO DE PAGO</td>
                    <td><?php echo $cronograma[0]['totalneto'];?> SOLES CADA MES</td>
                </tr>
                <?php if ($inversionista['banco']): ?>
                <tr>
                    <td>BANCO <?php echo strtoupper($inversionista['banco']); ?> SOLES</td>
                    <td><?php echo $inversionista['numcuenta']; ?></td>
                </tr>
                <tr>
                    <td>BANCO <?php echo strtoupper($inversionista['banco']); ?> CCI SOLES</td>
                    <td><?php echo $inversionista['cci']; ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <table class="firmas uppercase bold">
            <tbody>
                <tr>
                    <td>______________________</td>
                    <td>______________________</td>
                </tr>
                <tr>
                    <td class="mutuante">mutuante</td>
                    <td class="mutuatario">mutuatario</td>
                </tr>
                <tr>
                    <td><?php echo $inversionista['nombre']; ?></td>
                    <td>YHON KENNIDEY MENDOZA HUARACA</td>
                </tr>
                <tr>
                    <td><?php echo $inversionista['documento']; ?></td>
                    <td>dni n° 40971062</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
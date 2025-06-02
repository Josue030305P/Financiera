<?php

$jsonData = json_decode($_POST['jsonData'], true);

$inversionista = $jsonData['inversionista'];

?>

<div class="container">

    <h5 class="text-center">ANEXO N°1</h5>
    <h5 class="text-center">DECLARACIÓN JURADA DE ORIGEN DE FONDOS</h5>

    <p class="bold">Conforme lo establece la séptima disposición complementaria y modificatoria del DECRETO LEGISLATIVO
        N.º 1106,
        modificado por DECRETO LEGISLATIVO N°1249
    </p>

    <p>Yo, <strong class="uppercase"><?php echo $inversionista['nombre']  ?></strong>, identificado con el tipo de
        documento,<strong>DNI N°<?php echo $inversionista['documento'] ?></strong> , obrando en
        nombre propio de manera voluntaria y dando certeza de que todo lo aquí consignado es cierto, realizo la
        siguiente DECLARACION JURADA DE FUENTE U ORIGEN DE FONDOS a favor de <strong>YONDA & GRUPO HUARACA
            E.I.R.L.</strong>, con RUC
        <strong>20609396866</strong>; con el propósito dar cumplimiento a lo señalado al respecto en la séptima
        disposición
        complementaria y modificatoria del DECRETO LEGISLATIVO N.º 1106, modificado por DECRETO LEGISLATIVO N°1249.
    </p>

    <h5 class="text-left">DECLARO BAJO JURAMENTO LO SIGUIENTE:</h5>

    <div class="no-break">

        <ol>
            <li><?= htmlspecialchars($condicionesMutuante[2]['condicion']) ?></li>
            <li><?= htmlspecialchars($condicionesMutuante[3]['condicion']) ?></li>
            <li> <?= htmlspecialchars($condicionesMutuante[4]['condicion']) ?></li>
            <li><?=htmlspecialchars($condicionesMutuante[5]['condicion'])?>.</li>
     </ol>


    </div>

    <p>Realizo la presente declaración jurada manifiesto que la información proporcionada es verdadera y acepto la
        verificación de lo declarado. En señal de conformidad firmo el presente documento.
    </p>


    <p style="text-align: right;">Lima, <?= fechaEnEspanol(date('F'))?></p>

    <table class="firmas uppercase bold">
        <tbody>

            <tr>
                <td>______________________</td>

            </tr>

            <tr>
                <td><?php echo $inversionista['nombre']  ?></td>

            </tr>
            <tr>
                <td>dni n°<?php echo $inversionista['documento'] ?></td>
            </tr>
        </tbody>
    </table>











</div>
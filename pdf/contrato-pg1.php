<?php
// Obtener datos del inversionista
$nombre = getDato('inversionista', 'nombre');
$documento = getDato('inversionista', 'documento');
$direccion = getDato('inversionista', 'direccion');
$ubicacion = getDato('inversionista', 'ubicacion');
$banco = getDato('inversionista', 'banco');
$numcuenta = getDato('inversionista', 'numcuenta');
$cci = getDato('inversionista', 'cci');

// Obtener datos del contrato
$capital = getDato('contrato', 'capital');
$cronograma = getDato('contrato', 'cronograma');


// Función para convertir número a letras
function numeroALetras($numero) {
    $unidades = array('', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE');
    $decenas = array('', 'DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA');
    $especiales = array('ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE');
    $centenas = array('', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS');
    
    $numero = floatval($numero);
    $parte_entera = floor($numero);
    $parte_decimal = round(($numero - $parte_entera) * 100);
    
    if ($parte_entera == 0) {
        return 'CERO';
    }
    
    $texto = '';
    
    // Procesar miles
    if ($parte_entera >= 1000) {
        $miles = floor($parte_entera / 1000);
        if ($miles == 1) {
            $texto .= 'MIL ';
        } else {
            $texto .= numeroALetras($miles) . ' MIL ';
        }
        $parte_entera = $parte_entera % 1000;
    }
    
    // Procesar centenas
    if ($parte_entera >= 100) {
        $centena = floor($parte_entera / 100);
        if ($centena == 1 && $parte_entera == 100) {
            $texto .= 'CIEN ';
        } else {
            $texto .= $centenas[$centena] . ' ';
        }
        $parte_entera = $parte_entera % 100;
    }
    
    // Procesar decenas y unidades
    if ($parte_entera >= 10) {
        if ($parte_entera < 20) {
            $texto .= $especiales[$parte_entera - 11] . ' ';
            $parte_entera = 0;
        } else {
            $decena = floor($parte_entera / 10);
            $texto .= $decenas[$decena];
            $parte_entera = $parte_entera % 10;
            if ($parte_entera > 0) {
                $texto .= ' Y ';
            } else {
                $texto .= ' ';
            }
        }
    }
    
    // Procesar unidades
    if ($parte_entera > 0) {
        $texto .= $unidades[$parte_entera] . ' ';
    }
    
    return trim($texto);
}

$capitalLetras = numeroALetras($capital);
// var_dump($capitalLetras);
?>

<div class="container">
    <h4 class="text-center uppercase bold">CONTRATO DE MUTUO DINERARIO </h4>
    <p class="text-left bold">Lima, <?= date('d') ?> de <?= date('F') ?> de <?= date('Y') ?>.</p>

    <p>
      Conste por el presente documento, el contrato de Mutuo Dinerario que celebran:
      <strong class="uppercase"><?= htmlspecialchars($nombre) ?></strong> identificado con <strong class="uppercase">DNI <?= htmlspecialchars($documento) ?></strong>, 
      domicilio en <strong><?= htmlspecialchars($direccion) ?></strong>, 
      <?= htmlspecialchars($ubicacion) ?>, a quien en adelante se le denominará <strong>"EL MUTUANTE"</strong>; y, 
      <strong>EMPRESA YONDA & GRUPO HUARACA E.I.R.L </strong>con <strong>RUC 20609396866</strong> con domicilio en Calle Benavides N°1163 Puerta Cercado, distrito Chincha Alta, provincia de Chincha 
      y departamento de Ica, debidamente representada por su Gerente General Yhon Kennidey Mendoza Huaraca identificado con DNI N°40971062 con facultades inscritas en la Partida 
      Electrónica N° 11083166 del Registro de Personas Jurídicas de Ica, a quien en adelante se le denominará <strong>"EL MUTUATARIO "</strong>. 
      Las partes contractuales mencionadas previamente, encontrándose en perfectas condiciones físicas y psicológicas; podrán ser referidas en su conjunto como <strong>"LAS PARTES"</strong>, 
      quienes se someten a los términos y condiciones que a continuación se describen:
    </p>

    <h5 class="text-left underline bold">CLÁUSULAS GENERALES</h5>
    <h5 class="text-left underline bold">PRIMERA. - OBJETO DEL CONTRATO</h5>

    <p>Por el presente contrato, <strong>EL MUTUATARIO</strong> se obliga a entregar en calidad de garantía de una letra de cambio a favor de <strong>EL MUTUANTE</strong>; 
      <strong>EL MUTUANTE</strong> a su vez se obliga a entregar el monto de <strong>S/<?= number_format($capital, 2) ?> (<?= $capitalLetras ?> SOLES)</strong>; para que <strong>MUTUATARIO</strong> 
      lo destine a los fines que considere convenientes.
    </p>

    <p><strong>EL MUTUATARIO</strong>, <?=  htmlspecialchars($condicionesMutuatario[0]['condicion'])?></p>

    <p><strong>EL MUTUATARIO</strong> declara que conoce la tasa de rentabilidad mensual que pagará a favor del <strong>MUTUANTE</strong> y se encuentra conforme respecto de la misma, en todos sus aspectos; 
      y se compromete a mantener indemne a <strong>EL MUTUANTE</strong> respecto de cualquier acción de tipo civil o penal que tenga relación a la misma. 
      Es meritorio mencionar que el presente contrato puede ser renovado únicamente por acuerdo de partes, previa comunicación con un plazo anticipado de 30 días calendarios; con las nuevas
      especificaciones que se requieran.
    </p>

    <h5 class="text-left underline bold">SEGUNDA. - RENTABILIDAD</h5>
    <p class="uppercase bold">EL MUTUATARIO ACUERDA PAGAR UNA RENTABILIDAD MENSUAL DE 5% SOBRE EL VALOR DEL CAPITAL.</p>
    <p>Las partes acuerdan una rentabilidad del 5% mensual calculado sobre el capital (monto del mutuo).</p>

    <h5 class="text-left underline bold">TERCERA. - DEVOLUCIÓN DEL MUTUO Y RENTABILIDAD</h5>
    <p><strong>EL MUTUATARIO</strong> <?=  htmlspecialchars($condicionesMutuatario[1]['condicion'])?> siendo de 
      <strong>S/<?= number_format($capital, 2) ?> (<?= $capitalLetras ?> SOLES)</strong>, más la rentabilidad mensual en los plazos y en las fechas indicadas en el <strong class="underline">"Cronograma de Pago del Mutuatario al Mutuante"</strong>.
    </p>

    <p>Las partes acuerdan que todos los pagos contemplados en el presente contrato que <strong>EL MUTUATARIO</strong> debe realizar a favor de <strong>EL MUTUANTE </strong>se harán únicamente en la misma moneda en la que se realizó el desembolso, adicionando un plazo de 04 días por 
      retrasos administrativos que puedan presentarse y a la Cuenta del Banco <strong><?= $banco ?> N° DE CUENTA: <?= $numcuenta ?> y CCI: <?= $cci ?></strong> (Cuenta de abono) a nombre de <strong>EL/LOS MUTUANTE/S.</strong>
    </p>
</div>















<!-- 

  <div class="container">
    <h4 class="text-center uppercase bold">CONTRATO DE MUTUO DINERARIO </h4>
    <p class="text-left bold">Lima, 24 de septiembre de 2024.</p>

    <p>
      Conste por el presente documento, el contrato de Mutuo Dinerario que celebran:
      <strong class="uppercase">YAGUILLO ALIAGA FRANCHESCA BRILLITTE</strong> identificado con <strong>DNI N°70781463</strong>, domicilio en <strong>MZ.D LT.3-C SECTOR EL CALICHE FUNDO COPACABANA</strong>, 
      departamento de Lima, provincia de Lima, distrito de Puente Piedra, a quien en adelante se le denominará <strong>“EL MUTUANTE”</strong>; y, 
      <strong>EMPRESA YONDA & GRUPO HUARACA E.I.R.L </strong>con <strong>RUC 20609396866</strong> con domicilio en Calle Benavides N°1163 Puerta Cercado, distrito Chincha Alta, provincia de Chincha 
      y departamento de Ica, debidamente representada por su Gerente General Yhon Kennidey Mendoza Huaraca identificado con DNI N°40971062 con facultades inscritas en la Partida 
      Electrónica N° 11083166 del Registro de Personas Jurídicas de Ica, a quien en adelante se le denominará <strong>“EL MUTUATARIO “</strong>. 
      Las partes contractuales mencionadas previamente, encontrándose en perfectas condiciones físicas y psicológicas; podrán ser referidas en su conjunto como <strong>“LAS PARTES”</strong>, 
      quienes se someten a los términos y condiciones que a continuación se describen:
    </p>

    <h5 class="text-left underline bold">CLÁUSULAS GENERALES</h5>
    <h5 class="text-left underline bold">PRIMERA. - OBJETO DEL CONTRATO</h5>

    <p>Por el presente contrato, <strong>EL MUTUATARIO</strong> se obliga a entregar en calidad de garantía de una letra de cambio a favor de <strong>EL MUTUANTE</strong>; 
      <strong>EL MUTUANTE</strong> a su vez se obliga a entregar el monto de <strong>S/65,000.00 (SESENTA Y CINCO MIL SOLES)</strong>; para que <strong>MUTUATARIO</strong> 
      lo destine a los fines que considere convenientes.
    </p>

    <p><strong>EL MUTUATARIO</strong>, por su parte, se obliga a devolver a <strong>EL MUTUANTE</strong> la referida suma de dinero en la forma y oportunidad pactadas en el presente documento.</p>

    <p><strong>EL MUTUATARIO</strong> declara que conoce la tasa de rentabilidad mensual que pagará a favor del <strong>MUTUANTE</strong> y se encuentra conforme respecto de la misma, en todos sus aspectos; 
      y se compromete a mantener indemne a <strong>EL MUTUANTE</strong> respecto de cualquier acción de tipo civil o penal que tenga relación a la misma. 
      Es meritorio mencionar que el presente contrato puede ser renovado únicamente por acuerdo de partes, previa comunicación con un plazo anticipado de 30 días calendarios; con las nuevas
      especificaciones que se requieran.
    </p>

    <h5 class="text-left underline bold">SEGUNDA. - RENTABILIDAD</h5>
    <p class="uppercase bold">EL MUTUATARIO ACUERDA PAGAR UNA RENTABILIDAD MENSUAL DE 5% SOBRE EL VALOR DEL CAPITAL.</p>
    <p>Las partes acuerdan una rentabilidad del 5% mensual calculado sobre el capital (monto del mutuo).</p>

    <h5 class="text-left underline bold">TERCERA. - DEVOLUCIÓN DEL MUTUO Y RENTABILIDAD</h5>
    <p><strong>EL MUTUATARIO</strong> está obligado a devolver a <strong>EL MUTUANTE</strong> la suma del monto de capital invertido siendo de 
      <strong>S/65,000.00 (SESENTA Y CINCO MIL SOLES)</strong>, más la rentabilidad mensual en los plazos y en las fechas indicadas en el <strong class="underline ">“Cronograma de Pago del Mutuatario al Mutuante”</strong>.
    </p>

    <p>Las partes acuerdan que todos los pagos contemplados en el presente contrato que <strong>EL MUTUATARIO</strong> debe realizar a favor de <strong>EL MUTUANTE </strong>se harán únicamente en la misma moneda en la que se realizó el desembolso, adicionando un plazo de 04 días por 
      retrasos administrativos que puedan
       presentarse y a la Cuenta del Banco <strong>INTERBANK N° DE CUENTA: 4023378557116 y CCI: 8983383650927</strong> (Cuenta de abono) a nombre de <strong>EL/LOS MUTUANTE/S.</strong>
    </p>

    

  </div> -->



 

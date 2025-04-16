<?php

$nombre = getDato('inversionista', 'nombre');
$documento = getDato('inversionista', 'documento');
$capital = getDato('inversion', 'capital');
$moneda = getDato('inversion', 'moneda');
$fechaInicio = getDato('inversion', 'fechaInicio');
?>

<div class="container">
    <h4 class="text-center uppercase bold">CONTRATO DE MUTUO DINERARIO </h4>
    <p class="text-left bold">Lima, 24 de septiembre de 2024.</p>

    <p>
      Conste por el presente documento, el contrato de Mutuo Dinerario que celebran:
      <strong class="uppercase"><?= htmlspecialchars($nombre) ?></strong> identificado con <strong class="uppercase">DNI <?= htmlspecialchars($documento) ?></strong>, domicilio en <strong>MZ.D LT.3-C SECTOR EL CALICHE FUNDO COPACABANA</strong>, 
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



 

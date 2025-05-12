<?php
$nombre_conyuge = getDato('inversionista', 'nombre_conyuge');
$dni_conyuge = getDato('inversionista', 'dni_conyuge');
?>

<div class="container">
  <p>El monto del capital debe ser retornado de acuerdo con los plazos estipulados en
    el <strong class="underline">"Cronograma de Pago del Mutuatario al Mutuante"</strong>, adicionando a
    este un plazo de 15 días
    hábiles por retrasos
    administrativos que puedan presentarse.</p>

  <p>Asimismo, se establece que, en caso de fallecimiento del <strong>MUTUANTE</strong>, se deberán
    realizar pagos a la persona autorizada, que en el presente caso <strong><?= $nombre_conyuge ? strtoupper($nombre_conyuge) : 'NO ESPECIFICADO' ?></strong>
    identificado con <strong>DNI N°<?= $dni_conyuge ? $dni_conyuge : 'NO ESPECIFICADO' ?></strong>; para proceder debe presentarse
    la documentación que sustentaría el hecho. </p>

  <h5 class="text-left underline bold">CUARTO. - RESOLUCIÓN DE CONTRATO</h5>
  <p>La resolución del presente contrato puede darse en el escenario que, <strong>EL MUTUATARIO</strong> recaiga en
    el incumplimiento total o parcial de las cuotas descritas en el <strong class="underline">“Cronograma de Pago del
      Mutuatario
      al Mutuante”</strong>; en tal caso EL <strong>MUTUANTE</strong> actuará en pleno derecho y automáticamente se
    resolverá el
    presente contrato de conformidad a lo dispuesto en el artículo 1430 del Código Civil, dando por
    vencidos todos los plazos para obtener la cancelación total del capital adeudado, más los gastos
    correspondientes.</p>

  <h5 class="text-left underline bold"> QUINTA. - OBLIGACIONES</h5>
  
    <div class="no-break">
      <p class="text-left"><strong>EL MUTUATARIO</strong> se obliga a:</p>
      <ol>
        <li>Pagar puntualmente las cuotas acordadas de la forma y en los plazos señalados en el <strong
            class="underline">“Cronograma de Pago del Mutuatario al Mutuante”</strong></li>
      </ol>

      <p class="text-left"><strong>EL MUTUANTE</strong> se obliga:</p>
      <ol>
        <li>Cumplir con la presentación de documentos contables requeridos, referente a sus facturas de renta de segunda
          categoría.</li>
        <li>Informar al MUTUATARIO cualquier situación referente a sus cuentas bancarias a recibir su rentabilidad con
          anticipación.</li>
      </ol>
    </div>

    <h5 class="text-left underline ">SEXTA. - VALIDEZ DEL ACTO JURÍDICO</h5>
    <p>Las partes dejan expresa constancia que en el presente contrato no ha mediado error, dolo, fraude, lesión o intimidación alguna, renunciando desde ahora a toda acción o excepción que tienda a invalidarlo, así como a los plazos para interponerlo. </p>
    <h5 class="text-left underline">SEPTIMA. - GASTOS Y TRIBUTOS</h5>
    Todos los gastos y tributos que se devenguen del presente contrato, así como los notariales y registrales, los que sean necesarios para la inscripción del presente contrato, serán verificados por las partes; previo acuerdo de las mismas.
    <h5 class="text-left underline"> OCTAVA. - INTEGRIDAD Y VALIDEZ DEL CONTRATO</h5>
    <p>El presente Contrato constituye el acuerdo íntegro al que han llegado las partes y tendrá efecto obligatorio para los mismos, sus sucesores y cesionarios, no pudiendo ser modificado verbalmente, sino mediante un instrumento escrito firmado por estas. Este contrato prevalece sobre cualquier acuerdo, borrador, acuerdo verbal o entendimiento previo entre las partes relacionadas con este objeto. </p>
    <p>Asimismo, se establece que el plazo del presente contrato comenzará a correr al día siguiente de la firma del mismo.
    </p>
  

</div>
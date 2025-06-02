<?php

function fechaEnEspanol($fecha) {
    $meses = [
        'January' => 'enero',
        'February' => 'febrero', 
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    ];
    
    $dias = [
        'Monday' => 'lunes',
        'Tuesday' => 'martes',
        'Wednesday' => 'miércoles',
        'Thursday' => 'jueves',
        'Friday' => 'viernes',
        'Saturday' => 'sábado',
        'Sunday' => 'domingo'
    ];
    

    $fechaFormateada = date('j \d\e F \d\e\l Y', strtotime($fecha));
    

    foreach ($meses as $ingles => $espanol) {
        $fechaFormateada = str_replace($ingles, $espanol, $fechaFormateada);
    }
    
    return $fechaFormateada;
}
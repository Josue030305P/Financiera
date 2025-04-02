<?php
if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Pais.php';

    $pais = new Pais();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            echo json_encode($pais->getAll());
            break;
        }
    
    
    
    }
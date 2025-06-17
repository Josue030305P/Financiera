<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/PersonaUsuario.php';

    $personaUsuario = new PersonaUsuario();

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'POST':
            $input = file_get_contents('php://input');
            $dataJSON = json_decode($input, true);


            $registro = [
                'idpais'    => htmlspecialchars($dataJSON['idpais']),
                'apellidos'     => htmlspecialchars($dataJSON['apellidos']),
                'nombres'     => htmlspecialchars($dataJSON['nombres']),
                'fechanacimiento' => htmlspecialchars($dataJSON['fechanacimiento']),
                'tipodocumento' => htmlspecialchars($dataJSON['tipodocumento']),
                'numdocumento' => htmlspecialchars($dataJSON['numdocumento']),
                'email' => htmlspecialchars($dataJSON['email']),
                'telprincipal' => htmlspecialchars($dataJSON['telprincipal']),
                'domicilio' => htmlspecialchars($dataJSON['domicilio']) ?? null
            ];

            try {


                $result = $personaUsuario->add($registro);


                echo json_encode($result);
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error interno del servidor: " . $e->getMessage()
                ]);
            }
            break;
    }
}

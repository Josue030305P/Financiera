<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../models/Login.php';

$login = new Login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['usuario']) && isset($_POST['passworduser'])) {
        try {
            // Llamada al método login con los datos de usuario y contraseña
            $result = $login->login([
                'usuario'      => $_POST['usuario'],
                'passworduser' => $_POST['passworduser']
            ]);

            if ($result['success']) {
                // Si el login fue exitoso, guardar el nombre y redirigir
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['idusuario'] = $result['idusuario']; 
                echo json_encode(['success' => true, 'redirect' => '../', 'idusuario' => $result['idusuario']]);
            } else {
                // Si las credenciales son incorrectas
                echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
            }
        } catch (Exception $e) {
            // Manejo de errores
            echo json_encode([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    } else {
        // Si faltan campos en el formulario
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos requeridos',
            'received' => $_POST
        ]);
    }
    exit();
}

// Si no es una solicitud POST
echo json_encode(['success' => false, 'message' => 'Método no permitido']);
exit();




// session_start();
// header('Content-Type: application/json; charset=utf-8');

// require_once '../models/Login.php';


// $login = new Login();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['usuario']) && isset($_POST['passworduser'])) {
//         try {
            
//             $result = $login->login([
//                 'usuario'      => $_POST['usuario'],
//                 'passworduser' => $_POST['passworduser']
//             ]);

//             if ($result['success']) {
//                 $_SESSION['nombre'] = $result['nombre'];
//                 echo json_encode(['success' => true, 'redirect' => '../']);
//             } else {
//                 echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
//             }
//         } catch (Exception $e) {
//             echo json_encode([
//                 'success' => false,
//                 'message' => 'Error en el servidor: ' . $e->getMessage()
//             ]);
//         }
//     } else {
//         echo json_encode([
//             'success' => false,
//             'message' => 'Faltan campos requeridos',
//             'received' => $_POST 
//         ]);
//     }
//     exit();
// }

// echo json_encode(['success' => false, 'message' => 'Método no permitido']);
// exit();

<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../models/Login.php';

$login = new Login();

// Comprobar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar si la solicitud es para login
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
    } 
    
    // Verificar si la solicitud es para logout
    elseif (isset($_POST['logout']) && $_POST['logout'] == true) {
        try {
            // Verificar si hay una sesión activa
            if (isset($_SESSION['idusuario'])) {
                // Llamada al método cerrarSesion
                $login->cerrarSesion($_SESSION['idusuario']);
                // Destruir la sesión
                session_unset();
                session_destroy();

                echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No hay sesión activa']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error al cerrar sesión: ' . $e->getMessage()]);
        }
    } 

    else {
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

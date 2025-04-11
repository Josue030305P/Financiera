<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../models/Login.php';

$login = new Login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    if (isset($_POST['usuario']) && isset($_POST['passworduser'])) {
        try {
            
            $result = $login->login([
                'usuario'      => $_POST['usuario'],
                'passworduser' => $_POST['passworduser']
            ]);

            if ($result['success']) {
                
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['idusuario'] = $result['idusuario']; 
                echo json_encode(['success' => true, 'redirect' => '../', 'idusuario' => $result['idusuario']]);
            } else {
                
                echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
            }
        } catch (Exception $e) {
        
            echo json_encode([
                'success' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ]);
        }
    } 
    
    
    elseif (isset($_POST['logout']) && $_POST['logout'] == true) {
        try {
            
            if (isset($_SESSION['idusuario'])) {
             
                $login->cerrarSesion($_SESSION['idusuario']);
               
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
  
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos requeridos',
            'received' => $_POST
        ]);
    }

    exit();
}


echo json_encode(['success' => false, 'message' => 'Método no permitido']);
exit();

<?php
define('UPLOAD_PROFILE_DIR', '../../public/uploads/fotoperfil/');
define('WEB_PROFILE_DIR', 'uploads/fotoperfil/');

if (isset($_SERVER['REQUEST_METHOD'])) {

    header('Content-Type: application/json; charset=utf-8');

    require_once '../models/Usuario.php';

    $usuario = new Usuario();

    if (!is_dir(UPLOAD_PROFILE_DIR)) {
        mkdir(UPLOAD_PROFILE_DIR, 0775, true);
    }


    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':



            try {
                $resultados = $usuario->getColaboradorToUsuario();
                echo json_encode(
                    $resultados
                );
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al obtener el colaborador que pasara a ser usuario ' . $e->getMessage()
                ]);
            }

            break;


        case 'POST':
            // Recoger datos del formulario (vía POST normal, no JSON)
            $idcolaborador = $_POST['idcolaborador'];
            $nombreUsuarioForm = $_POST['usuario'];
            $passworduser = $_POST['password'];

            // Hashear la contraseña
            $passwordHasheado = password_hash($passworduser, PASSWORD_BCRYPT);

            // Subida de imagen de perfil
            $ruta_foto_guardada = null;
            if (isset($_FILES['fotoperfil']) && $_FILES['fotoperfil']['error'] === UPLOAD_ERR_OK) {
                $tmpPath = $_FILES['fotoperfil']['tmp_name'];
                $nombreOriginal = $_FILES['fotoperfil']['name'];
                $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
                $nuevoNombre = uniqid($nombreUsuarioForm) . '.' . $extension;
                $destino = UPLOAD_PROFILE_DIR . $nuevoNombre;

                if (move_uploaded_file($tmpPath, $destino)) {
                    $ruta_foto_guardada = WEB_PROFILE_DIR . $nuevoNombre;
                } else {
                    echo json_encode(['status' => false, 'message' => 'Error al guardar la foto de perfil.']);
                    exit;
                }
            }

            // Registro final
            $registro = [
                'idcolaborador' => htmlspecialchars($idcolaborador),
                'usuario'   => htmlspecialchars($nombreUsuarioForm),
                'passworduser' => $passwordHasheado,
                'fotoperfil' => $ruta_foto_guardada
            ];


            try {
                $result = $usuario->add($registro);
                echo json_encode(
                    $result
                );
            } catch (Exception $e) {
                echo json_encode([
                    "status" => false,
                    "message" => "Error interno: " . $e->getMessage()
                ]);
            }

            break;
    }
}

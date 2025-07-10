<?php require_once 'config.php'; ?>
<?php

if (!isset($_SESSION['nombre'])) {
    header('Location:../');
    exit();
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
   
#logoutBtn {

    border: none; 
    cursor: pointer; 
    font-size: 16px; 
    padding: 8px; 
    border-radius: 5px; 
    transition: background-color 0.3s ease; 
    color: #dc3545; 
}

#logoutBtn:hover {
    background-color: rgba(220, 53, 69, 0.1); 
}

#logoutBtn i {
    margin-right: 8px; 
}
</style>
<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="/" class="logo-wrapper" title="Home">
                <span class="sr-only">Home</span>
                <span class="icon" aria-hidden="true">
                    <img src="<?= BASE_URL ?>app/img/png/logo2.jpeg" alt="" width="50px" height="50px"
                        style="margin-right: 10px;border-radius: 8px;">
                </span>
                <div class="logo-text">
                    <span class="logo-title">Yonda</span>
                    
                </div>
            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>

        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                <li><a href="<?= BASE_URL ?>app/"><i class="fas fa-home" style="margin-right: 8px;"></i>Dashboard</a>
                </li>

                <li><a href="<?= BASE_URL ?>app/views/leads/"><i class="fas fa-user-plus"
                            style="margin-right: 8px;"></i>Leads</a></li>

                <li><a href="<?= BASE_URL ?>app/views/contratos/"><i class="fas fa-file-contract"
                            style="margin-right: 8px;"></i>Contratos</a></li>

                <li><a href="<?= BASE_URL ?>app/views/inversionistas/"><i class="fas fa-user-tie"
                            style="margin-right: 8px;"></i>Inversionista</a></li>

                <li><a href="<?= BASE_URL ?>app/views/contactibilidad/"><i class="fas fa-address-book"
                            style="margin-right: 8px;"></i>Contactos</a></li>

                <li><a href="<?= BASE_URL ?>app/views/cronograma-pagos/"><i class="fas fa-calendar-alt"
                            style="margin-right: 8px;"></i>Cronogramas</a></li>

                <li><a href="<?= BASE_URL ?>app/views/estadistica/estadistica-leads"><i class="fas fa-chart-line"
                            style="margin-right: 8px;"></i>Estádisticas</a></li>

                <li><a href="<?= BASE_URL ?>app/views/usuarios/"><i class="fas fa-user-cog"
                            style="margin-right: 8px;"></i>Agregar usuario</a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar-footer" style="margin-top: 10px;">
        <a href="#" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture>
                    <source srcset="<?= BASE_URL . 'public/' . $_SESSION['fotoperfil'] ?>">
                    <img src="<?= BASE_URL . 'public/' . $_SESSION['fotoperfil'] ?>" alt="Foto de perfil"
                        style="width: 100px; height: 50px; object-fit: cover; object-position: center top; border-radius: 50%;">
                </picture>
            </span>
            <div class="sidebar-user-info">
                <span class="sidebar-user__title"><?= $_SESSION['nombre'] ?></span>
            </div>
        </a>

        <div class="logout-wrapper">
            <button id="logoutBtn" style="color: #dc3545; display: flex; align-items: center;">
                <i class="fas fa-door-open" style="margin-right: 8px;"></i>
                <span>Cerrar sesión</span>
            </button>
        </div>

    </div>
</aside>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('logoutBtn').addEventListener('click', () => {

        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Quieres cerrar sesión?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                fetch('<?= BASE_URL ?>app/controllers/LoginController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        logout: 'true'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {

                            Swal.fire({
                                title: '¡Sesión cerrada!',
                                text: 'Has cerrado sesión exitosamente.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location.href = '<?= BASE_URL ?>';
                            });
                        } else {

                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Intentar nuevamente'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al cerrar sesión:', error);

                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al cerrar la sesión.',
                            icon: 'error',
                            confirmButtonText: 'Intentar nuevamente'
                        });
                    });
            } else {

                Swal.fire('Cancelado', 'La sesión no se cerró.', 'info');
            }
        });
    });
</script>
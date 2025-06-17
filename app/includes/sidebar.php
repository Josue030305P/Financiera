<?php require_once 'config.php'; ?>
<?php

if (!isset($_SESSION['nombre'])) {
    header('Location:../');
    exit();
}

?>

<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="/" class="logo-wrapper" title="Home">
                <span class="sr-only">Home</span>
                <span class="icon" aria-hidden="true"><img src="<?= BASE_URL?>app/img/png/yonda_peru_logo.jpeg" alt="" width="50px" height="50px" style="margin-right: 10px;border-radius: 8px;"></span>
                <div class="logo-text">
                    <span class="logo-title">Yonda</span>
                    <span class="logo-subtitle">Leads</span>
                </div>

            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-body-menu">

            <li>
                    <a class="" href="<?= BASE_URL ?>app/"><span class="icon document"
                            aria-hidden="true"></span>Dashboard</a>
                </li>
                <li>
                    <a class="" href="<?= BASE_URL ?>app/views/leads/"><span class="icon user-white"
                            aria-hidden="true"></span>Leads</a>
                </li>

                 <li>
                    <a class="" href="<?= BASE_URL ?>app/views/contratos/"><span class="icon document"
                            aria-hidden="true"></span>Contratos</a>
                </li>

                 <li>
                    <a class="" href="<?= BASE_URL ?>app/views/inversionistas/"><span class="icon user-white"
                            aria-hidden="true"></span>Inversionista</a>
                </li>
                


<!-- 
                 <li>
                    <a class="" href="<?= BASE_URL ?>app/views/detallegarantias/"><span class="icon document"
                            aria-hidden="true"></span>Detalle garantías</a>
                </li> -->

                 <li>
                    <a class="" href="<?= BASE_URL ?>app/views/contactibilidad/"><span class="icon user-white"
                            aria-hidden="true"></span>Lista de contactos</a>
                </li>

                 <li>
                    <a class="" href="<?= BASE_URL ?>app/views/cronograma-pagos/"><span class="icon document"
                            aria-hidden="true"></span>Lista de cronogramas</a>
                </li>

                <li>
                    <a class="" href="<?= BASE_URL ?>app/views/usuarios/"><span class="icon user-white"
                            aria-hidden="true"></span>Agregar usuario</a>
                </li>

                <!-- <li>
                    <a class="" href="<?= BASE_URL ?>app/views/contratos/historial.php"><span class="icon document"
                            aria-hidden="true"></span>Historial de contratos</a>
                </li> -->

<!-- 
                 <li>
                    <a class="" href="<?= BASE_URL ?>app/views/detallepagos/"><span class="icon document"
                            aria-hidden="true"></span>Detalle de pagos</a>
                </li> -->




                
                

               
                
            </ul>


        </div>
    </div>
    <div class="sidebar-footer">
        <a href="#" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture>
                    <source srcset="<?= BASE_URL ?>app/img/avatar/avatar-illustrated-04.webp" type="image/webp"><img
                        src="<?= BASE_URL ?>app/img/avatar/avatar-illustrated-04.png" alt="User name">
                </picture>
            </span>
            <div class="sidebar-user-info">
                <span class="sidebar-user__title"><?= $_SESSION['nombre'] ?></span>
            
            </div>
        </a>

        <div class="logout-wrapper">
            <button id="logoutBtn" class="logout-btn">

                <span>Cerrar sesión</span>
            </button>
        </div>

    </div>
</aside>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('logoutBtn').addEventListener('click',  () => {

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
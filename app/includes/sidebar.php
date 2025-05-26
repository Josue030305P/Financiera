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
                <span class="icon logo" aria-hidden="true"></span>
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
                    <a class="active" href="<?= BASE_URL ?>app"><span class="icon user-white" aria-hidden="true"></span>Leads</a>
                </li>
                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon document" aria-hidden="true"></span>Contratos
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">

                        <li>
                            <a href="<?= BASE_URL ?>app/views/contratos/">Lista de contratos</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn" href="./views//inversionistas/inversionistas-list.html">
                        <span class="icon user-white" aria-hidden="true"></span>Inversionistas
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="<?= BASE_URL ?>app/views/inversionistas/">Lista de inversionistas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon image" aria-hidden="true"></span>Contactibilidad
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="<?= BASE_URL . "app/views/contactibilidad/" ?>">Lista de contactos</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon paper" aria-hidden="true"></span>Cronograma Pagos
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="<?= BASE_URL . "app/views/cronograma-pagos/" ?>">Lista de cronogramas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= BASE_URL . "app/views/detallepagos/" ?>">
                        <span class="icon message" aria-hidden="true"></span>
                        Detalle de pagos
                    </a>

                </li>
            </ul>
            <span class="system-menu__title">system</span>
            <ul class="sidebar-body-menu">
                <li>
                    <a href="appearance.html"><span class="icon edit" aria-hidden="true"></span>Appearance</a>
                </li>
                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon category" aria-hidden="true"></span>Extentions
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="extention-01.html">Extentions-01</a>
                        </li>
                        <li>
                            <a href="extention-02.html">Extentions-02</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon user-3" aria-hidden="true"></span>Users
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="users-01.html">Users-01</a>
                        </li>
                        <li>
                            <a href="users-02.html">Users-02</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="##"><span class="icon setting" aria-hidden="true"></span>Settings</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-footer">
        <a href="##" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture>
                    <source srcset="<?= BASE_URL ?>app/img/avatar/avatar-illustrated-04.webp" type="image/webp"><img src="<?= BASE_URL ?>app/img/avatar/avatar-illustrated-04.png" alt="User name">
                </picture>
            </span>
            <div class="sidebar-user-info">
                <span class="sidebar-user__title"><?= $_SESSION['nombre'] ?></span>
                <span class="sidebar-user__subtitle">Soporte</span>
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
    document.getElementById('logoutBtn').addEventListener('click', function() {

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
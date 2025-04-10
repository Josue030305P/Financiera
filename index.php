<?php require_once __DIR__ . "/app/includes/config.php"; ?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elegant Dashboard | Sign In</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="<?= BASE_URL ?>app/css/style.css">
</head>

<body>
  <div class="layer"></div>
  <main class="page-center">
    <article class="sign-up">
      <h1 class="sign-up__title">BIENVENIDO</h1>
      <p class="sign-up__subtitle">Inicia sesión en tu cuenta para continuar</p>
      <form class="sign-up-form form" id="loginForm" method="POST">
        <label class="form-label-wrapper">
          <p class="form-label">Nombre de usuario</p>
          <input class="form-input" type="text" placeholder="Ingresa tu nombre de usuario" required="true"
            name="usuario">
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Constraseña</p>
          <input class="form-input" type="password" placeholder="Ingresa tu contraseña" required="true"
            name="passworduser">
        </label>
        <a class="link-info forget-link" href="##">No recuerdas tu contraseña?</a>
        <a class="link-info forget-link" style="display: block;" href="<?= BASE_URL ?>signup">Registrarse</a>
        <label class="form-checkbox-wrapper">
          <input class="form-checkbox" type="checkbox" required>
          <span class="form-checkbox-label">Recordarme</span>
        </label>
        <button class="form-btn primary-default-btn transparent-btn">Inicar Sesión</button>
      </form>
    </article>
  </main>




  <script>
    document.getElementById('loginForm').addEventListener('submit', function (e) {
      e.preventDefault();

      fetch('<?= BASE_URL ?>app/controllers/LoginController', {
        method: 'POST',
        body: new FormData(this)
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Guardar el idusuario en el sessionStorage (opcional)
            sessionStorage.setItem('idusuario', data.idusuario);

            // Mostrar mensaje de éxito
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Inicio de sesión exitoso',
              showConfirmButton: false,
              timer: 2000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
              }
            });
            setTimeout(() => {
              window.location.href = '<?= BASE_URL ?>app/';
            }, 2000);
          } else {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'error',
              title: data.message || 'Credenciales incorrectas',
              showConfirmButton: false,
              timer: 2000,
              timerProgressBar: true
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al procesar la solicitud');
        });
    });

  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Chart library -->
  <script src="/plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="plugins/feather.min.js"></script>
  <!-- Custom scripts -->
  <script src="js/script.js"></script>
</body>
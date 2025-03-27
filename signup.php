<?php require_once __DIR__ . "/app/includes/config.php"; ?>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elegant Dashboard | Sign Up</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="<?= BASE_URL?>app/css/style.css">
</head>

<body>
  <div class="layer"></div>
<main class="page-center">
  <article class="sign-up">
    <h1 class="sign-up__title">Empezar</h1>
    <p class="sign-up__subtitle">Empieza creando tu cuenta de una vez</p>
    <form class="sign-up-form form" action="" method="">
      <label class="form-label-wrapper">
        <p class="form-label">Nombre</p>
        <input class="form-input" type="text" placeholder="Enter your name" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Team</p>
        <input class="form-input" type="email" placeholder="Enter your Team name" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Correo</p>
        <input class="form-input" type="email" placeholder="Enter your email" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Contraseña</p>
        <input class="form-input" type="password" placeholder="Enter your password" required>
      </label>
      <label class="form-checkbox-wrapper">
        <input class="form-checkbox" type="checkbox" required>
        <span class="form-checkbox-label">Recordarme</span>
      </label>
      <button class="form-btn primary-default-btn transparent-btn">Sign in</button>
    </form>
  </article>
</main>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

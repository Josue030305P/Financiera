
<?php require_once __DIR__ . "/../../includes/header.php"; ?>
<?php require_once __DIR__ . "/../../includes/config.php"; ?>

<body>

    <div class="page-flex">

        <?php require_once __DIR__ . "/../../includes/sidebar.php"; ?>

        <div class="main-wrapper">

            <?php require_once __DIR__ . "/../../includes/navbar.php"; ?>

            <?php 
              $tipo = "Inversionistas";
              require_once __DIR__ . "/../../includes/table.php"  
            ?>
        </div>

    </div>



    <!-- Chart library -->
  <script src="<?= BASE_URL ?>app/plugins/chart.min.js"></script>

  <!-- Icons library -->
  <script src="<?= BASE_URL ?>app/plugins/feather.min.js"></script>

  <!-- Custom scripts -->
  <script src="<?= BASE_URL ?>app/js/script.js"></script>





</body>
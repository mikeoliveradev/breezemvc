<!DOCTYPE html>
<html lang="es">
<?php 
$pageTitle = 'Registro - BreezeMVC';
$pageDescription = 'Crea tu cuenta en BreezeMVC';
require_once __DIR__ . '/../head.php'; 
?>
<body>
  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-expand-lg navbar-end navbar-absolute-top navbar-light navbar-show-hide"
          data-hs-header-options='{
            "fixMoment": 0,
            "fixEffect": "slide"
          }'>
    <div class="container">
      <?php require_once __DIR__ . '/../nav.php'; ?>
    </div>
  </header>
  <!-- ========== END HEADER ========== -->

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
    <?php
    use src\utils\ComponentHelper;

    ComponentHelper::render('auth/register-form', [
        'title' => 'Crear Cuenta',
        'subtitle' => 'Completa el formulario para comenzar',
        'action' => '/auth/registerPost',
        'error' => $error ?? null,
        'privacyUrl' => '/privacy',
        'loginUrl' => '/auth/login'
    ]);
    ?>
  </main>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- ========== FOOTER ========== -->
  <?php require_once __DIR__ . '/../footer.php'; ?>
  <!-- ========== END FOOTER ========== -->

  <!-- ========== SCRIPTS ========== -->
  <?php require_once __DIR__ . '/../javascripts.php'; ?>
  <!-- ========== END SCRIPTS ========== -->
</body>
</html>

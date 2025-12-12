<!DOCTYPE html>
<html lang="es">
<?php 
$pageTitle = 'Demo de Componentes - BreezeMVC';
$pageDescription = 'Demostración de componentes reutilizables';
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
    <div class="container content-space-2 content-space-lg-3">
      
      <!-- Page Header -->
      <div class="text-center mb-5 mb-md-7">
        <h1 class="display-4">Componentes Reutilizables</h1>
        <p class="lead">Demostración de componentes extraídos de HTMLStream Front</p>
      </div>
      <!-- End Page Header -->

      <?php
      use src\utils\ComponentHelper;
      ?>

      <!-- Breadcrumb Demo -->
      <div class="mb-5">
        <h2 class="h4 mb-3">Breadcrumb</h2>
        <?php
        ComponentHelper::render('ui/breadcrumb', [
            'items' => [
                ['label' => 'Inicio', 'url' => '/'],
                ['label' => 'Componentes', 'url' => '/components'],
                'Demo'
            ]
        ]);
        ?>
      </div>
      <!-- End Breadcrumb Demo -->

      <!-- Alerts Demo -->
      <div class="mb-5">
        <h2 class="h4 mb-3">Alertas</h2>
        
        <?php
        ComponentHelper::render('ui/alert', [
            'type' => 'success',
            'message' => 'Operación completada exitosamente'
        ]);
        ?>

        <?php
        ComponentHelper::render('ui/alert', [
            'type' => 'error',
            'message' => 'Ha ocurrido un error. Por favor intenta de nuevo.'
        ]);
        ?>

        <?php
        ComponentHelper::render('ui/alert', [
            'type' => 'warning',
            'message' => 'Advertencia: Esta acción no se puede deshacer.'
        ]);
        ?>

        <?php
        ComponentHelper::render('ui/alert', [
            'type' => 'info',
            'message' => 'Información: Los cambios se guardarán automáticamente.',
            'dismissible' => false
        ]);
        ?>
      </div>
      <!-- End Alerts Demo -->

      <!-- Cards Demo -->
      <div class="mb-5">
        <h2 class="h4 mb-3">Cards</h2>
        
        <div class="row">
          <div class="col-md-4 mb-3">
            <?php
            ComponentHelper::render('ui/card', [
                'title' => 'Card Simple',
                'content' => '<p>Este es un ejemplo de card simple con título y contenido.</p>'
            ]);
            ?>
          </div>

          <div class="col-md-4 mb-3">
            <?php
            ComponentHelper::render('ui/card', [
                'title' => 'Card con Footer',
                'content' => '<p>Card con footer que incluye botones de acción.</p>',
                'footer' => '<button class="btn btn-primary btn-sm">Acción</button>'
            ]);
            ?>
          </div>

          <div class="col-md-4 mb-3">
            <?php
            ComponentHelper::render('ui/card', [
                'image' => 'assets/img/documentation/img1.jpg',
                'imageAlt' => 'Imagen de ejemplo',
                'title' => 'Card con Imagen',
                'content' => '<p>Card que incluye una imagen en la parte superior.</p>'
            ]);
            ?>
          </div>
        </div>
      </div>
      <!-- End Cards Demo -->

      <!-- Modal Demo -->
      <div class="mb-5">
        <h2 class="h4 mb-3">Modal</h2>
        
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#demoModal">
          Abrir Modal
        </button>

        <?php
        ComponentHelper::render('ui/modal', [
            'id' => 'demoModal',
            'title' => 'Modal de Ejemplo',
            'content' => '<p>Este es el contenido del modal. Puedes incluir cualquier HTML aquí.</p>',
            'footer' => '
              <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary">Confirmar</button>
            ',
            'size' => 'md',
            'centered' => true
        ]);
        ?>
      </div>
      <!-- End Modal Demo -->

      <!-- Links to Auth Components -->
      <div class="mb-5">
        <h2 class="h4 mb-3">Componentes de Autenticación</h2>
        <div class="list-group">
          <a href="/auth/login" class="list-group-item list-group-item-action">
            <i class="bi-box-arrow-in-right me-2"></i> Login Form
          </a>
          <a href="/auth/register" class="list-group-item list-group-item-action">
            <i class="bi-person-plus me-2"></i> Register Form
          </a>
          <a href="/auth/forgotPassword" class="list-group-item list-group-item-action">
            <i class="bi-key me-2"></i> Forgot Password Form
          </a>
        </div>
      </div>
      <!-- End Links -->

      <!-- Documentation Link -->
      <div class="text-center">
        <a href="/docs/COMPONENTS.md" class="btn btn-outline-primary">
          <i class="bi-file-text me-2"></i> Ver Documentación Completa
        </a>
      </div>
      <!-- End Documentation Link -->

    </div>
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

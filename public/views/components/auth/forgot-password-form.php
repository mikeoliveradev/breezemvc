<?php
/**
 * Componente: Formulario de Recuperación de Contraseña
 * 
 * @var string $title - Título del formulario
 * @var string $subtitle - Subtítulo descriptivo
 * @var string $action - URL de acción del formulario
 * @var string|null $success - Mensaje de éxito (opcional)
 * @var string|null $error - Mensaje de error (opcional)
 * @var string $loginUrl - URL de login
 */

// Valores por defecto
$title = $title ?? '¿Olvidaste tu contraseña?';
$subtitle = $subtitle ?? 'Ingresa tu email y te enviaremos instrucciones para recuperarla';
$action = $action ?? '/auth/forgotPasswordPost';
$loginUrl = $loginUrl ?? '/auth/login';
?>

<div class="container content-space-2 content-space-lg-3">
  <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
    <!-- Heading -->
    <div class="text-center mb-5 mb-md-7">
      <h1 class="h2"><?php echo htmlspecialchars($title); ?></h1>
      <p><?php echo htmlspecialchars($subtitle); ?></p>
    </div>
    <!-- End Heading -->

    <?php if (isset($success) && $success): ?>
    <!-- Success Alert -->
    <div class="alert alert-soft-success" role="alert">
      <div class="d-flex">
        <div class="flex-shrink-0">
          <i class="bi-check-circle"></i>
        </div>
        <div class="flex-grow-1 ms-2">
          <?php echo htmlspecialchars($success); ?>
        </div>
      </div>
    </div>
    <!-- End Success Alert -->
    <?php endif; ?>

    <?php if (isset($error) && $error): ?>
    <!-- Error Alert -->
    <div class="alert alert-soft-danger" role="alert">
      <div class="d-flex">
        <div class="flex-shrink-0">
          <i class="bi-exclamation-triangle"></i>
        </div>
        <div class="flex-grow-1 ms-2">
          <?php echo htmlspecialchars($error); ?>
        </div>
      </div>
    </div>
    <!-- End Error Alert -->
    <?php endif; ?>

    <!-- Form -->
    <form class="js-validate needs-validation" method="POST" action="<?php echo htmlspecialchars($action); ?>" novalidate>
      <!-- Email -->
      <div class="mb-4">
        <label class="form-label" for="forgotPasswordEmail">Email</label>
        <input type="email" 
               class="form-control form-control-lg" 
               name="email" 
               id="forgotPasswordEmail" 
               placeholder="email@ejemplo.com" 
               aria-label="email@ejemplo.com" 
               required
               autocomplete="email">
        <span class="invalid-feedback">Por favor ingresa un email válido.</span>
      </div>
      <!-- End Email -->

      <!-- Submit Button -->
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Enviar instrucciones</button>
      </div>
      <!-- End Submit Button -->

      <!-- Footer Link -->
      <div class="text-center">
        <p><a class="link" href="<?php echo htmlspecialchars($loginUrl); ?>">
          <i class="bi-chevron-left small ms-1"></i> Volver al login
        </a></p>
      </div>
      <!-- End Footer Link -->
    </form>
    <!-- End Form -->
  </div>
</div>

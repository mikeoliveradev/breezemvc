<?php
/**
 * Componente: Formulario de Reseteo de Contraseña
 * 
 * @var string $title - Título del formulario
 * @var string $subtitle - Subtítulo descriptivo
 * @var string $action - URL de acción del formulario
 * @var string $token - Token de reseteo
 * @var string|null $error - Mensaje de error (opcional)
 */

// Valores por defecto
$title = $title ?? 'Crear nueva contraseña';
$subtitle = $subtitle ?? 'Ingresa tu nueva contraseña';
$action = $action ?? '/auth/resetPasswordPost';
?>

<div class="container content-space-2 content-space-lg-3">
  <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
    <!-- Heading -->
    <div class="text-center mb-5 mb-md-7">
      <h1 class="h2"><?php echo htmlspecialchars($title); ?></h1>
      <p><?php echo htmlspecialchars($subtitle); ?></p>
    </div>
    <!-- End Heading -->

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
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token ?? ''); ?>">

      <!-- Password -->
      <div class="mb-3">
        <label class="form-label" for="resetPassword">Nueva contraseña</label>

        <div class="input-group input-group-merge" data-hs-validation-validate-class>
          <input type="password" 
                 class="js-toggle-password form-control form-control-lg" 
                 name="password" 
                 id="resetPassword" 
                 placeholder="8+ caracteres requeridos" 
                 aria-label="8+ caracteres requeridos" 
                 required
                 minlength="8"
                 autocomplete="new-password"
                 data-hs-toggle-password-options='{
                   "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                   "defaultClass": "bi-eye-slash",
                   "showClass": "bi-eye",
                   "classChangeTarget": ".js-toggle-password-show-icon-1"
                 }'>
          <a class="js-toggle-password-target-1 input-group-append input-group-text" href="javascript:;">
            <i class="js-toggle-password-show-icon-1 bi-eye"></i>
          </a>
        </div>

        <span class="invalid-feedback">La contraseña debe tener al menos 8 caracteres.</span>
      </div>
      <!-- End Password -->

      <!-- Confirm Password -->
      <div class="mb-3">
        <label class="form-label" for="resetConfirmPassword">Confirmar contraseña</label>

        <div class="input-group input-group-merge" data-hs-validation-validate-class>
          <input type="password" 
                 class="js-toggle-password form-control form-control-lg" 
                 name="confirmPassword" 
                 id="resetConfirmPassword" 
                 placeholder="8+ caracteres requeridos" 
                 aria-label="8+ caracteres requeridos" 
                 required
                 autocomplete="new-password"
                 data-hs-validation-equal-field="#resetPassword"
                 data-hs-toggle-password-options='{
                   "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                   "defaultClass": "bi-eye-slash",
                   "showClass": "bi-eye",
                   "classChangeTarget": ".js-toggle-password-show-icon-2"
                 }'>
          <a class="js-toggle-password-target-2 input-group-append input-group-text" href="javascript:;">
            <i class="js-toggle-password-show-icon-2 bi-eye"></i>
          </a>
        </div>

        <span class="invalid-feedback">Las contraseñas no coinciden.</span>
      </div>
      <!-- End Confirm Password -->

      <!-- Submit Button -->
      <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">Cambiar contraseña</button>
      </div>
      <!-- End Submit Button -->
    </form>
    <!-- End Form -->
  </div>
</div>

<?php
/**
 * Componente: Formulario de Registro
 * Basado en HTMLStream Front - forms-authentication.html Component #2
 * 
 * @var string $title - Título del formulario
 * @var string $subtitle - Subtítulo descriptivo
 * @var string $action - URL de acción del formulario
 * @var string|null $error - Mensaje de error (opcional)
 * @var string $privacyUrl - URL de política de privacidad
 * @var string $loginUrl - URL de login
 */

// Valores por defecto
$title = $title ?? 'Bienvenido a BreezeMVC';
$subtitle = $subtitle ?? 'Completa el formulario para comenzar';
$action = $action ?? '/auth/registerPost';
$privacyUrl = $privacyUrl ?? '/privacy';
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
      <div class="mb-3">
        <label class="form-label" for="registerEmail">Email</label>
        <input type="email" 
               class="form-control form-control-lg" 
               name="email" 
               id="registerEmail" 
               placeholder="email@ejemplo.com" 
               aria-label="email@ejemplo.com" 
               required
               autocomplete="email">
        <span class="invalid-feedback">Por favor ingresa un email válido.</span>
      </div>
      <!-- End Email -->

      <!-- Password -->
      <div class="mb-3">
        <label class="form-label" for="registerPassword">Contraseña</label>

        <div class="input-group input-group-merge" data-hs-validation-validate-class>
          <input type="password" 
                 class="js-toggle-password form-control form-control-lg" 
                 name="password" 
                 id="registerPassword" 
                 placeholder="8+ caracteres requeridos" 
                 aria-label="8+ caracteres requeridos" 
                 required
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

        <span class="invalid-feedback">Tu contraseña es inválida. Por favor intenta de nuevo.</span>
      </div>
      <!-- End Password -->

      <!-- Confirm Password -->
      <div class="mb-3">
        <label class="form-label" for="registerConfirmPassword">Confirmar contraseña</label>

        <div class="input-group input-group-merge" data-hs-validation-validate-class>
          <input type="password" 
                 class="js-toggle-password form-control form-control-lg" 
                 name="confirmPassword" 
                 id="registerConfirmPassword" 
                 placeholder="8+ caracteres requeridos" 
                 aria-label="8+ caracteres requeridos" 
                 required
                 autocomplete="new-password"
                 data-hs-validation-equal-field="#registerPassword"
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

        <span class="invalid-feedback">La contraseña no coincide con la confirmación.</span>
      </div>
      <!-- End Confirm Password -->

      <!-- Privacy Policy Check -->
      <div class="form-check mb-3">
        <input type="checkbox" 
               class="form-check-input" 
               id="registerPrivacyCheck" 
               name="privacyCheck" 
               required>
        <label class="form-check-label small" for="registerPrivacyCheck">
          Al enviar este formulario he leído y acepto la 
          <a href="<?php echo htmlspecialchars($privacyUrl); ?>">Política de Privacidad</a>
        </label>
        <span class="invalid-feedback">Por favor acepta nuestra Política de Privacidad.</span>
      </div>
      <!-- End Privacy Policy Check -->

      <!-- Submit Button -->
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Registrarse</button>
      </div>
      <!-- End Submit Button -->

      <!-- Footer Link -->
      <div class="text-center">
        <p>¿Ya tienes cuenta? <a class="link" href="<?php echo htmlspecialchars($loginUrl); ?>">Inicia sesión aquí</a></p>
      </div>
      <!-- End Footer Link -->
    </form>
    <!-- End Form -->
  </div>
</div>

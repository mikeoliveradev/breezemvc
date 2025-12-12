<?php
/**
 * Componente: Formulario de Login
 * Basado en HTMLStream Front - forms-authentication.html Component #1
 * 
 * @var string $title - Título del formulario
 * @var string $subtitle - Subtítulo descriptivo
 * @var string $action - URL de acción del formulario
 * @var string|null $error - Mensaje de error (opcional)
 * @var string $forgotPasswordUrl - URL de recuperación de contraseña
 * @var string $registerUrl - URL de registro
 * @var string|null $googleAuthUrl - URL de autenticación con Google (opcional)
 */

// Valores por defecto
$title = $title ?? 'Bienvenido';
$subtitle = $subtitle ?? 'Inicia sesión para continuar';
$action = $action ?? '/auth/loginPost';
$forgotPasswordUrl = $forgotPasswordUrl ?? '/auth/forgotPassword';
$registerUrl = $registerUrl ?? '/auth/register';
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
      <div class="mb-4">
        <label class="form-label" for="loginEmail">Email</label>
        <input type="email" 
               class="form-control form-control-lg" 
               name="email" 
               id="loginEmail" 
               placeholder="email@ejemplo.com" 
               aria-label="email@ejemplo.com" 
               required
               autocomplete="email">
        <span class="invalid-feedback">Por favor ingresa un email válido.</span>
      </div>
      <!-- End Email -->

      <!-- Password -->
      <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
          <label class="form-label" for="loginPassword">Contraseña</label>
          <a class="form-label-link" href="<?php echo htmlspecialchars($forgotPasswordUrl); ?>">
            ¿Olvidaste tu contraseña?
          </a>
        </div>

        <div class="input-group input-group-merge" data-hs-validation-validate-class>
          <input type="password" 
                 class="js-toggle-password form-control form-control-lg" 
                 name="password" 
                 id="loginPassword" 
                 placeholder="8+ caracteres requeridos" 
                 aria-label="8+ caracteres requeridos" 
                 required 
                 minlength="8"
                 autocomplete="current-password"
                 data-hs-toggle-password-options='{
                   "target": "#changePassTarget",
                   "defaultClass": "bi-eye-slash",
                   "showClass": "bi-eye",
                   "classChangeTarget": "#changePassIcon"
                 }'>
          <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
            <i id="changePassIcon" class="bi-eye"></i>
          </a>
        </div>

        <span class="invalid-feedback">Por favor ingresa una contraseña válida.</span>
      </div>
      <!-- End Password -->

      <!-- Submit Button -->
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
      </div>
      <!-- End Submit Button -->

      <?php if (isset($googleAuthUrl) && $googleAuthUrl): ?>
      <!-- Divider -->
      <div class="text-center">
        <span class="divider-center text-muted mb-4">O</span>
      </div>
      <!-- End Divider -->

      <!-- Google Sign In -->
      <div class="d-grid mb-3">
        <a href="<?php echo htmlspecialchars($googleAuthUrl); ?>" class="btn btn-white btn-lg">
          <span class="d-flex justify-content-center align-items-center">
            <img class="avatar avatar-xss me-2" src="assets/svg/brands/google-icon.svg" alt="Google">
            Continuar con Google
          </span>
        </a>
      </div>
      <!-- End Google Sign In -->
      <?php endif; ?>

      <!-- Footer Link -->
      <div class="text-center">
        <p>¿No tienes cuenta? <a class="link" href="<?php echo htmlspecialchars($registerUrl); ?>">Regístrate aquí</a></p>
      </div>
      <!-- End Footer Link -->
    </form>
    <!-- End Form -->
  </div>
</div>

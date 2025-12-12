<?php
// views/cookie_consent_modal.php

// Recupera las preferencias actuales (si existen) para pre-seleccionar las casillas
// Esto sería cargado por PHP, por ejemplo desde un objeto $cookiePreferences
$prefStrictlyNecessary = true; // Siempre true
$prefFunctional = $_COOKIE['cookie_functional'] ?? 'true'; // Por defecto activadas si no hay preferencia
$prefStatistics = $_COOKIE['cookie_statistics'] ?? 'false'; // Por defecto desactivadas
$prefAdvertising = $_COOKIE['cookie_advertising'] ?? 'false'; // Por defecto desactivadas

// Convierte los valores de string a booleano para HTML
$checkedFunctional = ($prefFunctional === 'true') ? 'checked' : '';
$checkedStatistics = ($prefStatistics === 'true') ? 'checked' : '';
$checkedAdvertising = ($prefAdvertising === 'true') ? 'checked' : '';
?>
<div class="container position-fixed bottom-0 start-0 end-0 zi-3" id="cookieConsentModal" style="display:none;">
    <div class="alert alert-white w-lg-75 shadow-sm mx-auto" role="alert">
      <h5 class="text-dark">Preferencias de Cookies</h5>
      <p class="small"><span class="fw-semibold">¡Importante!</span> Usamos cookies para asegurar la mejor experiencia en nuestro sitio web. A continuación, puedes seleccionar qué tipo de cookies deseas aceptar. Nuestro sitio utiliza cookies estrictamente necesarias, funcionales, de estadísticas de visitantes y de publicidad.</p>

      <div class="row align-items-sm-center">
        <div class="col-sm-8 mb-3 mb-sm-0">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" value="option1" id="cookieStrictlyNecessary" checked disabled >
            <label class="form-check-label small" for="cookieStrictlyNecessary">Estrictamente Necesarias (siempre activas)</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="cookieFunctional" value="option2" <?php echo $checkedFunctional; ?> >
            <label class="form-check-label small" for="cookieFunctional">Funcionales</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="cookieStatistics" value="option3" <?php echo $checkedStatistics; ?> >
            <label class="form-check-label small" for="cookieStatistics">Estadísticas (Análisis de Visitantes)</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="cookieAdvertising" value="option4" <?php echo $checkedAdvertising; ?>>
            <label class="form-check-label small" for="cookieAdvertising">Publicidad (Marketing)</label>
          </div>
        </div>
        <!-- End Col -->

        <div class="col-sm-4 text-sm-end">
          <button type="button" class="btn btn-success btn-transition" data-bs-dismiss="alert" aria-label="Close">Guardar Preferencias</button>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
  </div>
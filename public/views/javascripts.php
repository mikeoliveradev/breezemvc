<?php 
use src\utils\Utils;
?>
<!-- JS Global Compulsory  -->
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Implementing Plugins -->
  <script src="assets/vendor/hs-header/dist/hs-header.min.js"></script>
  <script src="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
  <script src="assets/vendor/hs-show-animation/dist/hs-show-animation.min.js"></script>
  <script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
  <script src="assets/vendor/aos/dist/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- JS Front -->
  <script src="assets/js/theme.min.js"></script>
  <?php echo '<script src="' . Utils::versionAsset('/assets/js/theme-custom.js') . '"></script>'; ?>

  <script>
    // js/cookie_logic.js
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('cookieConsentModal');
        const saveButton = document.getElementById('saveCookiePreferences');

        const cookieStrictlyNecessary = document.getElementById('cookieStrictlyNecessary');
        const cookieFunctional = document.getElementById('cookieFunctional');
        const cookieStatistics = document.getElementById('cookieStatistics');
        const cookieAdvertising = document.getElementById('cookieAdvertising');

        // Función para leer una cookie
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return undefined;
        }

        // Función para establecer una cookie
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = `; expires=${date.toUTCString()}`;
            }
            document.cookie = `${name}=${value}${expires}; path=/; SameSite=Lax`;
        }

        // Comprobar si ya hay una preferencia guardada
        const preferencesSaved = getCookie('cookie_preferences_set');

        if (!preferencesSaved) {
            // Si no hay preferencia, mostrar el modal
            modal.style.display = 'block';
        } else {
            // Si ya hay preferencia, ocultar el modal
            modal.style.display = 'none';
            // Aquí podrías cargar scripts específicos si es necesario después de la página
            // loadSpecificScripts(); 
        }

        // Cargar las preferencias guardadas en las casillas (si existen)
        if (getCookie('cookie_functional') !== undefined) {
            cookieFunctional.checked = getCookie('cookie_functional') === 'true';
        }
        if (getCookie('cookie_statistics') !== undefined) {
            cookieStatistics.checked = getCookie('cookie_statistics') === 'true';
        }
        if (getCookie('cookie_advertising') !== undefined) {
            cookieAdvertising.checked = getCookie('cookie_advertising') === 'true';
        }


        saveButton.addEventListener('click', () => {
            // Guardar las preferencias en cookies
            setCookie('cookie_strictly_necessary', 'true', 365); // Siempre activa
            setCookie('cookie_functional', cookieFunctional.checked, 365);
            setCookie('cookie_statistics', cookieStatistics.checked, 365);
            setCookie('cookie_advertising', cookieAdvertising.checked, 365);
            
            // Marcar que las preferencias han sido establecidas
            setCookie('cookie_preferences_set', 'true', 365);

            modal.style.display = 'none'; // Ocultar el modal

            // Aquí puedes recargar la página o cargar los scripts de seguimiento
            // window.location.reload(); // Puede ser útil para cargar scripts PHP que dependan de cookies
            console.log('Preferencias de cookies guardadas.');
            
            // Opcional: Cargar dinámicamente scripts después de guardar
            // loadSpecificScripts(); 
        });

        // Función de ejemplo para cargar scripts basados en las preferencias
        // Puedes llamar a esta función al inicio (si ya hay preferencias) o después de guardar
        function loadSpecificScripts() {
            if (getCookie('cookie_statistics') === 'true') {
                const scriptGa = document.createElement('script');
                scriptGa.src = 'https://www.googletagmanager.com/gtag/js?id=UA-XXXXX-Y';
                document.head.appendChild(scriptGa);
                scriptGa.onload = () => {
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());
                    gtag('config', 'UA-XXXXX-Y');
                };
            }
            if (getCookie('cookie_advertising') === 'true') {
                //Cargar pixel de Facebook, script de Google Ads, etc.
            }
        }
    });
  </script>
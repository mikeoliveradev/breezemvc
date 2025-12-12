<?php 
use src\utils\Utils;

// Define valores por defecto si las variables no están establecidas
$pageTitle = $pageTitle ?? 'Impulsora - Líder en Soluciones Industriales. Distribuidor Parker.';
$pageDescription = $pageDescription ?? 'Impulsora es el distribuidor autorizado Parker en México, especializado en tecnologías de control y movimiento para la industria energética, petroquímica y más.';
$pageKeywords = $pageKeywords ?? 'Parker México, Impulsora, industria energética, petroquímica, hidrocarburos, refinación, soluciones industriales, control y movimiento';
$pageTitle_og = $pageTitle_og ?? 'Impulsora: Distribuidor Parker | Soluciones Industriales';
$pageDescription_og = $pageDescription_og ?? 'Descubre cómo Impulsora ofrece soluciones para la industria mexicana con la tecnología Parker, brindando seguridad y calidad en la industria energética.';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$canonicalUrl = "https://".$host.$_SERVER['REQUEST_URI'];
?>
<head>
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title><?php echo htmlspecialchars($pageTitle); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords); ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?php echo $canonicalUrl; ?>">

  <!-- Open Graph - Twitter Cards -->
  <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle_og); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription_og); ?>">
  <meta property="og:image" content="<?php echo $canonicalUrl; ?>assets/img/others/og-image.jpg">
  <meta property="og:url" content="<?php echo $canonicalUrl; ?>">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle_og); ?>">
  <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription_og); ?>">
  <meta name="twitter:image" content="<?php echo $canonicalUrl; ?>assets/img/others/og-image.jpg">

  <!-- Favicon -->
  <link rel="shortcut icon" href="favicon.ico">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
  <link rel="stylesheet" href="assets/vendor/aos/dist/aos.css">
  <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/vendor/leaflet/dist/leaflet.css"/>

  <!-- CSS Front Template -->
  <?php echo '<link rel="stylesheet" href="' . Utils::versionAsset('/assets/css/theme.css') . '">'; ?>

  <?php 
    // 2. Lógica PHP para cargar scripts de seguimiento (Google Analytics, Facebook Pixel, etc.)
    //    basada en las cookies que el usuario YA ACEPTÓ.

    // Leer las preferencias de cookies del usuario del lado del servidor
    $cookie_statistics_accepted = ($_COOKIE['cookie_statistics'] ?? 'false') === 'true';
    $cookie_advertising_accepted = ($_COOKIE['cookie_advertising'] ?? 'false') === 'true';

    // Scripts que se cargan solo si el usuario los aceptó
    if ($cookie_statistics_accepted) {
        // Código de Google Analytics, Matomo, etc.
        echo "\n";
        echo "<script async src='https://www.googletagmanager.com/gtag/js?id=UA-XXXXX-Y'></script>\n";
        echo "<script>\n";
        echo "  window.dataLayer = window.dataLayer || [];\n";
        echo "  function gtag(){dataLayer.push(arguments);}\n";
        echo "  gtag('js', new Date());\n";
        echo "  gtag('config', 'UA-XXXXX-Y');\n"; // Reemplaza con tu ID de GA
        echo "</script>\n";
    }

    if ($cookie_advertising_accepted) {
        // Código de Facebook Pixel, Google Ads, etc.
        echo "\n";
        echo "<script>\n";
        echo "  !function(f,b,e,v,n,t,s)\n";
        echo "  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?\n";
        echo "  n.callMethod.apply(n,arguments):n.queue.push(arguments)};\n";
        echo "  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';\n";
        echo "  n.queue=[];t=b.createElement(e);t.async=!0;\n";
        echo "  t.src=v;s=b.getElementsByTagName(e)[0];\n";
        echo "  s.parentNode.insertBefore(t,s)}(window, document,'script',\n";
        echo "  'https://connect.facebook.net/en_US/fbevents.js');\n";
        echo "  fbq('init', 'YOUR_PIXEL_ID');\n"; // Reemplaza con tu ID de Pixel
        echo "  fbq('track', 'PageView');\n";
        echo "</script>\n";
        echo "<noscript><img height='1' width='1' style='display:none'\n";
        echo "  src='https://www.facebook.com/tr?id=YOUR_PIXEL_ID&ev=PageView&noscript=1'\n";
        echo "/></noscript>\n";
    }
 ?>
</head>
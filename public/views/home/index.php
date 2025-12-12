<!DOCTYPE html>
<html lang="en" dir=""> 
<?php require_once(__DIR__ . '/../head.php'); ?>

<body>
  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-expand-lg navbar-end navbar-absolute-top navbar-dark navbar-show-hide" data-hs-header-options='{"fixMoment": 1000, "fixEffect": "slide"}'>
    <!-- Topbar -->
    <?php include_once(__DIR__ . '/../top_bar.php'); ?>
    <!-- End Topbar -->
    <div class="container">
      <!-- NAVEGACION -->
       <?php require_once(__DIR__ . '/../nav.php'); ?>
      <!-- END NAVEGACION -->
    </div>
  </header>
  <!-- ========== END HEADER ========== -->

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
    
    <!-- Hero Slider Section -->
    <?php include(__DIR__ . '/_hero.php'); ?>
    
    <!-- About Section -->
    <?php include(__DIR__ . '/_about.php'); ?>
    
    <!-- Services Section -->
    <?php include(__DIR__ . '/_services.php'); ?>
    
    <!-- Products Section -->
    <?php include(__DIR__ . '/_products.php'); ?>
    
    <!-- Contact Section -->
    <?php include(__DIR__ . '/_contact.php'); ?>
    
    <!-- Logo Section -->
    <div class="container content-space-1 content-space-lg-1">
      <div class="w-md-50 w-lg-25 text-center mx-md-auto">
        <div class="row justify-content-lg-between">
          <div class="mb-1">
            <img src="assets/img/others/logo-very-big.png" class="img-fluid" >
          </div>
        </div>
      </div>
    </div>

  </main>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- ========== FOOTER ========== -->
  <?php include_once(__DIR__ . '/../footer.php'); ?>
  <!-- ========== END FOOTER ========== -->

  <!-- ========== SECONDARY CONTENTS ========== -->
  <?php include_once(__DIR__ . '/../modal_signup.php'); ?>

  <!-- Go To -->
  <?php include_once(__DIR__ . '/../go_to.php'); ?>

  <!-- Cookie Alert -->
  <?php include_once(__DIR__ . '/../cookie_alert.php'); ?>
  <!-- ========== END SECONDARY CONTENTS ========== -->

  <?php require_once(__DIR__ . '/../javascripts.php'); ?>

  <!-- Home Page Specific JS -->
  <script src="assets/js/home.js"></script>

</body>
</html>

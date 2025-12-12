<!-- SERVICIOS -->
<div id="serviciosSection" class="container content-space-t-2 content-space-t-lg-3 content-space-b-lg-2">
  <!-- Heading -->
  <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
    <h2 class="display-4">Servicios</h2>
  </div>
  <!-- End Heading -->

  <!-- Step -->
  <ul class="step step-md step-centered">

    <?php foreach ($services as $service): ?>
    <li class="step-item">
      <div class="step-content-wrapper">
        <span class="step-icon step-icon-soft-primary"><?= htmlspecialchars($service['number']) ?></span>
        <div class="step-content">
          <h3><?= htmlspecialchars($service['title']) ?></h3>
          <p><?= $service['description'] ?></p>
        </div>
      </div>
    </li>
    <?php endforeach; ?>

  </ul>
  <!-- End Step -->
</div>
<!-- End SERVICIOS -->

<!-- Map -->
<div id="contactoSection" class="position-relative rounded-2 mx-3 mx-md-8">
  <div class="container content-space-1 content-space-lg-3">
    <div class="row justify-content-md-end">
      <div class="col-md-6 col-lg-5">
        <!-- Card -->
        <div class="card card-lg position-relative zi-3">
          <div class="card-body">
            <!-- Heading -->
            <div class="mb-5">
              <h4 class="card-title">Contacto</h4>
              <h3 class="card-title h3">México.</h3>
            </div>
            <!-- End Heading -->

            <!-- Media -->
            <div class="d-flex mb-5">

              <div class="flex-grow-1">
                <h5 class="mb-1">Llámanos:</h5>
                <span class="d-block small"><?= htmlspecialchars($contact['phone']) ?></span>
              </div>
            </div>
            <!-- End Media -->

            <!-- Media -->
            <div class="d-flex mb-5">
              <div class="flex-grow-1">
                <h5 class="mb-1">Correo:</h5>
                <span class="d-block small"><?= htmlspecialchars($contact['email']) ?></span>
              </div>
            </div>
            <!-- End Media -->

            <!-- Media -->
            <div class="d-flex">
              <div class="flex-grow-1">
                <h5 class="mb-1">Visitanos:</h5>
                <span class="d-block small"><?= htmlspecialchars($contact['address']) ?></span>
              </div>
            </div>
            <!-- End Media -->
          </div>
        </div>
        <!-- End Card -->
      </div>
      <!-- End Col -->
    </div>
    <!-- End Row -->
  </div>

  <!-- Gmap -->
  <div class="position-md-absolute top-0 start-0 bottom-0 end-0">
    <div id="map" class="leaflet"
         data-hs-leaflet-options='{
           "map": {
             "scrollWheelZoom": false,
             "coords": [<?= $contact['mapCoords'][0] ?>, <?= $contact['mapCoords'][1] ?>]
           },
           "marker": [
             {
               "coords": [<?= $contact['mapCoords'][0] ?>, <?= $contact['mapCoords'][1] ?>],
               "icon": {
                 "iconUrl": "./assets/svg/components/map-pin.svg",
                 "iconSize": [50, 45]
               },
               "popup": {
                 "text": "<?= htmlspecialchars($contact['address']) ?>",
                 "title": "Address"
               }
             }
           ]
          }'></div>
  </div>
  <!-- End Gmap -->
</div>
<!-- End Map -->

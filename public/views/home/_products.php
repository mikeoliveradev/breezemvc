<!-- Card Grid PRODUCTOS -->
<div class="bg-light rounded-2 mx-3 mx-xl-10">
  <div class="container-xl container-fluid content-space-1 content-space-md-2 px-4 px-md-8 px-lg-10">
    <div class="px-3">
      <!-- Heading -->
      <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
        <h2 class="text-dark">Productos</h2>
      </div>
      <!-- End Heading -->

      <!-- Swiper Slider -->
      <div class="js-swiper-card-blocks swiper swiper-equal-height">
        <div class="swiper-wrapper">

          <?php foreach ($products as $product): ?>
          <!-- PRODUCTO -->
          <div class="swiper-slide rounded">
            <!-- Card -->
            <div class="card h-100 shadow">
              <img class="card-img-top" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">

              <div class="card-body">
                <p class="card-text fw-bold fs-3"><?= htmlspecialchars($product['name']) ?></p>
              </div>

              <div class="card-footer pt-0">
                <a class="card-link" href="">Ver categoría <i class="bi-chevron-right small ms-1"></i></a>
              </div>
            </div>
            <!-- End Card -->
          </div>
          <!-- End PRODUCTO -->
          <?php endforeach; ?>

        </div>

        <!-- Swiper Pagination -->
        
      </div>
      <!-- End Swiper Slider -->
    </div>
  </div>
</div>
<!-- End Card Grid PRODUCTOS -->

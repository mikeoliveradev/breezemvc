<!-- Swiper Slider -->
<div class="border-bottom">
  <!-- Main Slider -->
  <div class="js-swiper-main swiper vh-md-70">
    <div class="swiper-wrapper">
      
      <?php foreach ($heroSlides as $index => $slide): ?>
      <!-- Slide <?= $index + 1 ?> -->
      <div class="swiper-slide gradient-y-overlay-sm-gray-900 bg-img-start" style="background-image: url(<?= htmlspecialchars($slide['image']) ?>);">
        <div class="container d-md-flex align-items-md-center vh-md-70 content-space-t-4 content-space-b-3 content-space-md-0">
          <div class="w-100 w-lg-50">
            <<?= $index === 0 ? 'h1' : 'h2' ?> class="display-4 text-white mb-0"><?= htmlspecialchars($slide['title']) ?></<?= $index === 0 ? 'h1' : 'h2' ?>>
          </div>
        </div>
      </div>
      <!-- End Slide <?= $index + 1 ?> -->
      <?php endforeach; ?>

    </div>

    <!-- Arrows -->
    <div class="d-none d-md-inline-block">
      <div class="js-swiper-main-button-next swiper-button-next swiper-button-next-soft-white"></div>
      <div class="js-swiper-main-button-prev swiper-button-prev swiper-button-prev-soft-white"></div>
    </div>
  </div>
  <!-- End Main Slider -->

  <!-- Thumbs Slider -->
  <div class="js-swiper-thumbs swiper">
    <div class="swiper-wrapper">

      <?php foreach ($heroSlides as $index => $slide): ?>
      <!-- Slide -->
      <div class="swiper-slide">
        <div class="d-flex align-items-center bg-white position-relative vh-md-30">
          <div class="container content-space-2">
            <div class="row">
              <div class="col-md-4">
                <span class="fs-3 fw-semibold"><?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>.</span>
                <h3 class="text-primary"><?= $slide['description'] ?></h3>
                <p class="mb-0 d-md-none"><?= htmlspecialchars($slide['subtitle']) ?></p>
              </div>
              <!-- End Col -->
            </div>
            <!-- End Row -->
          </div>

          <div class="col-md-5 d-none d-md-inline-block bg-primary position-absolute top-0 end-0 bottom-0">
            <div class="position-absolute top-50 translate-middle-y p-7">
              <h3 class="text-white"><?= htmlspecialchars($slide['subtitle']) ?></h3>
            </div>
          </div>
          <!-- End Col -->
        </div>
      </div>
      <!-- End Slide -->
      <?php endforeach; ?>

    </div>
  </div>
  <!-- End Thumbs Slider -->
</div>
<!-- End Swiper Slider -->

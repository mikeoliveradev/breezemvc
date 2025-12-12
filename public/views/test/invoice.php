<!DOCTYPE html>
<html lang="en" dir="">
<?php 
// Ajustar ruta del head si es necesario, asumiendo que render() hace include desde public/
// Si head.php está en public/views/head.php y estamos en public/views/test/invoice.php
// La ruta relativa desde el archivo incluido sería...
// Mejor usar ruta absoluta desde public o ajustar según tu estructura de includes.
// Por ahora asumo que head.php está en public/views/
require_once(__DIR__ . '/../head.php'); 
?>

<body>
  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
    <!-- Content -->
    <div class="container content-space-2">
      <div class="w-lg-85 mx-lg-auto">
        <!-- Card -->
        <div class="card card-lg mb-5">
          <div class="card-body">
            <div class="row justify-content-lg-between">
              <div class="col-sm order-2 order-sm-1 mb-3">
                <div class="mb-2">
                  <!-- Ajustar rutas de assets para que sean relativas a la raíz o absolutas -->
                  <img class="avatar" src="/assets/svg/logos/logo-short.svg" alt="Logo">
                </div>

                <h1 class="h2 text-primary">Front Inc.</h1>
              </div>
              <!-- End Col -->

              <div class="col-sm-auto order-1 order-sm-2 text-sm-end mb-3">
                <div class="mb-3">
                  <h2>Invoice #<?php echo $id; ?></h2>
                  <span class="d-block">3682303</span>
                </div>

                <address class="text-dark">
                  45 Roker Terrace<br>
                  Latheronwheel<br>
                  KW5 8NW, London<br>
                  United Kingdom
                </address>
              </div>
              <!-- End Col -->
            </div>
            <!-- End Row -->

            <div class="row justify-content-md-between mb-3">
              <div class="col-md">
                <h4>Bill to:</h4>
                <h4><?php echo $nombre; ?></h4>

                <address>
                  280 Suzanne Throughway,<br>
                  Breannabury, OR 45801,<br>
                  United States
                </address>
              </div>
              <!-- End Col -->

              <div class="col-md text-md-end">
                <dl class="row">
                  <dt class="col-sm-8">Invoice date:</dt>
                  <dd class="col-sm-4"><?php echo $fecha_factura ?? '03/10/2018'; ?></dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-8">Due date:</dt>
                  <dd class="col-sm-4">03/11/2018</dd>
                </dl>
              </div>
              <!-- End Col -->
            </div>
            <!-- End Row -->

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-borderless table-nowrap table-align-middle">
                <thead class="thead-light">
                  <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th class="table-text-end">Amount</th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <th>Design UX and UI</th>
                    <td>1</td>
                    <td>5</td>
                    <td class="table-text-end">$500</td>
                  </tr>

                  <tr>
                    <th>Web project</th>
                    <td>1</td>
                    <td>24</td>
                    <td class="table-text-end">$1250</td>
                  </tr>

                  <tr>
                    <th>SEO</th>
                    <td>1</td>
                    <td>6</td>
                    <td class="table-text-end">$2000</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- End Table -->

            <hr class="my-5">

            <div class="row justify-content-md-end mb-3">
              <div class="col-md-8 col-lg-7">
                <dl class="row text-sm-end">
                  <dt class="col-sm-6">Subtotal:</dt>
                  <dd class="col-sm-6">$<?php echo number_format($total ?? 2750, 2); ?></dd>
                  <dt class="col-sm-6">Total:</dt>
                  <dd class="col-sm-6">$<?php echo number_format($total ?? 2750, 2); ?></dd>
                  <dt class="col-sm-6">Tax:</dt>
                  <dd class="col-sm-6">$39.00</dd>
                  <dt class="col-sm-6">Amount paid:</dt>
                  <dd class="col-sm-6">$2789.00</dd>
                  <dt class="col-sm-6">Due balance:</dt>
                  <dd class="col-sm-6">$0.00</dd>
                </dl>
                <!-- End Row -->
              </div>
            </div>
            <!-- End Row -->

            <div class="mb-3">
              <h3>Thank you!</h3>
              <p>If you have any questions concerning this invoice, use the following contact information:</p>
            </div>

            <p class="small mb-0">&copy; 2021 Htmlstream.</p>
          </div>
        </div>
        <!-- End Card -->

        <!-- Footer -->
        <div class="d-flex justify-content-end d-print-none gap-3">
          <a class="btn btn-white" href="#">
            <i class="bi-file-earmark-arrow-down me-1"></i> PDF
          </a>

          <a class="btn btn-primary" href="javascript:;" onclick="window.print(); return false;">
            <i class="bi-printer me-1"></i> Print details
          </a>
        </div>
        <!-- End Footer -->
      </div>
    </div>
    <!-- End Content -->
  </main>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- JS Global Compulsory  -->
  <!-- Ajustar rutas de assets -->
  <script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Front -->
  <script src="/assets/js/theme.min.js"></script>
</body>
</html>

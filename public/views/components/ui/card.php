<?php
/**
 * Componente: Card
 * Tarjeta flexible basada en Bootstrap con estilos de Front
 * 
 * @var string|null $title - Título de la tarjeta
 * @var string $content - Contenido HTML de la tarjeta
 * @var string|null $footer - Footer HTML (opcional)
 * @var string|null $image - URL de imagen superior (opcional)
 * @var string|null $imageAlt - Texto alternativo de la imagen
 * @var string|null $class - Clases CSS adicionales
 * @var string|null $headerClass - Clases CSS para el header
 * @var string|null $bodyClass - Clases CSS para el body
 */

// Valores por defecto
$class = $class ?? '';
$headerClass = $headerClass ?? '';
$bodyClass = $bodyClass ?? '';
$imageAlt = $imageAlt ?? '';
?>

<div class="card <?php echo htmlspecialchars($class); ?>">
  <?php if (isset($image) && $image): ?>
  <!-- Image -->
  <img src="<?php echo htmlspecialchars($image); ?>" 
       class="card-img-top" 
       alt="<?php echo htmlspecialchars($imageAlt); ?>">
  <!-- End Image -->
  <?php endif; ?>

  <?php if (isset($title) && $title): ?>
  <!-- Header -->
  <div class="card-header <?php echo htmlspecialchars($headerClass); ?>">
    <h5 class="card-title mb-0"><?php echo htmlspecialchars($title); ?></h5>
  </div>
  <!-- End Header -->
  <?php endif; ?>

  <!-- Body -->
  <div class="card-body <?php echo htmlspecialchars($bodyClass); ?>">
    <?php echo $content; ?>
  </div>
  <!-- End Body -->

  <?php if (isset($footer) && $footer): ?>
  <!-- Footer -->
  <div class="card-footer">
    <?php echo $footer; ?>
  </div>
  <!-- End Footer -->
  <?php endif; ?>
</div>

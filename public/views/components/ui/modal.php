<?php
/**
 * Componente: Modal
 * Modal reutilizable basado en Bootstrap con estilos de Front
 * 
 * @var string $id - ID único del modal
 * @var string $title - Título del modal
 * @var string $content - Contenido HTML del modal
 * @var string|null $footer - Footer HTML del modal (opcional)
 * @var string $size - Tamaño: sm, md (default), lg, xl
 * @var bool $centered - Centrar verticalmente (default: false)
 * @var bool $scrollable - Hacer el contenido scrollable (default: false)
 */

// Valores por defecto
$size = $size ?? 'md';
$centered = $centered ?? false;
$scrollable = $scrollable ?? false;

// Clases de tamaño
$sizeClass = '';
if ($size === 'sm') $sizeClass = 'modal-sm';
elseif ($size === 'lg') $sizeClass = 'modal-lg';
elseif ($size === 'xl') $sizeClass = 'modal-xl';

$modalClasses = trim("modal-dialog {$sizeClass} " . 
                     ($centered ? 'modal-dialog-centered ' : '') . 
                     ($scrollable ? 'modal-dialog-scrollable' : ''));
?>

<div class="modal fade" id="<?php echo htmlspecialchars($id); ?>" tabindex="-1" aria-labelledby="<?php echo htmlspecialchars($id); ?>Label" aria-hidden="true">
  <div class="<?php echo $modalClasses; ?>">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo htmlspecialchars($id); ?>Label">
          <?php echo htmlspecialchars($title); ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <?php echo $content; ?>
      </div>
      <!-- End Body -->

      <?php if (isset($footer) && $footer): ?>
      <!-- Footer -->
      <div class="modal-footer">
        <?php echo $footer; ?>
      </div>
      <!-- End Footer -->
      <?php endif; ?>
    </div>
  </div>
</div>

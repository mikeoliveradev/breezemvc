<?php
/**
 * Componente: Alert (Alerta)
 * Sistema de alertas responsive basado en Bootstrap con estilos de Front
 * 
 * @var string $type - Tipo de alerta: success, error/danger, warning, info
 * @var string $message - Mensaje a mostrar
 * @var bool $dismissible - Si la alerta puede cerrarse (default: true)
 * @var string|null $icon - Icono Bootstrap opcional (ej: 'bi-check-circle')
 */

// Valores por defecto
$type = $type ?? 'info';
$dismissible = $dismissible ?? true;

// Mapeo de tipos a clases de Bootstrap
$typeClasses = [
    'success' => 'alert-soft-success',
    'error' => 'alert-soft-danger',
    'danger' => 'alert-soft-danger',
    'warning' => 'alert-soft-warning',
    'info' => 'alert-soft-info'
];

// Mapeo de tipos a iconos por defecto
$defaultIcons = [
    'success' => 'bi-check-circle',
    'error' => 'bi-exclamation-triangle',
    'danger' => 'bi-exclamation-triangle',
    'warning' => 'bi-exclamation-diamond',
    'info' => 'bi-info-circle'
];

$alertClass = $typeClasses[$type] ?? 'alert-soft-info';
$iconClass = $icon ?? $defaultIcons[$type] ?? 'bi-info-circle';
?>

<div class="alert <?php echo $alertClass; ?> <?php echo $dismissible ? 'alert-dismissible fade show' : ''; ?>" role="alert">
  <div class="d-flex">
    <div class="flex-shrink-0">
      <i class="<?php echo htmlspecialchars($iconClass); ?>"></i>
    </div>
    <div class="flex-grow-1 ms-2">
      <?php echo htmlspecialchars($message); ?>
    </div>
    <?php if ($dismissible): ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <?php endif; ?>
  </div>
</div>

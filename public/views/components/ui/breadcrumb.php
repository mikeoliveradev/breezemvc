<?php
/**
 * Componente: Breadcrumb
 * Navegación de migas de pan basada en Bootstrap
 * 
 * @var array $items - Array de items del breadcrumb
 *                     Cada item: ['label' => 'Texto', 'url' => '/ruta'] o solo 'Texto' para el último
 */

$items = $items ?? [];
?>

<?php if (!empty($items)): ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php foreach ($items as $index => $item): ?>
      <?php 
      $isLast = ($index === count($items) - 1);
      $label = is_array($item) ? $item['label'] : $item;
      $url = is_array($item) && isset($item['url']) ? $item['url'] : null;
      ?>
      
      <li class="breadcrumb-item <?php echo $isLast ? 'active' : ''; ?>" 
          <?php echo $isLast ? 'aria-current="page"' : ''; ?>>
        <?php if (!$isLast && $url): ?>
          <a href="<?php echo htmlspecialchars($url); ?>">
            <?php echo htmlspecialchars($label); ?>
          </a>
        <?php else: ?>
          <?php echo htmlspecialchars($label); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
<?php endif; ?>

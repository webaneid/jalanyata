<?php
require_once __DIR__ . '/layout_context.php';

$layoutContext = jalanyata_build_layout_context([
    'layoutMode' => $layoutMode ?? null,
]);
$currentYear = date('Y');
$firstProductYear = $_SESSION['first_product_year'] ?? $currentYear;
$yearText = ($firstProductYear == $currentYear) ? $currentYear : $firstProductYear . ' - ' . $currentYear;
$layoutMode = $layoutContext['layoutMode'];
$companyName = $layoutContext['companyName'];
$frontendTemplateConfig = $layoutContext['frontendTemplateConfig'];
?>
    <?php if ($layoutMode === 'admin'): ?>
        </div>
    </div>
    <?php endif; ?>
    <footer class="ane-footer">
        <div class="ane-footer__inner">
            &copy; <?= $yearText ?> <?= htmlspecialchars($companyName) ?>. <?= htmlspecialchars((string) ($frontendTemplateConfig['footer_note'] ?? 'Seluruh hak cipta dilindungi.'), ENT_QUOTES, 'UTF-8') ?>
        </div>
    </footer>
</body>
</html>

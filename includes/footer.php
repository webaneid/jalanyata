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
?>
    <?php if ($layoutMode === 'admin'): ?>
        </div>
    </div>
    <?php endif; ?>
    <footer class="ane-footer">
        <div class="ane-footer__inner">
            &copy; <?= $yearText ?> <?= htmlspecialchars($companyName) ?>. All rights reserved - developed by <a href="http://webane.com" class="ane-footer__link">Webane Indonesia</a>
        </div>
    </footer>
</body>
</html>

<?php
require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('developer');

require_once __DIR__ . '/../includes/products.php';

$layoutMode = 'admin';
$pageTitle = 'Hasil Generate Produk';
$generatedBatch = jalanyata_get_generated_products_batch();

if ($generatedBatch === null || empty($generatedBatch['items'])) {
    jalanyata_flash_set('generator_error', 'Belum ada hasil generate produk untuk ditampilkan.');
    jalanyata_redirect('/admin/generate_products.php');
}

$generatedItems = $generatedBatch['items'];
$generatedCount = (int) ($generatedBatch['count'] ?? count($generatedItems));
$generatedExcelUrl = app_path_url('/api/products.php?action=generated_excel');

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/generated_products_result/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/generated_products_result/list-section.php'; ?>
</main>
<?php require __DIR__ . '/../views/admin/generated_products_result/page-script.php'; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

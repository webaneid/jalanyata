<?php
require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('developer');

require_once __DIR__ . '/../includes/products.php';
require_once __DIR__ . '/../config/database.php';

$layoutMode = 'admin';
$pageTitle = 'Generate Produk Massal';
$generateProductsAction = app_path_url('/api/products.php?action=generate');
$sizeOptions = [];

try {
    $sizeOptions = jalanyata_fetch_product_size_options($conn);
} catch (PDOException $e) {
    echo 'Error mengambil master ukuran: ' . $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/generate_products/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/generate_products/form-section.php'; ?>
</main>
<?php require __DIR__ . '/../views/admin/generate_products/form-script.php'; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

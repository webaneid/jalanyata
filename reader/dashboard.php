<?php
// File: reader/dashboard.php
// Fungsi: Halaman dashboard untuk user dengan role 'reader'.

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('reader');

require_once __DIR__ . '/../includes/products.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Dashboard Reader';
$rowActionRenderer = 'jalanyata_render_reader_product_row_actions';
$readerSearchAction = app_path_url('/reader/dashboard.php');
$readerListPath = '/reader/dashboard.php';

$products = [];
$filters = jalanyata_product_filter_state(20);
$page = $filters['page'];
$searchQuery = $filters['searchQuery'];
$weightFilter = $filters['weightFilter'];
$sortOrder = $filters['sortOrder'];

try {
    $productPage = jalanyata_fetch_product_page($conn, $filters);
    $products = $productPage['products'];
    $totalProducts = $productPage['totalProducts'];
    $totalPages = $productPage['totalPages'];
    $weights = jalanyata_fetch_product_weights($conn);
} catch (PDOException $e) {
    echo "Error mengambil data produk: " . $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-page ane-section-stack" style="padding:32px 16px;">
    <?php require __DIR__ . '/../views/reader/dashboard/page-head.php'; ?>
    <?php require __DIR__ . '/../views/reader/dashboard/list-section.php'; ?>
</main>
<?php require __DIR__ . '/../views/reader/dashboard/page-script.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

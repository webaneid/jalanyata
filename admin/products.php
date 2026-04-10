<?php
// File: admin/products.php
// Fungsi: Halaman admin untuk mengelola daftar produk (tambah, edit, hapus).

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');

require_once __DIR__ . '/../includes/products.php';
require_once __DIR__ . '/../config/database.php';
$layoutMode = 'admin';
$pageTitle = 'Kelola Produk';
$productCreateAction = app_path_url('/api/products.php?action=add');
$productEditAction = app_path_url('/api/products.php?action=edit');
$rowActionRenderer = 'jalanyata_render_admin_product_row_actions';
$productSearchAction = app_path_url('/admin/products.php');
$productListPath = '/admin/products.php';

$weights = [];
$products = [];
$filters = jalanyata_product_filter_state(200);
$page = $filters['page'];
$searchQuery = $filters['searchQuery'];
$weightFilter = $filters['weightFilter'];
$sortOrder = $filters['sortOrder'];

try {
    $productPage = jalanyata_fetch_product_page($conn, $filters);
    $products = $productPage['products'];
    $totalProducts = $productPage['totalProducts'];
    $totalPages = $productPage['totalPages'];
    $allProducts = jalanyata_fetch_filtered_products($conn, $filters, 'product_id_code');
    $weights = jalanyata_fetch_product_weights($conn);
} catch (PDOException $e) {
    echo "Error mengambil data produk: " . $e->getMessage();
}

// Sertakan header halaman
require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/products/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/products/form-section.php'; ?>
    <?php require __DIR__ . '/../views/admin/products/list-section.php'; ?>
</main>
<?php require __DIR__ . '/../views/admin/products/page-script.php'; ?>
<?php
require_once __DIR__ . '/../includes/footer.php';
?>

<?php
// File: admin/product_photos.php
// Fungsi: Halaman admin untuk mengelola foto produk berdasarkan berat

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');
require_once __DIR__ . '/../includes/admin_product_photos.php';
require_once __DIR__ . '/../config/database.php';
$layoutMode = 'admin';
$pageTitle = 'Kelola Foto Produk';
$productPhotoCreateAction = app_path_url('/api/product_photos.php?action=add');
$productPhotoEditAction = app_path_url('/api/product_photos.php?action=edit');
$productPhotoDeleteAction = app_path_url('/api/product_photos.php?action=delete');

$photos = [];
try {
    $photos = jalanyata_fetch_product_photos($conn);
} catch (PDOException $e) {
    echo "Error mengambil data foto produk: " . $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/product_photos/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/product_photos/form-section.php'; ?>
    <?php require __DIR__ . '/../views/admin/product_photos/list-section.php'; ?>
</main>
<?php require __DIR__ . '/../views/admin/product_photos/form-script.php'; ?>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

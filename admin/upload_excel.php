<?php
// File: admin/upload_excel.php
// Fungsi: Halaman admin untuk mengunggah file Excel produk.

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');

$layoutMode = 'admin';
$pageTitle = 'Upload Produk dari Excel';
$uploadExcelAction = app_path_url('/api/products.php?action=upload');

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/upload_excel/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/upload_excel/form-section.php'; ?>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

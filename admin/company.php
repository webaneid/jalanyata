<?php
// File: admin/company.php
// Fungsi: Halaman admin untuk mengelola data perusahaan

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');
require_once __DIR__ . '/../includes/admin_company.php';
require_once __DIR__ . '/../config/database.php';
$layoutMode = 'admin';
$pageTitle = 'Kelola Data Perusahaan';
$companyUpdateAction = app_path_url('/api/company.php?action=update');

$company = null;
try {
    $company = jalanyata_fetch_company_record($conn);
} catch (PDOException $e) {
    echo "Error mengambil data perusahaan: " . $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/company/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/company/form-section.php'; ?>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

<?php
// File: admin/dashboard.php
// Fungsi: Tampilan halaman dashboard admin (setelah login) dengan chart dan statistik.

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');

require_once __DIR__ . '/../includes/admin_dashboard.php';
require_once __DIR__ . '/../config/database.php';
$layoutMode = 'admin';
$pageTitle = 'Dashboard Admin';

// --- Ambil Data dari Database ---
$totalProducts = 0;
$totalUsers = 0;
$productWeightData = [];
$productGrowthData = [];

try {
    $dashboardSummary = jalanyata_fetch_dashboard_summary($conn);
    $totalProducts = $dashboardSummary['totalProducts'];
    $totalUsers = $dashboardSummary['totalUsers'];
    $productWeightData = $dashboardSummary['productWeightData'];
    $productGrowthData = $dashboardSummary['productGrowthData'];
} catch (PDOException $e) {
    // Tangani error database dengan gracefully
    echo "Error mengambil data dari database: " . $e->getMessage();
}

$dashboardShortcutLinks = jalanyata_dashboard_shortcut_links($_SESSION['user_role'] ?? null);

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <section class="ane-page-head">
        <div>
            <h1 class="ane-page-head__title">Dashboard Admin</h1>
            <p class="ane-page-head__meta">Ringkasan statistik dan akses cepat modul Jalanyata.</p>
        </div>
    </section>

    <?php require __DIR__ . '/../views/admin/dashboard/metrics.php'; ?>

    <?php require __DIR__ . '/../views/admin/dashboard/charts.php'; ?>

    <?php require __DIR__ . '/../views/admin/dashboard/shortcuts.php'; ?>
</main>
<?php require __DIR__ . '/../views/admin/dashboard/chart-script.php'; ?>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

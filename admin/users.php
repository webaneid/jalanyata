<?php
require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');

require_once __DIR__ . '/../includes/admin_users.php';
require_once __DIR__ . '/../config/database.php';
$layoutMode = 'admin';
$pageTitle = 'Kelola User Admin';
$userCreateAction = app_path_url('/api/users.php?action=add');
$userEditAction = app_path_url('/api/users.php?action=edit');
$userDeleteAction = app_path_url('/api/users.php?action=delete');
$userSearchAction = app_path_url('/admin/users.php');
$userListPath = '/admin/users.php';

$filters = jalanyata_user_list_state(10);
$users = [];
$page = $filters['page'];
$searchQuery = $filters['searchQuery'];
$totalPages = 0;

try {
    $userPage = jalanyata_fetch_user_page($conn, $filters);
    $users = $userPage['users'];
    $totalPages = $userPage['totalPages'];
} catch (PDOException $e) {
    echo "Error mengambil data user: " . $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/users/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/users/form-section.php'; ?>
    <?php require __DIR__ . '/../views/admin/users/list-section.php'; ?>
</main>
<?php require __DIR__ . '/../views/admin/users/form-script.php'; ?>
<?php
require_once __DIR__ . '/../includes/footer.php';
?>

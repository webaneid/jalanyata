<?php
// File: admin/login.php
// Fungsi: Halaman login administrator

require_once __DIR__ . '/../includes/auth.php';
jalanyata_session_start();
$pageTitle = 'Login Admin';

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-login">
    <div class="ane-panel ane-panel--padded ane-login__card">
        <h2 class="ane-login__title">Login Admin</h2>
        <p class="ane-login__meta">Masuk untuk mengakses backoffice Jalanyata.</p>

        <?php jalanyata_flash_render('login_error', 'danger'); ?>

        <form action="<?= app_path_url('/api/users.php?action=login') ?>" method="POST" class="ane-section-stack">
            <div class="ane-field">
                <label for="username" class="ane-label">Username / Email</label>
                <input type="text" id="username" name="username" class="ane-input" required>
            </div>
            <div class="ane-field">
                <label for="password" class="ane-label">Password</label>
                <input type="password" id="password" name="password" class="ane-input" required>
            </div>
            <button type="submit" class="ane-button" style="width:100%;">Login</button>
        </form>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

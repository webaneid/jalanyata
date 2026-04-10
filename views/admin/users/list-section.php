<section class="ane-panel ane-panel--padded">
    <h2 class="ane-page-head__title" style="font-size:1.25rem;">Daftar User</h2>
    <?php require __DIR__ . '/table.php'; ?>
    <?php jalanyata_render_user_pagination($userListPath, $filters, $page, $totalPages); ?>
</section>

<section class="ane-panel ane-panel--padded ane-section-stack">
    <div class="ane-actions">
        <?php require __DIR__ . '/search-form.php'; ?>
    </div>

    <div class="ane-alert ane-alert--info" role="alert">
        Untuk download massal, pilih produk di bawah ini.
    </div>

    <h2 class="ane-page-head__title" style="font-size:1.25rem;">Daftar Produk</h2>
    <?php require __DIR__ . '/list-toolbar.php'; ?>
    <?php require __DIR__ . '/../../products/table.php'; ?>
    <?php jalanyata_render_product_pagination($readerListPath, $filters, $page, $totalPages); ?>
</section>

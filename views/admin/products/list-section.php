<section class="ane-panel ane-panel--padded">
    <h2 class="ane-page-head__title" style="font-size:1.25rem;">Daftar Produk</h2>
    <?php require __DIR__ . '/list-toolbar.php'; ?>
    <?php require __DIR__ . '/../../products/table.php'; ?>
    <?php jalanyata_render_product_pagination($productListPath, $filters, $page, $totalPages); ?>
</section>

<section class="ane-panel ane-panel--padded">
    <div class="ane-actions">
        <?php require __DIR__ . '/search-form.php'; ?>
    </div>

    <?php jalanyata_flash_render('product_success', 'success'); ?>
    <?php jalanyata_flash_render('product_error', 'danger'); ?>

    <?php require __DIR__ . '/form.php'; ?>
</section>

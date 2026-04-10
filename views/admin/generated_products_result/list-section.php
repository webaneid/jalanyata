<section class="ane-panel ane-panel--padded ane-section-stack">
    <?php jalanyata_flash_render('generator_success', 'success'); ?>
    <?php jalanyata_flash_render('generator_error', 'danger'); ?>

    <div class="ane-actions">
        <div class="ane-form-inline">
            <button id="download-all-btn" type="button" class="ane-button">Download All QR Code (ZIP HD)</button>
            <a href="<?= htmlspecialchars($generatedExcelUrl, ENT_QUOTES, 'UTF-8') ?>" class="ane-button ane-button--secondary">Download Excel</a>
        </div>
    </div>

    <div class="ane-table-wrap">
        <table class="ane-table">
            <thead>
                <tr>
                    <th scope="col">Kode Produk</th>
                    <th scope="col">Ukuran</th>
                    <th scope="col">Tanggal Produksi</th>
                    <th scope="col">URL Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($generatedItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $item['product_id_code'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $item['product_weight'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $item['product_date'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="<?= htmlspecialchars((string) $item['verification_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" class="ane-link">
                                <?= htmlspecialchars((string) $item['verification_url'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

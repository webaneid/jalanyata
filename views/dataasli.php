<?php
// File: views/dataasli.php
// Fungsi: Tampilan untuk produk yang terverifikasi sebagai asli

$photo_url = $product['photo_url'] ?? null;
$verifyCopy = $frontendTemplateConfig ?? [];
$isDarkVerifyTemplate = ($frontendTemplateKey ?? '') === 'silver-scan-dark';
?>
<main class="ane-verify">
    <div class="ane-verify__shell">
        <section class="ane-verify__card ane-verify__card--success">
            <div class="ane-verify__header">
                <div class="ane-verify__status">
                    <div class="ane-verify__icon ane-verify__icon--success">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="ane-verify__eyebrow"><?= htmlspecialchars((string) ($verifyCopy['verified_eyebrow'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        <h1 class="ane-verify__title"><?= htmlspecialchars((string) ($verifyCopy['verified_title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h1>
                    </div>
                </div>
                <div class="ane-verify__serial"><?= htmlspecialchars($product['product_id_code']) ?></div>
            </div>

            <div class="ane-verify__plate">
                <div class="ane-verify__plate-copy">
                    <p class="ane-verify__lead">
                        <?= htmlspecialchars(jalanyata_frontend_template_replace_vars((string) ($verifyCopy['verified_lead'] ?? ''), [
                            '%company%' => (string) $companyName,
                            '%code%' => (string) $product['product_id_code'],
                        ]), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <?php if ($isDarkVerifyTemplate): ?>
                        <div class="ane-verify__detail-list ane-verify__detail-list--verified">
                            <div class="ane-verify__detail-row">
                                <span class="ane-verify__detail-label"><?= htmlspecialchars((string) ($verifyCopy['verified_label_code'] ?? 'Kode Produk'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong class="ane-verify__detail-value"><?= htmlspecialchars($product['product_id_code']) ?></strong>
                            </div>
                            <div class="ane-verify__detail-row">
                                <span class="ane-verify__detail-label"><?= htmlspecialchars((string) ($verifyCopy['verified_label_category'] ?? 'Kategori Produk'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong class="ane-verify__detail-value"><?= htmlspecialchars((string) ($product['category_name'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                            <div class="ane-verify__detail-row">
                                <span class="ane-verify__detail-label"><?= htmlspecialchars((string) ($verifyCopy['verified_label_weight'] ?? 'Berat'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong class="ane-verify__detail-value"><?= htmlspecialchars($product['product_weight']) ?></strong>
                            </div>
                            <div class="ane-verify__detail-row">
                                <span class="ane-verify__detail-label"><?= htmlspecialchars((string) ($verifyCopy['verified_label_date'] ?? 'Tanggal Produksi'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong class="ane-verify__detail-value"><?= htmlspecialchars($product['product_date']) ?></strong>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="ane-verify__detail-grid ane-verify__detail-grid--verified">
                            <div class="ane-verify__detail-item">
                                <span><?= htmlspecialchars((string) ($verifyCopy['verified_label_code'] ?? 'Kode Produk'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong><?= htmlspecialchars($product['product_id_code']) ?></strong>
                            </div>
                            <div class="ane-verify__detail-item">
                                <span><?= htmlspecialchars((string) ($verifyCopy['verified_label_category'] ?? 'Kategori Produk'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong><?= htmlspecialchars((string) ($product['category_name'] ?? '-'), ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                            <div class="ane-verify__detail-item">
                                <span><?= htmlspecialchars((string) ($verifyCopy['verified_label_weight'] ?? 'Berat'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong><?= htmlspecialchars($product['product_weight']) ?></strong>
                            </div>
                            <div class="ane-verify__detail-item">
                                <span><?= htmlspecialchars((string) ($verifyCopy['verified_label_date'] ?? 'Tanggal Produksi'), ENT_QUOTES, 'UTF-8') ?></span>
                                <strong><?= htmlspecialchars($product['product_date']) ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($photo_url): ?>
                    <div class="ane-verify__media-frame">
                        <div class="ane-verify__media">
                            <img src="<?= htmlspecialchars($photo_url) ?>" alt="Foto Produk">
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <p class="ane-verify__meta">
                <?= htmlspecialchars(jalanyata_frontend_template_replace_vars((string) ($verifyCopy['verified_meta'] ?? ''), [
                    '%company%' => (string) $companyName,
                ]), ENT_QUOTES, 'UTF-8') ?>
            </p>
            <div class="ane-verify__actions">
                <a href="<?= app_path_url('/') ?>" class="ane-button ane-button--secondary"><?= htmlspecialchars((string) ($verifyCopy['verified_back_button_label'] ?? 'Cek Kode Lain'), ENT_QUOTES, 'UTF-8') ?></a>
            </div>
        </section>
    </div>
</main>

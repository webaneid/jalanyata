<!-- File: views/datatidakasli.php -->
<!-- Fungsi: Tampilan untuk produk yang tidak terverifikasi -->
<?php $verifyCopy = $frontendTemplateConfig ?? []; ?>
<main class="ane-verify">
    <div class="ane-verify__shell">
        <section class="ane-verify__card ane-verify__card--danger">
            <div class="ane-verify__header">
                <div class="ane-verify__status">
                    <div class="ane-verify__icon ane-verify__icon--danger">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="ane-verify__eyebrow"><?= htmlspecialchars((string) ($verifyCopy['invalid_eyebrow'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        <h1 class="ane-verify__title"><?= htmlspecialchars((string) ($verifyCopy['invalid_title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h1>
                    </div>
                </div>
                <div class="ane-verify__serial"><?= htmlspecialchars(jalanyata_frontend_template_replace_vars((string) ($verifyCopy['invalid_serial'] ?? ''), [
                    '%company%' => (string) $companyName,
                ]), ENT_QUOTES, 'UTF-8') ?></div>
            </div>

            <div class="ane-verify__plate">
                <div class="ane-verify__plate-copy">
                    <p class="ane-verify__lead">
                        <?= htmlspecialchars((string) ($verifyCopy['invalid_lead'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <div class="ane-verify__detail-grid">
                        <div class="ane-verify__detail-item">
                            <span><?= htmlspecialchars((string) ($verifyCopy['invalid_label_status'] ?? 'Status'), ENT_QUOTES, 'UTF-8') ?></span>
                            <strong><?= htmlspecialchars((string) ($verifyCopy['invalid_detail_status_value'] ?? 'Tidak Ditemukan'), ENT_QUOTES, 'UTF-8') ?></strong>
                        </div>
                        <div class="ane-verify__detail-item">
                            <span><?= htmlspecialchars((string) ($verifyCopy['invalid_label_product'] ?? 'Produk'), ENT_QUOTES, 'UTF-8') ?></span>
                            <strong><?= htmlspecialchars((string) ($verifyCopy['invalid_detail_product_value'] ?? 'Belum Terverifikasi'), ENT_QUOTES, 'UTF-8') ?></strong>
                        </div>
                        <div class="ane-verify__detail-item">
                            <span><?= htmlspecialchars((string) ($verifyCopy['invalid_label_action'] ?? 'Tindakan'), ENT_QUOTES, 'UTF-8') ?></span>
                            <strong><?= htmlspecialchars((string) ($verifyCopy['invalid_detail_action_value'] ?? 'Periksa Kode Ulang'), ENT_QUOTES, 'UTF-8') ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <p class="ane-verify__meta">
                <?= htmlspecialchars((string) ($verifyCopy['invalid_meta'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </p>
            <div class="ane-verify__actions">
                <a href="<?= app_path_url('/') ?>" class="ane-button"><?= htmlspecialchars((string) ($verifyCopy['invalid_back_button_label'] ?? 'Ulangi atau cek kode baru'), ENT_QUOTES, 'UTF-8') ?></a>
            </div>
        </section>
    </div>
</main>

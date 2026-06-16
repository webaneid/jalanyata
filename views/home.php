<?php
$homeCopy = $frontendTemplateConfig ?? [];
$isScanTemplate = ($frontendTemplateKey ?? '') === 'silver-scan-dark';
?>
<main class="ane-hero<?= $isScanTemplate ? ' ane-hero--scan-dark' : '' ?>" data-verification-prefix="<?= htmlspecialchars(app_path_url('/cek'), ENT_QUOTES, 'UTF-8') ?>">
    <div class="ane-hero__inner">
        <?php if ($isScanTemplate): ?>
            <div class="ane-hero__grid ane-hero__grid--scan">
                <section class="ane-scan-card">
                    <button type="button" class="ane-scan-launcher" data-scanner-open>
                        <span class="ane-scan-launcher__icon" aria-hidden="true">
                            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="10" y="12" width="44" height="40" rx="8" stroke="currentColor" stroke-width="3"></rect>
                                <rect x="18" y="20" width="28" height="24" rx="4" stroke="currentColor" stroke-width="2"></rect>
                                <path d="M23 32h18" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                                <path d="M32 23v18" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                                <path d="M14 52h36" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                            </svg>
                        </span>
                        <span class="ane-scan-launcher__title"><?= htmlspecialchars((string) ($homeCopy['home_scanner_button_label'] ?? 'Launch Scanner'), ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="ane-scan-launcher__hint"><?= htmlspecialchars((string) ($homeCopy['home_scanner_hint'] ?? 'Klik ikon untuk membuka kamera dan scan barcode.'), ENT_QUOTES, 'UTF-8') ?></span>
                    </button>
                    <p class="ane-scan-card__meta">
                        <?= htmlspecialchars((string) ($homeCopy['home_search_meta'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </section>

                <section class="ane-hero__copy ane-hero__copy--dark">
                    <p class="ane-hero__eyebrow"><?= htmlspecialchars(jalanyata_frontend_template_replace_vars((string) ($homeCopy['home_eyebrow'] ?? ''), ['%company%' => (string) $companyName]), ENT_QUOTES, 'UTF-8') ?></p>
                    <h1 class="ane-hero__title"><?= htmlspecialchars((string) ($homeCopy['home_title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h1>
                    <p class="ane-hero__lead">
                        <?= htmlspecialchars(jalanyata_frontend_template_replace_vars((string) ($homeCopy['home_lead'] ?? ''), ['%company%' => (string) $companyName]), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <div class="ane-search-slab ane-search-slab--dark">
                        <div class="ane-search-slab__head">
                            <p class="ane-search-slab__eyebrow"><?= htmlspecialchars((string) ($homeCopy['home_search_eyebrow'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="ane-search-slab__meta"><?= htmlspecialchars((string) ($homeCopy['home_search_meta'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="ane-searchbox">
                            <input
                                type="text"
                                id="product-code-input"
                                class="ane-input"
                                placeholder="<?= htmlspecialchars((string) ($homeCopy['home_placeholder'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                            />
                            <svg class="ane-searchbox__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-2.414-2.414A1 1 0 0015.586 6H10a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15h2m-2-4h2m-4-8v4"></path>
                            </svg>
                        </div>
                        <button id="verify-button" class="ane-button btn-ane" style="width:100%;">
                            <?= htmlspecialchars((string) ($homeCopy['home_button_label'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </button>
                    </div>
                </section>
            </div>
        <?php else: ?>
            <div class="ane-hero__grid">
                <section class="ane-hero__copy">
                    <p class="ane-hero__eyebrow"><?= htmlspecialchars(jalanyata_frontend_template_replace_vars((string) ($homeCopy['home_eyebrow'] ?? ''), ['%company%' => (string) $companyName]), ENT_QUOTES, 'UTF-8') ?></p>
                    <h1 class="ane-hero__title"><?= htmlspecialchars((string) ($homeCopy['home_title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h1>
                    <p class="ane-hero__lead">
                        <?= htmlspecialchars(jalanyata_frontend_template_replace_vars((string) ($homeCopy['home_lead'] ?? ''), ['%company%' => (string) $companyName]), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <div class="ane-search-slab">
                        <div class="ane-search-slab__head">
                            <p class="ane-search-slab__eyebrow"><?= htmlspecialchars((string) ($homeCopy['home_search_eyebrow'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="ane-search-slab__meta"><?= htmlspecialchars((string) ($homeCopy['home_search_meta'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="ane-searchbox">
                            <input
                                type="text"
                                id="product-code-input"
                                class="ane-input"
                                placeholder="<?= htmlspecialchars((string) ($homeCopy['home_placeholder'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                            />
                            <svg class="ane-searchbox__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-2.414-2.414A1 1 0 0015.586 6H10a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15h2m-2-4h2m-4-8v4"></path>
                            </svg>
                        </div>
                        <button id="verify-button" class="ane-button btn-ane" style="width:100%;">
                            <?= htmlspecialchars((string) ($homeCopy['home_button_label'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                        </button>
                    </div>
                </section>

                <aside class="ane-silver-specimen" aria-hidden="true">
                    <div class="ane-silver-specimen__frame">
                        <p class="ane-silver-specimen__brand"><?= htmlspecialchars((string) $companyName, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="ane-silver-specimen__subtype"><?= htmlspecialchars((string) ($homeCopy['home_specimen_subtype'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="ane-silver-specimen__type"><?= htmlspecialchars((string) ($homeCopy['home_specimen_type'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        <div class="ane-silver-specimen__seal"></div>
                        <p class="ane-silver-specimen__grade"><?= htmlspecialchars((string) ($homeCopy['home_specimen_grade'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="ane-silver-specimen__weight"><?= htmlspecialchars((string) ($homeCopy['home_specimen_weight'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="ane-silver-specimen__serial"><?= htmlspecialchars((string) ($homeCopy['home_specimen_serial'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </aside>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php if ($isScanTemplate): ?>
<div
    class="ane-scanner-modal ane-hidden"
    data-scanner-modal
    data-scanner-status-ready="<?= htmlspecialchars((string) ($homeCopy['home_scanner_status_ready'] ?? 'Siap memindai barcode.'), ENT_QUOTES, 'UTF-8') ?>"
    data-scanner-status-scanning="<?= htmlspecialchars((string) ($homeCopy['home_scanner_status_scanning'] ?? 'Memindai barcode...'), ENT_QUOTES, 'UTF-8') ?>"
    data-scanner-status-unsupported="<?= htmlspecialchars((string) ($homeCopy['home_scanner_status_unsupported'] ?? 'Scanner kamera tidak didukung di browser ini.'), ENT_QUOTES, 'UTF-8') ?>"
    data-scanner-status-denied="<?= htmlspecialchars((string) ($homeCopy['home_scanner_status_denied'] ?? 'Akses kamera ditolak.'), ENT_QUOTES, 'UTF-8') ?>"
    data-scanner-status-found="<?= htmlspecialchars((string) ($homeCopy['home_scanner_status_found'] ?? 'Kode ditemukan, membuka verifikasi.'), ENT_QUOTES, 'UTF-8') ?>"
    aria-hidden="true"
>
    <div class="ane-scanner-modal__backdrop" data-scanner-close></div>
    <div class="ane-scanner-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="scanner-modal-title">
        <h2 id="scanner-modal-title" class="ane-scanner-modal__title">
            <?= htmlspecialchars((string) ($homeCopy['home_scanner_modal_title'] ?? 'QR Scanner'), ENT_QUOTES, 'UTF-8') ?>
        </h2>
        <div class="ane-scanner-modal__viewport">
            <video data-scanner-video playsinline muted></video>
            <canvas data-scanner-canvas class="ane-hidden"></canvas>
        </div>
        <p class="ane-scanner-modal__status" data-scanner-status><?= htmlspecialchars((string) ($homeCopy['home_scanner_status_ready'] ?? 'Siap memindai barcode.'), ENT_QUOTES, 'UTF-8') ?></p>
        <button type="button" class="ane-button ane-button--secondary ane-scanner-modal__close" data-scanner-close>
            <?= htmlspecialchars((string) ($homeCopy['home_scanner_modal_close_label'] ?? 'Close Scanner'), ENT_QUOTES, 'UTF-8') ?>
        </button>
    </div>
</div>
<script src="<?= app_path_url('/assets/js/frontend-scanner.js') ?>"></script>
<?php endif; ?>

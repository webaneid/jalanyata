<?php
// File: views/dataasli.php
// Fungsi: Tampilan untuk produk yang terverifikasi sebagai asli

$photo_url = $product['photo_url'] ?? null;
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
                        <p class="ane-verify__eyebrow">Authenticity Confirmed</p>
                        <h1 class="ane-verify__title">Produk Silver Terverifikasi</h1>
                    </div>
                </div>
                <div class="ane-verify__serial"><?= htmlspecialchars($product['product_id_code']) ?></div>
            </div>

            <div class="ane-verify__plate">
                <div class="ane-verify__plate-copy">
                    <p class="ane-verify__lead">
                        Selamat, kode <span class="ane-verify__code"><?= htmlspecialchars($product['product_id_code']) ?></span> berhasil dicocokkan dengan data resmi <?= htmlspecialchars((string) $companyName, ENT_QUOTES, 'UTF-8') ?>.
                    </p>
                    <div class="ane-verify__detail-grid">
                        <div class="ane-verify__detail-item">
                            <span>Kode Produk</span>
                            <strong><?= htmlspecialchars($product['product_id_code']) ?></strong>
                        </div>
                        <div class="ane-verify__detail-item">
                            <span>Berat</span>
                            <strong><?= htmlspecialchars($product['product_weight']) ?></strong>
                        </div>
                        <div class="ane-verify__detail-item">
                            <span>Tanggal Produksi</span>
                            <strong><?= htmlspecialchars($product['product_date']) ?></strong>
                        </div>
                    </div>
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
                Informasi ini menjamin bahwa produk Anda telah terdaftar secara resmi di <?= htmlspecialchars((string) $companyName, ENT_QUOTES, 'UTF-8') ?>.
            </p>
            <div class="ane-verify__actions">
                <a href="<?= app_path_url('/') ?>" class="ane-button ane-button--secondary">Cek Kode Lain</a>
            </div>
        </section>
    </div>
</main>

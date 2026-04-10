<section class="ane-page-head">
    <div>
        <h1 class="ane-page-head__title">Hasil Generate Produk</h1>
        <p class="ane-page-head__meta"><?= htmlspecialchars((string) $generatedCount, ENT_QUOTES, 'UTF-8') ?> produk baru berhasil dibuat dan siap diunduh.</p>
    </div>
    <a href="<?= app_path_url('/admin/generate_products.php') ?>" class="ane-link">&larr; Kembali ke Generator</a>
</section>

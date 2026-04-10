<h2 id="form-title" class="ane-page-head__title" style="font-size:1.25rem;">Tambah Produk Baru</h2>
<form id="product-form" action="<?= htmlspecialchars($productCreateAction, ENT_QUOTES, 'UTF-8') ?>" method="POST" class="ane-section-stack">
    <input type="hidden" id="product_id" name="id">
    <div class="ane-grid ane-grid--3">
        <div class="ane-field">
            <label for="product_id_code" class="ane-label">Kode ID Produk</label>
            <input type="text" id="product_id_code" name="product_id_code" class="ane-input" required>
        </div>
        <div class="ane-field">
            <label for="product_weight" class="ane-label">Berat Produk</label>
            <select id="product_weight" name="product_weight" class="ane-select" required>
                <option value="">Pilih Berat</option>
                <?php foreach ($weights as $weight): ?>
                    <option value="<?= htmlspecialchars($weight, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($weight, ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="ane-field">
            <label for="product_date" class="ane-label">Tanggal Produksi</label>
            <input type="text" id="product_date" name="product_date" class="ane-input" required>
        </div>
    </div>
    <div class="ane-actions ane-actions--start">
        <button type="submit" id="submit-button" class="ane-button">Tambah Produk</button>
        <button type="button" id="cancel-button" class="ane-button ane-button--secondary ane-hidden">Batal</button>
    </div>
</form>

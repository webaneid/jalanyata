<form action="<?= htmlspecialchars($generateProductsAction, ENT_QUOTES, 'UTF-8') ?>" method="POST" class="ane-section-stack">
    <div class="ane-grid ane-grid--3">
        <div class="ane-field">
            <label for="category_id" class="ane-label">Pilih Kategori</label>
            <select id="category_id" name="category_id" class="ane-select" required>
                <option value="">Pilih kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= (int) $category['id'] ?>">
                        <?= htmlspecialchars((string) $category['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="ane-field">
            <label for="size_id" class="ane-label">Pilih Ukuran</label>
            <select id="size_id" name="size_id" class="ane-select" required disabled>
                <option value="">Pilih ukuran</option>
            </select>
        </div>
        <div class="ane-field">
            <label for="kodeukuran" class="ane-label">Kode Ukuran</label>
            <input
                type="text"
                id="kodeukuran"
                name="kodeukuran"
                class="ane-input"
                placeholder="Otomatis mengikuti ukuran"
                readonly
                required
            >
        </div>
    </div>

    <div class="ane-grid ane-grid--3">
        <div class="ane-field">
            <label for="production_code" class="ane-label">Kode Tanggal Produksi</label>
            <input
                type="text"
                id="production_code"
                name="production_code"
                class="ane-input"
                inputmode="numeric"
                maxlength="4"
                placeholder="contoh: 0426"
                required
            >
        </div>
        <div class="ane-field">
            <label for="start_sequence" class="ane-label">Urutan Pertama</label>
            <input
                type="text"
                id="start_sequence"
                name="start_sequence"
                class="ane-input"
                inputmode="numeric"
                placeholder="contoh: 0001"
                required
            >
        </div>
        <div class="ane-field">
            <label for="quantity" class="ane-label">Jumlah</label>
            <input
                type="number"
                id="quantity"
                name="quantity"
                class="ane-input"
                min="1"
                placeholder="contoh: 1000"
                required
            >
        </div>
    </div>

    <div class="ane-info-box">
        <p><strong>Hasil generate:</strong></p>
        <ul class="ane-list">
            <li>Kode produk dibentuk dari <strong>kode ukuran + MMYY + urutan</strong>.</li>
            <li>Tanggal produksi akan otomatis disimpan dalam format bulan dan tahun, misalnya <strong>0426 = April 2026</strong>.</li>
            <li>Seluruh proses dibatalkan jika ada kode produk hasil generate yang sudah ada di database.</li>
        </ul>
    </div>

    <div class="ane-actions ane-actions--start">
        <button type="submit" class="ane-button">Generate Produk</button>
    </div>
</form>

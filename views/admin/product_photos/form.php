<h2 id="form-title" class="ane-page-head__title" style="font-size:1.25rem;">Tambah Foto Produk Baru</h2>
<form
    id="photo-form"
    action="<?= htmlspecialchars($productPhotoCreateAction, ENT_QUOTES, 'UTF-8') ?>"
    method="POST"
    enctype="multipart/form-data"
    class="ane-section-stack"
>
    <input type="hidden" id="photo_id" name="id">
    <div class="ane-grid ane-grid--2">
        <div class="ane-field">
            <label for="kodeukuran" class="ane-label">Kode Ukuran</label>
            <input
                type="text"
                id="kodeukuran"
                name="kodeukuran"
                class="ane-input"
                placeholder="contoh: ASE"
                required
            >
        </div>
        <div class="ane-field">
            <label for="product_weight" class="ane-label">Ukuran</label>
            <input
                type="text"
                id="product_weight"
                name="product_weight"
                class="ane-input"
                placeholder="contoh: 10gram"
                required
            >
        </div>
    </div>
    <div class="ane-grid ane-grid--2">
        <div class="ane-field">
            <label for="photo_file" class="ane-label">File Foto</label>
            <input type="file" id="photo_file" name="photo_file" class="ane-input">
            <p id="photo-note" class="ane-note ane-hidden">Unggah file baru untuk mengganti foto.</p>
        </div>
    </div>
    <div class="ane-actions ane-actions--start">
        <button type="submit" id="submit-button" class="ane-button">Tambah Foto</button>
        <button type="button" id="cancel-button" class="ane-button ane-button--secondary ane-hidden">Batal</button>
    </div>
</form>

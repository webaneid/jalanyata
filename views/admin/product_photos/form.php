<h2 id="form-title" class="ane-page-head__title" style="font-size:1.25rem;">Tambah Foto Produk Baru</h2>
<form
    id="photo-form"
    action="<?= htmlspecialchars($productPhotoCreateAction, ENT_QUOTES, 'UTF-8') ?>"
    method="POST"
    enctype="multipart/form-data"
    class="ane-section-stack"
    data-category-create-action="<?= htmlspecialchars((string) $categoryCreateAction, ENT_QUOTES, 'UTF-8') ?>"
>
    <input type="hidden" id="photo_id" name="id">
    <div class="ane-grid ane-grid--2">
        <div class="ane-field">
            <label for="category_id" class="ane-label">Kategori</label>
            <div class="ane-form-inline ane-form-inline--stretch">
            <select id="category_id" name="category_id" class="ane-select" required>
                <option value="">Pilih kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= (int) $category['id'] ?>">
                        <?= htmlspecialchars((string) $category['name'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
                <button type="button" id="open-category-modal" class="ane-button ane-button--secondary ane-button--compact">Tambah</button>
            </div>
            <p class="ane-note">Kalau kategori belum ada, tambahkan langsung dari sini.</p>
        </div>
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
    </div>
    <div class="ane-grid ane-grid--2">
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

<div id="category-modal" class="ane-modal ane-hidden" aria-hidden="true">
    <div class="ane-modal__backdrop" data-category-modal-close></div>
    <div class="ane-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="category-modal-title">
        <h3 id="category-modal-title" class="ane-modal__title">Tambah Kategori</h3>
        <p class="ane-note">Buat kategori baru lalu pilih langsung di form ukuran.</p>
        <form id="category-form" class="ane-section-stack">
            <div class="ane-field">
                <label for="category_name" class="ane-label">Nama Kategori</label>
                <input type="text" id="category_name" class="ane-input" placeholder="contoh: Platinum" required>
            </div>
            <div class="ane-actions ane-actions--start">
                <button type="submit" class="ane-button">Simpan Kategori</button>
                <button type="button" class="ane-button ane-button--secondary" data-category-modal-close>Batal</button>
            </div>
        </form>
    </div>
</div>

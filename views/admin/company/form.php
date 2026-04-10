<h2 class="ane-page-head__title" style="font-size:1.25rem;">Informasi Perusahaan</h2>
<form action="<?= htmlspecialchars($companyUpdateAction, ENT_QUOTES, 'UTF-8') ?>" method="POST" enctype="multipart/form-data" class="ane-section-stack">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string) ($company['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
    <div class="ane-grid ane-grid--2">
        <div class="ane-field-group">
            <div class="ane-field">
                <label for="company_name" class="ane-label">Nama Perusahaan</label>
                <input type="text" id="company_name" name="company_name" value="<?= htmlspecialchars((string) ($company['company_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="ane-input" required>
            </div>
            <div class="ane-field">
                <label for="company_address" class="ane-label">Alamat</label>
                <textarea id="company_address" name="company_address" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) ($company['company_address'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <div class="ane-field">
                <label for="company_phone" class="ane-label">Nomor Telepon</label>
                <input type="text" id="company_phone" name="company_phone" value="<?= htmlspecialchars((string) ($company['company_phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="ane-input" required>
            </div>
            <div class="ane-field">
                <label for="company_whatsapp" class="ane-label">Nomor WhatsApp</label>
                <input type="text" id="company_whatsapp" name="company_whatsapp" value="<?= htmlspecialchars((string) ($company['company_whatsapp'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="ane-input" required>
            </div>
        </div>
        <div class="ane-field">
            <label for="company_logo" class="ane-label">Logo Perusahaan</label>
            <?php if (!empty($company['company_logo_url'])): ?>
                <img src="<?= htmlspecialchars((string) $company['company_logo_url'], ENT_QUOTES, 'UTF-8') ?>" alt="Logo Perusahaan" class="ane-media-thumb">
            <?php endif; ?>
            <input type="file" id="company_logo" name="company_logo" class="ane-input">
            <p class="ane-note">Unggah file baru untuk mengganti logo.</p>
        </div>
    </div>
    <button type="submit" class="ane-button">Simpan Perubahan</button>
</form>

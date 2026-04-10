<form action="<?= htmlspecialchars($uploadExcelAction, ENT_QUOTES, 'UTF-8') ?>" method="POST" enctype="multipart/form-data" class="ane-section-stack">
    <div class="ane-field">
        <label for="excel_file" class="ane-label">Pilih File Excel (.xlsx)</label>
        <input type="file" id="excel_file" name="excel_file" accept=".xlsx" class="ane-input" required>
    </div>
    <button type="submit" class="ane-button">Unggah File</button>
</form>

<div class="ane-info-box" style="margin-top:24px;">
    <p><strong>Catatan Penting:</strong></p>
    <ul class="ane-list">
        <li>Pastikan file Excel Anda hanya berisi data, tanpa baris header.</li>
        <li>Struktur kolom harus sesuai urutan: **Kode ID Produk**, **Berat Produk**, **Tanggal Produksi**.</li>
        <li>Fitur ini memerlukan library **PhpSpreadsheet**. Pastikan Anda sudah menginstalnya.</li>
    </ul>
</div>

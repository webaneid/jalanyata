<form action="<?= htmlspecialchars($productSearchAction, ENT_QUOTES, 'UTF-8') ?>" method="GET" class="ane-form-inline" style="width:100%;">
    <input type="text" name="search" placeholder="Cari Kode ID Produk..." value="<?= htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') ?>" class="ane-input">
    <button type="submit" class="ane-button">Cari</button>
</form>

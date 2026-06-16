<form action="<?= htmlspecialchars($productSearchAction, ENT_QUOTES, 'UTF-8') ?>" method="GET" class="ane-form-inline" style="width:100%;">
    <input type="text" name="search" placeholder="Cari Kode ID Produk..." value="<?= htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') ?>" class="ane-input">
    <?php if (($filters['weightFilter'] ?? '') !== ''): ?>
        <input type="hidden" name="weight" value="<?= htmlspecialchars((string) $filters['weightFilter'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <?php if (($filters['productFilter'] ?? '') !== ''): ?>
        <input type="hidden" name="product" value="<?= htmlspecialchars((string) $filters['productFilter'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <?php if (($filters['sortOrder'] ?? '') !== ''): ?>
        <input type="hidden" name="sort" value="<?= htmlspecialchars((string) $filters['sortOrder'], ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
    <button type="submit" class="ane-button">Cari</button>
</form>

<script>
    const categorySelect = document.getElementById('category_id');
    const sizeSelect = document.getElementById('size_id');
    const sizeCodeInput = document.getElementById('kodeukuran');
    const sizeOptions = <?= json_encode(array_map(static function ($sizeOption) {
        return [
            'id' => (int) $sizeOption['id'],
            'category_id' => (int) $sizeOption['category_id'],
            'product_weight' => (string) $sizeOption['product_weight'],
            'kodeukuran' => (string) $sizeOption['kodeukuran'],
        ];
    }, $sizeOptions), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    function resetSizeState() {
        sizeSelect.innerHTML = '<option value="">Pilih ukuran</option>';
        sizeSelect.value = '';
        sizeSelect.disabled = true;
        sizeCodeInput.value = '';
    }

    function populateSizesByCategory(categoryId) {
        resetSizeState();

        if (!categoryId) {
            return;
        }

        const filteredSizes = sizeOptions.filter((sizeOption) => String(sizeOption.category_id) === String(categoryId));

        filteredSizes.forEach((sizeOption) => {
            const option = document.createElement('option');
            option.value = String(sizeOption.id);
            option.dataset.code = sizeOption.kodeukuran;
            option.textContent = sizeOption.product_weight;
            sizeSelect.appendChild(option);
        });

        sizeSelect.disabled = filteredSizes.length === 0;
    }

    function syncSizeCodeFromSize() {
        const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
        sizeCodeInput.value = selectedOption ? selectedOption.dataset.code || '' : '';
    }

    categorySelect.addEventListener('change', () => populateSizesByCategory(categorySelect.value));
    sizeSelect.addEventListener('change', syncSizeCodeFromSize);
</script>

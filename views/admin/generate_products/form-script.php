<script>
    const productWeightSelect = document.getElementById('product_weight');
    const sizeCodeSelect = document.getElementById('kodeukuran');

    function syncSizeCodeFromWeight() {
        const selectedOption = productWeightSelect.options[productWeightSelect.selectedIndex];
        const code = selectedOption ? selectedOption.dataset.code || '' : '';
        sizeCodeSelect.value = code;
    }

    function syncWeightFromSizeCode() {
        const selectedOption = sizeCodeSelect.options[sizeCodeSelect.selectedIndex];
        const weight = selectedOption ? selectedOption.dataset.weight || '' : '';
        productWeightSelect.value = weight;
    }

    productWeightSelect.addEventListener('change', syncSizeCodeFromWeight);
    sizeCodeSelect.addEventListener('change', syncWeightFromSizeCode);
</script>

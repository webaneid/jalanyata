<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="<?= app_path_url('/assets/js/product-qr-core.js') ?>"></script>
<script src="<?= app_path_url('/assets/js/product-qr-admin.js') ?>"></script>
<script>
    const adminProductPage = JalanyataProductQr.initAdminProductPage({
        verifyBaseUrl: '<?= $baseDomain ?>/cek',
        previewSize: 80,
        downloadSize: 2000,
        zipNameSelected: 'qr-code-pilihan.zip',
        zipNameAll: 'qr-code-semua.zip',
        allProducts: <?= json_encode($allProducts) ?>
    });

    function editProduct(button) {
        const row = button.closest('tr');
        const id = row.dataset.id;
        const code = row.dataset.code;
        const weight = row.dataset.weight;
        const date = row.dataset.date || '';

        document.getElementById('form-title').innerText = 'Edit Produk';
        document.getElementById('product-form').action = <?= json_encode($productEditAction) ?>;
        document.getElementById('product_id').value = id;
        document.getElementById('product_id_code').value = code;
        document.getElementById('product_weight').value = weight;
        document.getElementById('product_date').value = date;
        document.getElementById('submit-button').innerText = 'Simpan Perubahan';
        document.getElementById('cancel-button').classList.remove('ane-hidden');
    }

    document.getElementById('cancel-button').addEventListener('click', () => {
        document.getElementById('form-title').innerText = 'Tambah Produk Baru';
        document.getElementById('product-form').action = <?= json_encode($productCreateAction) ?>;
        document.getElementById('product_id').value = '';
        document.getElementById('product_id_code').value = '';
        document.getElementById('product_weight').value = '';
        document.getElementById('product_date').value = '';
        document.getElementById('submit-button').innerText = 'Tambah Produk';
        document.getElementById('cancel-button').classList.add('ane-hidden');
    });

    function downloadQRCode(productId) {
        return adminProductPage.downloadQRCode(productId);
    }

    function downloadByWeight(weight) {
        return adminProductPage.downloadByWeight(weight);
    }
</script>

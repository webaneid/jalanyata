<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="<?= app_path_url('/assets/js/product-qr-core.js') ?>"></script>
<script src="<?= app_path_url('/assets/js/product-qr-reader.js') ?>"></script>
<script>
    const readerProductPage = JalanyataProductQr.initReaderProductPage({
        verifyBaseUrl: '<?= $baseDomain ?>/cek',
        previewSize: 80,
        downloadSize: 1080,
        zipNameSelected: 'qr-code-pilihan.zip',
        zipNameAll: 'qr-code-semua.zip'
    });

    function downloadQRCode(productId) {
        return readerProductPage.downloadQRCode(productId);
    }

    function downloadByWeight(weight) {
        return readerProductPage.downloadByWeight(weight);
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="<?= app_path_url('/assets/js/product-qr-core.js') ?>"></script>
<script>
    const generatedProducts = <?= json_encode($generatedItems, JSON_UNESCAPED_SLASHES) ?>;
    const verifyBaseUrl = <?= json_encode(rtrim(app_url('/cek'), '/')) ?>;

    document.getElementById('download-all-btn').addEventListener('click', async () => {
        if (generatedProducts.length === 0) {
            alert('Tidak ada produk hasil generate untuk diunduh.');
            return;
        }

        try {
            const result = await JalanyataProductQr.zipHighResQRCodes(
                generatedProducts.map((item) => ({
                    productCode: item.product_id_code,
                    productWeight: item.product_weight || ''
                })),
                {
                    verifyBaseUrl,
                    progressId: 'generated',
                    size: 2000
                }
            );

            saveAs(result.content, 'generated-products-qrcode-hd.zip');
            alert(`Berhasil mengunduh ${result.completed} QR code.`);
        } catch (error) {
            console.error(error);
            alert('Gagal membuat ZIP QR code.');
        }
    });
</script>

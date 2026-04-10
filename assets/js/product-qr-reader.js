window.JalanyataProductQr = (() => {
    const base = window.JalanyataProductQr || {};

    function initReaderProductPage(options = {}) {
        const config = {
            verifyBaseUrl: options.verifyBaseUrl || '',
            previewSize: options.previewSize || 80,
            downloadSize: options.downloadSize || 1080,
            zipNameSelected: options.zipNameSelected || 'qr-code-pilihan.zip',
            zipNameAll: options.zipNameAll || 'qr-code-semua.zip'
        };

        const handlers = {
            async downloadQRCode(productId) {
                const canvas = base.createPreviewCanvasForProduct(productId, config.downloadSize);

                if (!canvas) {
                    throw new Error('QR Code belum dibuat atau tidak ditemukan.');
                }

                base.triggerCanvasDownload(canvas, `qrcode_produk_${base.getProductCode(productId)}.png`);
            },
            async downloadSelected() {
                const selectedProducts = base.selectedProductItems();
                if (selectedProducts.length === 0) {
                    alert('Pilih setidaknya satu produk untuk diunduh.');
                    return;
                }

                const content = await base.zipPreviewQRCodes(selectedProducts, {
                    size: config.downloadSize
                });

                saveAs(content, config.zipNameSelected);
                alert('Pengunduhan selesai!');
            },
            async downloadAll() {
                if (!confirm('Anda yakin ingin mengunduh semua QR Code di halaman ini dalam bentuk ZIP?')) {
                    return;
                }

                const content = await base.zipPreviewQRCodes(base.pageProductItems(), {
                    size: config.downloadSize
                });

                saveAs(content, config.zipNameAll);
                alert('Pengunduhan selesai!');
            },
            async downloadByWeight(weight) {
                if (!confirm(`Anda yakin ingin mengunduh semua QR Code untuk produk dengan berat ${weight} dalam bentuk ZIP?`)) {
                    return;
                }

                const content = await base.zipPreviewQRCodes(
                    base.pageProductItems().filter((item) => item.productWeight === weight),
                    {
                        size: config.downloadSize
                    }
                );

                saveAs(content, `qr-code-${weight}.zip`);
                alert('Pengunduhan selesai!');
            }
        };

        base.initProductPage({
            verifyBaseUrl: config.verifyBaseUrl,
            previewSize: config.previewSize,
            onDownloadSelected: handlers.downloadSelected,
            onDownloadAll: handlers.downloadAll
        });

        return handlers;
    }

    return {
        ...base,
        initReaderProductPage
    };
})();

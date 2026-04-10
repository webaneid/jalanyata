window.JalanyataProductQr = (() => {
    const base = window.JalanyataProductQr || {};

    function initAdminProductPage(options = {}) {
        const config = {
            verifyBaseUrl: options.verifyBaseUrl || '',
            previewSize: options.previewSize || 80,
            downloadSize: options.downloadSize || 2000,
            zipNameSelected: options.zipNameSelected || 'qr-code-pilihan.zip',
            zipNameAll: options.zipNameAll || 'qr-code-semua.zip',
            allProducts: Array.isArray(options.allProducts) ? options.allProducts : []
        };

        async function downloadHighResZip(items, zipName, progressId) {
            try {
                const result = await base.zipHighResQRCodes(items, {
                    verifyBaseUrl: config.verifyBaseUrl,
                    progressId,
                    size: config.downloadSize,
                    onMissingCanvas(item) {
                        console.warn(`Failed to create QR code for product: ${item.productCode}`);
                    }
                });

                saveAs(result.content, zipName);
                alert(`Berhasil mengunduh ${result.completed} QR code!`);
            } catch (error) {
                console.error('Error saat membuat QR codes:', error);
                alert('Terjadi kesalahan saat membuat QR codes');
            }
        }

        const handlers = {
            async downloadQRCode(productId) {
                const productCode = base.getProductCode(productId);
                const canvas = await base.createHighResQRCode(`${config.verifyBaseUrl}/${productCode}`, config.downloadSize);

                if (!canvas) {
                    alert('Gagal membuat QR Code untuk download');
                    return;
                }

                base.triggerCanvasDownload(canvas, `qrcode_produk_${productCode}.png`);
            },
            async downloadSelected() {
                const selectedProducts = base.selectedProductItems();
                if (selectedProducts.length === 0) {
                    alert('Pilih setidaknya satu produk untuk diunduh.');
                    return;
                }

                await downloadHighResZip(selectedProducts, config.zipNameSelected, 'selected');
            },
            async downloadAll() {
                if (!confirm('Anda yakin ingin mengunduh semua QR Code produk dalam database?')) {
                    return;
                }

                await downloadHighResZip(
                    config.allProducts.map((product) => ({
                        productCode: product.product_id_code,
                        productWeight: product.product_weight || ''
                    })),
                    config.zipNameAll,
                    'all'
                );
            },
            async downloadByWeight(weight) {
                const productsByWeight = config.allProducts.filter((product) => product.product_weight === weight);
                const totalProducts = productsByWeight.length;

                if (totalProducts === 0) {
                    alert(`Tidak ada produk dengan berat ${weight}`);
                    return;
                }

                if (!confirm(`Anda yakin ingin mengunduh ${totalProducts} QR Code untuk produk dengan berat ${weight} dalam bentuk ZIP?`)) {
                    return;
                }

                await downloadHighResZip(
                    productsByWeight.map((product) => ({
                        productCode: product.product_id_code,
                        productWeight: product.product_weight || ''
                    })),
                    `qr-code-${weight}.zip`,
                    'weight'
                );
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
        initAdminProductPage
    };
})();

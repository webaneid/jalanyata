window.JalanyataProductQr = (() => {
    const externalScriptPromises = {};

    function loadExternalScript(src) {
        if (externalScriptPromises[src]) {
            return externalScriptPromises[src];
        }

        externalScriptPromises[src] = new Promise((resolve, reject) => {
            const existingScript = document.querySelector(`script[src="${src}"]`);
            if (existingScript) {
                if (existingScript.dataset.loaded === 'true') {
                    resolve();
                    return;
                }

                existingScript.addEventListener('load', () => {
                    existingScript.dataset.loaded = 'true';
                    resolve();
                }, { once: true });
                existingScript.addEventListener('error', reject, { once: true });
                return;
            }

            const script = document.createElement('script');
            script.src = src;
            script.async = true;
            script.addEventListener('load', () => {
                script.dataset.loaded = 'true';
                resolve();
            }, { once: true });
            script.addEventListener('error', reject, { once: true });
            document.head.appendChild(script);
        });

        return externalScriptPromises[src];
    }

    async function ensureZipSupport() {
        if (typeof JSZip === 'undefined') {
            await loadExternalScript('https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js');
        }

        if (typeof saveAs === 'undefined') {
            await loadExternalScript('https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js');
        }
    }

    function getProductRows() {
        return Array.from(document.querySelectorAll('tbody tr[data-id]'));
    }

    function getProductRow(productId) {
        return document.querySelector(`tr[data-id="${productId}"]`);
    }

    function getProductCode(productId) {
        const row = getProductRow(productId);
        return row ? row.dataset.code : '';
    }

    function getPreviewImage(productId) {
        const wrapper = document.getElementById(`qrcode-${productId}`);
        return wrapper ? wrapper.querySelector('img') : null;
    }

    function createCanvasFromPreviewImage(img, size) {
        if (!img) {
            return null;
        }

        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = size;
        canvas.height = size;
        context.fillStyle = 'rgba(255, 255, 255, 0)';
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.drawImage(img, 0, 0, size, size);

        return canvas;
    }

    function triggerCanvasDownload(canvas, fileName) {
        const downloadLink = document.createElement('a');
        downloadLink.href = canvas.toDataURL('image/png');
        downloadLink.download = fileName;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    function createPreviewQRCodes(verifyBaseUrl, size = 80) {
        getProductRows().forEach((row) => {
            const productId = row.dataset.id;
            const productCode = row.dataset.code;
            const target = document.getElementById(`qrcode-${productId}`);

            if (!target) {
                return;
            }

            new QRCode(target, {
                text: `${verifyBaseUrl}/${productCode}`,
                width: size,
                height: size,
                colorDark: '#000000',
                colorLight: '#ffffff'
            });
        });
    }

    function createHighResQRCode(text, size = 2000, timeoutMs = 5000) {
        return new Promise((resolve) => {
            const tempDiv = document.createElement('div');
            tempDiv.style.position = 'absolute';
            tempDiv.style.left = '-9999px';
            tempDiv.style.top = '-9999px';
            tempDiv.style.width = '200px';
            tempDiv.style.height = '200px';
            document.body.appendChild(tempDiv);

            let callbackCalled = false;
            let timeoutId;
            let intervalId;

            new QRCode(tempDiv, {
                text,
                width: size,
                height: size,
                colorDark: '#000000',
                colorLight: '#ffffff'
            });

            const cleanup = (canvas) => {
                if (callbackCalled) {
                    return;
                }

                callbackCalled = true;

                if (intervalId) {
                    clearInterval(intervalId);
                }

                if (timeoutId) {
                    clearTimeout(timeoutId);
                }

                if (document.body.contains(tempDiv)) {
                    document.body.removeChild(tempDiv);
                }

                resolve(canvas);
            };

            intervalId = setInterval(() => {
                const img = tempDiv.querySelector('img');
                if (img && img.complete && img.naturalWidth > 0) {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = size;
                    canvas.height = size;
                    context.drawImage(img, 0, 0, size, size);
                    cleanup(canvas);
                }
            }, 50);

            timeoutId = setTimeout(() => {
                console.warn('QR Code generation timeout for:', text);
                cleanup(null);
            }, timeoutMs);
        });
    }

    function createProgressModal(progressId, totalItems) {
        const wrapper = document.createElement('div');
        const barId = `progress-bar-${progressId}`;
        const valueId = `progress-value-${progressId}`;

        wrapper.innerHTML = `
            <div class="ane-progress-modal">
                <div class="ane-progress-modal__card">
                    <p class="ane-progress-modal__title">Membuat QR Code</p>
                    <div class="ane-progress-modal__track">
                        <div id="${barId}" class="ane-progress-modal__bar" style="width: 0%"></div>
                    </div>
                    <p class="ane-progress-modal__meta">
                        <span id="${valueId}" class="ane-progress-modal__value">0</span>/${totalItems}
                    </p>
                </div>
            </div>
        `;

        document.body.appendChild(wrapper);

        return {
            update(completedItems) {
                const progressPercent = totalItems === 0 ? 0 : Math.round((completedItems / totalItems) * 100);
                document.getElementById(valueId).textContent = completedItems;
                document.getElementById(barId).style.width = `${progressPercent}%`;
            },
            remove() {
                if (document.body.contains(wrapper)) {
                    document.body.removeChild(wrapper);
                }
            }
        };
    }

    function setupDropdowns() {
        const sortBtn = document.getElementById('sort-btn');
        const sortDropdown = document.getElementById('sort-dropdown');
        const weightFilterBtn = document.getElementById('weight-filter-btn');
        const weightDropdown = document.getElementById('weight-dropdown');

        if (sortBtn && sortDropdown) {
            sortBtn.addEventListener('click', () => {
                sortDropdown.classList.toggle('ane-hidden');
            });
        }

        if (weightFilterBtn && weightDropdown) {
            weightFilterBtn.addEventListener('click', () => {
                weightDropdown.classList.toggle('ane-hidden');
            });
        }

        window.addEventListener('click', (e) => {
            if (sortBtn && sortDropdown && !sortBtn.contains(e.target) && !sortDropdown.contains(e.target)) {
                sortDropdown.classList.add('ane-hidden');
            }

            if (weightFilterBtn && weightDropdown && !weightFilterBtn.contains(e.target) && !weightDropdown.contains(e.target)) {
                weightDropdown.classList.add('ane-hidden');
            }
        });
    }

    function setupSelectAll() {
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const productCheckboxes = Array.from(document.querySelectorAll('input[name="selected_products[]"]'));
        const downloadSelectedBtn = document.getElementById('download-selected-btn');

        if (!selectAllCheckbox || productCheckboxes.length === 0 || !downloadSelectedBtn) {
            return;
        }

        const syncButtonState = () => {
            const anyChecked = productCheckboxes.some((checkbox) => checkbox.checked);
            downloadSelectedBtn.disabled = !anyChecked;
        };

        selectAllCheckbox.addEventListener('change', (e) => {
            productCheckboxes.forEach((checkbox) => {
                checkbox.checked = e.target.checked;
            });
            syncButtonState();
        });

        productCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', syncButtonState);
        });

        syncButtonState();
    }

    function bindClickHandler(elementId, handler) {
        const element = document.getElementById(elementId);

        if (!element || typeof handler !== 'function') {
            return;
        }

        element.addEventListener('click', handler);
    }

    async function zipQRCodes(items, options = {}) {
        await ensureZipSupport();

        const zip = new JSZip();
        const filePrefix = options.filePrefix || 'qrcode_produk_';

        for (const item of items) {
            const canvas = await options.renderCanvas(item);
            if (!canvas) {
                if (typeof options.onMissingCanvas === 'function') {
                    options.onMissingCanvas(item);
                }
                continue;
            }

            const imageData = canvas.toDataURL('image/png').split(',')[1];
            zip.file(`${filePrefix}${item.productCode}.png`, imageData, { base64: true });

            if (typeof options.onProgress === 'function') {
                options.onProgress(item);
            }
        }

        return zip.generateAsync({ type: 'blob' });
    }

    async function zipHighResQRCodes(items, options = {}) {
        const progress = options.progressId ? createProgressModal(options.progressId, items.length) : null;
        let completed = 0;

        try {
            const content = await zipQRCodes(items, {
                renderCanvas(item) {
                    return createHighResQRCode(
                        `${options.verifyBaseUrl}/${item.productCode}`,
                        options.size || 2000,
                        options.timeoutMs || 5000
                    );
                },
                onMissingCanvas(item) {
                    if (typeof options.onMissingCanvas === 'function') {
                        options.onMissingCanvas(item);
                    }
                },
                onProgress(item) {
                    completed += 1;
                    if (progress) {
                        progress.update(completed);
                    }
                    if (typeof options.onProgress === 'function') {
                        options.onProgress(item, completed);
                    }
                }
            });

            return { content, completed };
        } finally {
            if (progress) {
                progress.remove();
            }
        }
    }

    function selectedProductItems() {
        return Array.from(document.querySelectorAll('input[name="selected_products[]"]:checked')).map((checkbox) => ({
            productId: checkbox.value,
            productCode: getProductCode(checkbox.value)
        }));
    }

    function pageProductItems() {
        return getProductRows().map((row) => ({
            productId: row.dataset.id,
            productCode: row.dataset.code,
            productWeight: row.dataset.weight || ''
        }));
    }

    function createPreviewCanvasForProduct(productId, size = 1080) {
        return createCanvasFromPreviewImage(getPreviewImage(productId), size);
    }

    async function zipPreviewQRCodes(items, options = {}) {
        return zipQRCodes(items, {
            filePrefix: options.filePrefix,
            renderCanvas(item) {
                return Promise.resolve(createPreviewCanvasForProduct(item.productId, options.size || 1080));
            },
            onMissingCanvas: options.onMissingCanvas,
            onProgress: options.onProgress
        });
    }

    function initProductPage(options = {}) {
        if (options.verifyBaseUrl) {
            createPreviewQRCodes(options.verifyBaseUrl, options.previewSize || 80);
        }

        bindClickHandler('download-selected-btn', options.onDownloadSelected);
        bindClickHandler('download-all-btn', options.onDownloadAll);

        setupDropdowns();
        setupSelectAll();
    }

        return {
        ensureZipSupport,
        getProductCode,
        getPreviewImage,
        createCanvasFromPreviewImage,
        triggerCanvasDownload,
        createPreviewQRCodes,
        createHighResQRCode,
        createProgressModal,
        bindClickHandler,
        setupDropdowns,
        setupSelectAll,
        zipQRCodes,
        zipHighResQRCodes,
        selectedProductItems,
        pageProductItems,
        createPreviewCanvasForProduct,
        zipPreviewQRCodes,
        initProductPage
    };
})();

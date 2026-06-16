document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('product-code-input');
    const verifyButton = document.getElementById('verify-button');
    const root = document.querySelector('[data-verification-prefix]');

    if (!input || !verifyButton || !root) {
        return;
    }

    const verificationPrefix = root.dataset.verificationPrefix || '/cek';
    const redirectToVerification = () => {
        const code = input.value.trim();
        if (code) {
            window.location.href = `${verificationPrefix}/${encodeURIComponent(code)}`;
        }
    };

    verifyButton.addEventListener('click', redirectToVerification);
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            redirectToVerification();
        }
    });

    const openButton = document.querySelector('[data-scanner-open]');
    const modal = document.querySelector('[data-scanner-modal]');

    if (!openButton || !modal) {
        return;
    }

    const video = modal.querySelector('[data-scanner-video]');
    const status = modal.querySelector('[data-scanner-status]');
    const closeButtons = modal.querySelectorAll('[data-scanner-close]');
    const readyText = modal.dataset.scannerStatusReady || 'Siap memindai barcode.';
    const scanningText = modal.dataset.scannerStatusScanning || 'Memindai barcode...';
    const unsupportedText = modal.dataset.scannerStatusUnsupported || 'Scanner kamera tidak didukung di browser ini.';
    const deniedText = modal.dataset.scannerStatusDenied || 'Akses kamera ditolak.';
    const foundText = modal.dataset.scannerStatusFound || 'Kode ditemukan, membuka verifikasi.';

    let stream = null;
    let detector = null;
    let activeSession = 0;
    let animationFrameId = null;

    const setStatus = (message) => {
        if (status) {
            status.textContent = message;
        }
    };

    const stopScanner = () => {
        if (animationFrameId !== null) {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
        }

        if (video && video.srcObject) {
            const tracks = video.srcObject.getTracks ? video.srcObject.getTracks() : [];
            tracks.forEach((track) => track.stop());
            video.srcObject = null;
        }

        stream = null;
    };

    const hideModal = () => {
        activeSession += 1;
        stopScanner();
        modal.classList.add('ane-hidden');
        modal.setAttribute('aria-hidden', 'true');
    };

    const showModal = async () => {
        activeSession += 1;
        const sessionId = activeSession;

        modal.classList.remove('ane-hidden');
        modal.setAttribute('aria-hidden', 'false');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia || !('BarcodeDetector' in window)) {
            setStatus(unsupportedText);
            return;
        }

        try {
            if (!detector) {
                detector = new BarcodeDetector({
                    formats: ['qr_code', 'code_128', 'code_39', 'ean_13', 'ean_8', 'upc_a', 'upc_e']
                });
            }

            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'environment' }
                }
            });

            if (sessionId !== activeSession) {
                stopScanner();
                return;
            }

            video.srcObject = stream;
            await video.play();
            setStatus(scanningText);

            const scanFrame = async () => {
                if (sessionId !== activeSession) {
                    return;
                }

                try {
                    const codes = await detector.detect(video);
                    if (codes.length > 0) {
                        const value = (codes[0].rawValue || '').trim();
                        if (value) {
                            setStatus(foundText);
                            hideModal();
                            input.value = value;
                            redirectToVerification();
                            return;
                        }
                    }
                } catch (error) {
                    console.warn('Barcode scan failed', error);
                }

                animationFrameId = requestAnimationFrame(scanFrame);
            };

            scanFrame();
        } catch (error) {
            console.warn('Camera access failed', error);
            stopScanner();
            setStatus(error && error.name === 'NotAllowedError' ? deniedText : unsupportedText);
        }
    };

    openButton.addEventListener('click', showModal);

    closeButtons.forEach((button) => {
        button.addEventListener('click', hideModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('ane-hidden')) {
            hideModal();
        }
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            hideModal();
        }
    });

    setStatus(readyText);
});

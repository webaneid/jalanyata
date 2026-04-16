<main class="ane-hero">
    <div class="ane-hero__inner">
        <div class="ane-hero__grid">
            <section class="ane-hero__copy">
                <p class="ane-hero__eyebrow"><?= htmlspecialchars((string) $companyName, ENT_QUOTES, 'UTF-8') ?> Authenticity Gateway</p>
                <h1 class="ane-hero__title">Cek Keaslian Fine Silver dengan Nuansa Metalik</h1>
                <p class="ane-hero__lead">
                    Masukkan kode batang produk untuk memverifikasi keaslian silver Anda. Seluruh pengalaman dirancang dengan bahasa visual metalik yang tegas, elegan, dan konsisten dengan karakter premium produk silver.
                </p>
                <div class="ane-search-slab">
                    <div class="ane-search-slab__head">
                        <p class="ane-search-slab__eyebrow">Input Verification Code</p>
                        <p class="ane-search-slab__meta">Gunakan kode unik yang tertera pada produk silver Anda. Contoh format: `SS100-0001`.</p>
                    </div>
                    <div class="ane-searchbox">
                        <input
                            type="text"
                            id="product-code-input"
                            class="ane-input"
                            placeholder="Contoh: SS100-0001"
                        />
                        <svg class="ane-searchbox__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-2.414-2.414A1 1 0 0015.586 6H10a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15h2m-2-4h2m-4-8v4"></path>
                        </svg>
                    </div>
                    <button id="verify-button" class="ane-button btn-ane" style="width:100%;">
                        Cek Produk Silver
                    </button>
                </div>
            </section>

            <aside class="ane-silver-specimen" aria-hidden="true">
                <div class="ane-silver-specimen__frame">
                    <p class="ane-silver-specimen__brand"><?= htmlspecialchars((string) $companyName, ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="ane-silver-specimen__subtype">silver</p>
                    <p class="ane-silver-specimen__type">Authenticity Plate</p>
                    <div class="ane-silver-specimen__seal"></div>
                    <p class="ane-silver-specimen__grade">999,9 Fine Silver</p>
                    <p class="ane-silver-specimen__weight">10 Grams</p>
                    <p class="ane-silver-specimen__serial">Scan Your Code</p>
                </div>
            </aside>
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('product-code-input');
        const verifyButton = document.getElementById('verify-button');
        const BASE_URL = "<?php echo $baseUrl; ?>";

        // Fungsi untuk mengarahkan ke halaman verifikasi
        const redirectToVerification = () => {
            const code = input.value.trim();
            if (code) {
                window.location.href = `${BASE_URL}/cek/${code}`;
            }
        };

        // Event listener untuk klik tombol
        verifyButton.addEventListener('click', redirectToVerification);

        // Event listener untuk tombol Enter di input
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                redirectToVerification();
            }
        });
    });
</script>

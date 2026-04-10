<!-- File: views/datatidakasli.php -->
<!-- Fungsi: Tampilan untuk produk yang tidak terverifikasi -->
<main class="ane-verify">
    <div class="ane-verify__shell">
        <section class="ane-verify__card ane-verify__card--danger">
            <div class="ane-verify__header">
                <div class="ane-verify__status">
                    <div class="ane-verify__icon ane-verify__icon--danger">
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="ane-verify__eyebrow">Authenticity Failed</p>
                        <h1 class="ane-verify__title">Kode Tidak Valid</h1>
                    </div>
                </div>
                <div class="ane-verify__serial">Silver Check</div>
            </div>

            <div class="ane-verify__plate">
                <div class="ane-verify__plate-copy">
                    <p class="ane-verify__lead">
                        Kode produk tidak ditemukan pada database resmi. Pastikan Anda memasukkan kode dengan benar sebelum melanjutkan pengecekan ulang.
                    </p>
                    <div class="ane-verify__detail-grid">
                        <div class="ane-verify__detail-item">
                            <span>Status</span>
                            <strong>Tidak Ditemukan</strong>
                        </div>
                        <div class="ane-verify__detail-item">
                            <span>Produk</span>
                            <strong>Belum Terverifikasi</strong>
                        </div>
                        <div class="ane-verify__detail-item">
                            <span>Tindakan</span>
                            <strong>Periksa Kode Ulang</strong>
                        </div>
                    </div>
                </div>
            </div>

            <p class="ane-verify__meta">
                Silakan coba lagi atau hubungi layanan pelanggan untuk bantuan lebih lanjut.
            </p>
            <div class="ane-verify__actions">
                <a href="<?= app_path_url('/') ?>" class="ane-button">Ulangi atau cek kode baru</a>
            </div>
        </section>
    </div>
</main>

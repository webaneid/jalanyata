CREATE TABLE IF NOT EXISTS frontend_templates (
  id INT(11) NOT NULL AUTO_INCREMENT,
  template_key VARCHAR(50) NOT NULL,
  template_name VARCHAR(100) NOT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 0,
  template_config_json LONGTEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY template_key (template_key),
  KEY is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO frontend_templates (template_key, template_name, is_active, template_config_json) VALUES
(
  'silver-classic',
  'Silver Classic',
  1,
  '{"page_title":"Cek Keaslian Produk","page_description":"Cek keaslian produk dengan sistem verifikasi resmi.","home_eyebrow":"%company% Authenticity Gateway","home_title":"Cek Keaslian Produk dengan Nuansa Metalik","home_lead":"Masukkan kode batang produk untuk memverifikasi keaslian produk Anda. Seluruh pengalaman dirancang dengan bahasa visual metalik yang tegas, elegan, dan konsisten dengan identitas resmi %company%.","home_search_eyebrow":"Input Verification Code","home_search_meta":"Gunakan kode unik yang tertera pada produk Anda. Masukkan kode produk secara lengkap sesuai label resmi.","home_placeholder":"Masukkan kode produk","home_button_label":"Cek Produk","home_specimen_subtype":"authenticity","home_specimen_type":"Registered Product","home_specimen_grade":"Official Verification","home_specimen_weight":"Trusted Registry","home_specimen_serial":"Scan Your Code","verified_eyebrow":"Authenticity Confirmed","verified_title":"Produk Terverifikasi","verified_lead":"Selamat, kode %code% berhasil dicocokkan dengan data resmi %company%.","verified_meta":"Informasi ini menjamin bahwa produk Anda telah terdaftar secara resmi di %company%.","invalid_eyebrow":"Authenticity Failed","invalid_title":"Kode Tidak Valid","invalid_serial":"%company%","invalid_lead":"Kode produk tidak ditemukan pada database resmi. Pastikan Anda memasukkan kode dengan benar sebelum melanjutkan pengecekan ulang.","invalid_meta":"Silakan coba lagi atau hubungi layanan pelanggan untuk bantuan lebih lanjut.","footer_note":"Seluruh hak cipta dilindungi."}'
),
(
  'silver-plate',
  'Silver Plate',
  0,
  '{"page_title":"Panel Verifikasi Produk","page_description":"Panel verifikasi produk resmi dengan tampilan metalik.","home_eyebrow":"%company% Authenticity Gateway","home_title":"Masuk ke Panel Verifikasi Resmi","home_lead":"Gunakan kode unik produk untuk mengakses informasi resmi dan validasi keaslian.","home_search_eyebrow":"Input Verification Code","home_search_meta":"Gunakan kode unik yang tertera pada produk Anda. Masukkan kode produk secara lengkap sesuai label resmi.","home_placeholder":"Masukkan kode produk","home_button_label":"Verifikasi Sekarang","home_specimen_subtype":"authenticity","home_specimen_type":"Registered Product","home_specimen_grade":"Official Verification","home_specimen_weight":"Trusted Registry","home_specimen_serial":"Scan Your Code","verified_eyebrow":"Authenticity Confirmed","verified_title":"Produk Resmi Ditemukan","verified_lead":"Selamat, kode %code% berhasil dicocokkan dengan data resmi %company%.","verified_meta":"Informasi ini menjamin bahwa produk Anda telah terdaftar secara resmi di %company%.","invalid_eyebrow":"Authenticity Failed","invalid_title":"Kode Tidak Terdaftar","invalid_serial":"%company%","invalid_lead":"Kode produk tidak ditemukan pada database resmi. Pastikan Anda memasukkan kode dengan benar sebelum melanjutkan pengecekan ulang.","invalid_meta":"Silakan coba lagi atau hubungi layanan pelanggan untuk bantuan lebih lanjut.","footer_note":"Panel verifikasi resmi."}'
),
(
  'silver-minimal',
  'Silver Minimal',
  0,
  '{"page_title":"Cek Produk","page_description":"Verifikasi produk secara cepat dan ringkas.","home_eyebrow":"%company% Authenticity Gateway","home_title":"Cek Produk Secara Cepat","home_lead":"Masukkan kode produk untuk melihat status verifikasi resmi.","home_search_eyebrow":"Input Verification Code","home_search_meta":"Contoh format: SS100-0001.","home_placeholder":"Masukkan kode produk","home_button_label":"Cek Kode","home_specimen_subtype":"authenticity","home_specimen_type":"Registered Product","home_specimen_grade":"Official Verification","home_specimen_weight":"Trusted Registry","home_specimen_serial":"Scan Your Code","verified_eyebrow":"Authenticity Confirmed","verified_title":"Produk Valid","verified_lead":"Selamat, kode %code% berhasil dicocokkan dengan data resmi %company%.","verified_meta":"Informasi ini menjamin bahwa produk Anda telah terdaftar secara resmi di %company%.","invalid_eyebrow":"Authenticity Failed","invalid_title":"Kode Tidak Ditemukan","invalid_serial":"%company%","invalid_lead":"Kode produk tidak ditemukan pada database resmi. Pastikan Anda memasukkan kode dengan benar sebelum melanjutkan pengecekan ulang.","invalid_meta":"Silakan coba lagi atau hubungi layanan pelanggan untuk bantuan lebih lanjut.","footer_note":"Verifikasi ringkas dan aman."}'
);

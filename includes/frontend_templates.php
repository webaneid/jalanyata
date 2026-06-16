<?php

if (!function_exists('jalanyata_frontend_template_defaults')) {
    function jalanyata_frontend_template_defaults()
    {
        return [
            'page_title' => 'Cek Keaslian Produk',
            'page_description' => 'Cek keaslian produk dengan sistem verifikasi resmi.',
            'home_eyebrow' => '%company% Authenticity Gateway',
            'home_title' => 'Cek Keaslian Produk dengan Nuansa Metalik',
            'home_lead' => 'Masukkan kode batang produk untuk memverifikasi keaslian produk Anda. Seluruh pengalaman dirancang dengan bahasa visual metalik yang tegas, elegan, dan konsisten dengan identitas resmi %company%.',
            'home_search_eyebrow' => 'Input Verification Code',
            'home_search_meta' => 'Gunakan kode unik yang tertera pada produk Anda. Masukkan kode produk secara lengkap sesuai label resmi.',
            'home_placeholder' => 'Masukkan kode produk',
            'home_button_label' => 'Cek Produk',
            'home_specimen_subtype' => 'authenticity',
            'home_specimen_type' => 'Registered Product',
            'home_specimen_grade' => 'Official Verification',
            'home_specimen_weight' => 'Trusted Registry',
            'home_specimen_serial' => 'Scan Your Code',
            'verified_eyebrow' => 'Authenticity Confirmed',
            'verified_title' => 'Produk Terverifikasi',
            'verified_lead' => 'Selamat, kode %code% berhasil dicocokkan dengan data resmi %company%.',
            'verified_meta' => 'Informasi ini menjamin bahwa produk Anda telah terdaftar secara resmi di %company%.',
            'verified_label_code' => 'Kode Produk',
            'verified_label_category' => 'Kategori Produk',
            'verified_label_weight' => 'Berat',
            'verified_label_date' => 'Tanggal Produksi',
            'verified_back_button_label' => 'Cek Kode Lain',
            'invalid_eyebrow' => 'Authenticity Failed',
            'invalid_title' => 'Kode Tidak Valid',
            'invalid_serial' => '%company%',
            'invalid_lead' => 'Kode produk tidak ditemukan pada database resmi. Pastikan Anda memasukkan kode dengan benar sebelum melanjutkan pengecekan ulang.',
            'invalid_meta' => 'Silakan coba lagi atau hubungi layanan pelanggan untuk bantuan lebih lanjut.',
            'invalid_label_status' => 'Status',
            'invalid_label_product' => 'Produk',
            'invalid_label_action' => 'Tindakan',
            'invalid_detail_status_value' => 'Tidak Ditemukan',
            'invalid_detail_product_value' => 'Belum Terverifikasi',
            'invalid_detail_action_value' => 'Periksa Kode Ulang',
            'invalid_back_button_label' => 'Ulangi atau cek kode baru',
            'footer_note' => 'Seluruh hak cipta dilindungi.',
            'home_scanner_button_label' => 'Launch Scanner',
            'home_scanner_hint' => 'Klik ikon untuk membuka kamera dan scan barcode.',
            'home_scanner_modal_title' => 'QR Scanner',
            'home_scanner_modal_close_label' => 'Close Scanner',
            'home_scanner_status_ready' => 'Siap memindai barcode.',
            'home_scanner_status_scanning' => 'Memindai barcode...',
            'home_scanner_status_unsupported' => 'Scanner kamera tidak didukung di browser ini.',
            'home_scanner_status_denied' => 'Akses kamera ditolak.',
            'home_scanner_status_found' => 'Kode ditemukan, membuka verifikasi.',
        ];
    }
}

if (!function_exists('jalanyata_frontend_template_presets')) {
    function jalanyata_frontend_template_presets()
    {
        $defaults = jalanyata_frontend_template_defaults();

        return [
            [
                'template_key' => 'silver-classic',
                'template_name' => 'Silver Classic',
                'is_active' => 1,
                'template_config_json' => json_encode($defaults, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ],
            [
                'template_key' => 'silver-plate',
                'template_name' => 'Silver Plate',
                'is_active' => 0,
                'template_config_json' => json_encode(array_merge($defaults, [
                    'page_title' => 'Panel Verifikasi Produk',
                    'page_description' => 'Panel verifikasi produk resmi dengan tampilan metalik.',
                    'home_title' => 'Masuk ke Panel Verifikasi Resmi',
                    'home_lead' => 'Gunakan kode unik produk untuk mengakses informasi resmi dan validasi keaslian.',
                    'home_button_label' => 'Verifikasi Sekarang',
                    'verified_title' => 'Produk Resmi Ditemukan',
                    'invalid_title' => 'Kode Tidak Terdaftar',
                    'footer_note' => 'Panel verifikasi resmi.',
                    'verified_label_code' => 'Kode Produk',
                    'verified_label_category' => 'Kategori Produk',
                    'verified_label_weight' => 'Berat',
                    'verified_label_date' => 'Tanggal Produksi',
                    'verified_back_button_label' => 'Cek Kode Lain',
                    'invalid_label_status' => 'Status',
                    'invalid_label_product' => 'Produk',
                    'invalid_label_action' => 'Tindakan',
                    'invalid_detail_status_value' => 'Tidak Ditemukan',
                    'invalid_detail_product_value' => 'Belum Terverifikasi',
                    'invalid_detail_action_value' => 'Periksa Kode Ulang',
                    'invalid_back_button_label' => 'Coba Template Lain',
                ]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ],
            [
                'template_key' => 'silver-minimal',
                'template_name' => 'Silver Minimal',
                'is_active' => 0,
                'template_config_json' => json_encode(array_merge($defaults, [
                    'page_title' => 'Cek Produk',
                    'page_description' => 'Verifikasi produk secara cepat dan ringkas.',
                    'home_title' => 'Cek Produk Secara Cepat',
                    'home_lead' => 'Masukkan kode produk untuk melihat status verifikasi resmi.',
                    'home_search_meta' => 'Contoh format: SS100-0001.',
                    'home_button_label' => 'Cek Kode',
                    'verified_title' => 'Produk Valid',
                    'invalid_title' => 'Kode Tidak Ditemukan',
                    'footer_note' => 'Verifikasi ringkas dan aman.',
                    'verified_label_code' => 'Kode',
                    'verified_label_category' => 'Kategori',
                    'verified_label_weight' => 'Ukuran',
                    'verified_label_date' => 'Tanggal',
                    'verified_back_button_label' => 'Cek Kode Lain',
                    'invalid_label_status' => 'Status',
                    'invalid_label_product' => 'Produk',
                    'invalid_label_action' => 'Tindakan',
                    'invalid_detail_status_value' => 'Tidak Ditemukan',
                    'invalid_detail_product_value' => 'Belum Terverifikasi',
                    'invalid_detail_action_value' => 'Periksa Kode Ulang',
                    'invalid_back_button_label' => 'Ulangi atau cek kode baru',
                ]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ],
            [
                'template_key' => 'silver-scan-dark',
                'template_name' => 'Silver Scan Dark',
                'is_active' => 0,
                'template_config_json' => json_encode(array_merge($defaults, [
                    'page_title' => 'Cek Keaslian Produk',
                    'page_description' => 'Tampilan verifikasi dark mode dengan scanner kamera dua kolom.',
                    'home_eyebrow' => '%company% Scanner Gateway',
                    'home_title' => 'Scan Produk dengan Dark Mode',
                    'home_lead' => 'Klik panel scanner di kiri untuk membuka kamera, lalu arahkan ke barcode produk. Jika perlu, masukkan kode secara manual di sisi kanan.',
                    'home_search_eyebrow' => 'Manual Verification',
                    'home_search_meta' => 'Gunakan input di bawah jika ingin mengetik kode secara langsung tanpa kamera.',
                    'home_placeholder' => 'Masukkan kode produk',
                    'home_button_label' => 'Cek Produk',
                    'home_scanner_button_label' => 'Launch Scanner',
                    'home_scanner_hint' => 'Klik ikon scanner untuk membuka kamera.',
                    'home_scanner_modal_title' => 'QR Scanner',
                    'home_scanner_modal_close_label' => 'Close Scanner',
                    'home_scanner_status_ready' => 'Siap memindai barcode.',
                    'home_scanner_status_scanning' => 'Memindai barcode...',
                    'home_scanner_status_unsupported' => 'Scanner kamera tidak didukung di browser ini.',
                    'home_scanner_status_denied' => 'Akses kamera ditolak.',
                    'home_scanner_status_found' => 'Kode ditemukan, membuka verifikasi.',
                    'verified_eyebrow' => 'Authenticity Confirmed',
                    'verified_title' => 'Produk Terverifikasi',
                    'verified_lead' => 'Selamat, kode %code% berhasil dicocokkan dengan data resmi %company%.',
                    'verified_meta' => 'Informasi ini menjamin bahwa produk Anda telah terdaftar secara resmi di %company%.',
                    'verified_label_code' => 'Kode Produk',
                    'verified_label_category' => 'Kategori Produk',
                    'verified_label_weight' => 'Berat',
                    'verified_label_date' => 'Tanggal Produksi',
                    'verified_back_button_label' => 'Cek Kode Lain',
                    'invalid_eyebrow' => 'Authenticity Failed',
                    'invalid_title' => 'Kode Tidak Valid',
                    'invalid_serial' => '%company%',
                    'invalid_lead' => 'Kode produk tidak ditemukan pada database resmi. Pastikan Anda memasukkan kode dengan benar sebelum melanjutkan pengecekan ulang.',
                    'invalid_meta' => 'Silakan coba lagi atau hubungi layanan pelanggan untuk bantuan lebih lanjut.',
                    'invalid_label_status' => 'Status',
                    'invalid_label_product' => 'Produk',
                    'invalid_label_action' => 'Tindakan',
                    'invalid_detail_status_value' => 'Tidak Ditemukan',
                    'invalid_detail_product_value' => 'Belum Terverifikasi',
                    'invalid_detail_action_value' => 'Periksa Kode Ulang',
                    'invalid_back_button_label' => 'Ulangi atau cek kode baru',
                    'footer_note' => 'Tampilan dark mode dengan scanner kamera.',
                ]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ],
        ];
    }
}

if (!function_exists('jalanyata_frontend_template_decode_config')) {
    function jalanyata_frontend_template_decode_config($json)
    {
        $defaults = jalanyata_frontend_template_defaults();
        $decoded = json_decode((string) $json, true);

        if (!is_array($decoded)) {
            return $defaults;
        }

        return array_merge($defaults, $decoded);
    }
}

if (!function_exists('jalanyata_frontend_template_encode_config')) {
    function jalanyata_frontend_template_encode_config(array $config)
    {
        return json_encode(array_merge(jalanyata_frontend_template_defaults(), $config), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('jalanyata_frontend_template_config_from_input')) {
    function jalanyata_frontend_template_config_from_input(array $input)
    {
        $keys = [
            'page_title',
            'page_description',
            'home_eyebrow',
            'home_title',
            'home_lead',
            'home_search_eyebrow',
            'home_search_meta',
            'home_placeholder',
            'home_button_label',
            'home_specimen_subtype',
            'home_specimen_type',
            'home_specimen_grade',
            'home_specimen_weight',
            'home_specimen_serial',
            'verified_eyebrow',
            'verified_title',
            'verified_lead',
            'verified_meta',
            'verified_label_code',
            'verified_label_category',
            'verified_label_weight',
            'verified_label_date',
            'verified_back_button_label',
            'invalid_eyebrow',
            'invalid_title',
            'invalid_serial',
            'invalid_lead',
            'invalid_meta',
            'invalid_label_status',
            'invalid_label_product',
            'invalid_label_action',
            'invalid_detail_status_value',
            'invalid_detail_product_value',
            'invalid_detail_action_value',
            'invalid_back_button_label',
            'footer_note',
            'home_scanner_button_label',
            'home_scanner_hint',
            'home_scanner_modal_title',
            'home_scanner_modal_close_label',
            'home_scanner_status_ready',
            'home_scanner_status_scanning',
            'home_scanner_status_unsupported',
            'home_scanner_status_denied',
            'home_scanner_status_found',
        ];

        $defaults = jalanyata_frontend_template_defaults();
        $config = [];
        foreach ($keys as $key) {
            $config[$key] = trim((string) ($input[$key] ?? ($defaults[$key] ?? '')));
        }

        return $config;
    }
}

if (!function_exists('jalanyata_frontend_template_replace_vars')) {
    function jalanyata_frontend_template_replace_vars($text, array $vars = [])
    {
        return strtr((string) $text, $vars);
    }
}

if (!function_exists('jalanyata_fetch_frontend_templates')) {
    function jalanyata_fetch_frontend_templates(PDO $conn)
    {
        return $conn->query(
            'SELECT id, template_key, template_name, is_active, template_config_json, created_at, updated_at
             FROM frontend_templates
             ORDER BY is_active DESC, template_name ASC, id ASC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_fetch_frontend_template_by_id')) {
    function jalanyata_fetch_frontend_template_by_id(PDO $conn, $templateId)
    {
        $stmt = $conn->prepare(
            'SELECT id, template_key, template_name, is_active, template_config_json, created_at, updated_at
             FROM frontend_templates
             WHERE id = :id
             LIMIT 1'
        );
        $stmt->bindValue(':id', (int) $templateId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

if (!function_exists('jalanyata_fetch_active_frontend_template')) {
    function jalanyata_fetch_active_frontend_template(PDO $conn)
    {
        $stmt = $conn->query(
            'SELECT id, template_key, template_name, is_active, template_config_json, created_at, updated_at
             FROM frontend_templates
             WHERE is_active = 1
             ORDER BY id ASC
             LIMIT 1'
        );

        $template = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($template) {
            return $template;
        }

        $stmt = $conn->query(
            'SELECT id, template_key, template_name, is_active, template_config_json, created_at, updated_at
             FROM frontend_templates
             ORDER BY id ASC
             LIMIT 1'
        );

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

if (!function_exists('jalanyata_frontend_template_config_from_row')) {
    function jalanyata_frontend_template_config_from_row(?array $templateRow = null)
    {
        if ($templateRow === null) {
            return jalanyata_frontend_template_defaults();
        }

        return jalanyata_frontend_template_decode_config($templateRow['template_config_json'] ?? null);
    }
}

if (!function_exists('jalanyata_frontend_template_save')) {
    function jalanyata_frontend_template_save(PDO $conn, $templateId, $templateName, array $config)
    {
        $stmt = $conn->prepare(
            'UPDATE frontend_templates
             SET template_name = :name,
                 template_config_json = :config,
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = :id'
        );
        $stmt->bindValue(':id', (int) $templateId, PDO::PARAM_INT);
        $stmt->bindValue(':name', $templateName, PDO::PARAM_STR);
        $stmt->bindValue(':config', jalanyata_frontend_template_encode_config($config), PDO::PARAM_STR);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_frontend_template_set_active')) {
    function jalanyata_frontend_template_set_active(PDO $conn, $templateId)
    {
        try {
            if (!$conn->inTransaction()) {
                $conn->beginTransaction();
            }

            $conn->exec('UPDATE frontend_templates SET is_active = 0');

            $stmt = $conn->prepare('UPDATE frontend_templates SET is_active = 1 WHERE id = :id');
            $stmt->bindValue(':id', (int) $templateId, PDO::PARAM_INT);
            $stmt->execute();

            if ($conn->inTransaction()) {
                $conn->commit();
            }
        } catch (Throwable $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }

            throw $e;
        }
    }
}

if (!function_exists('jalanyata_handle_frontend_template_update_request')) {
    function jalanyata_handle_frontend_template_update_request(PDO $conn, $templateId, $templateName, array $config, $isActive)
    {
        try {
            $template = jalanyata_fetch_frontend_template_by_id($conn, $templateId);
            if ($template === null) {
                jalanyata_flash_set('frontend_error', 'Template front-end tidak ditemukan.');
                jalanyata_redirect('/admin/frontend.php');
            }

            $templateName = trim((string) $templateName);
            if ($templateName === '') {
                jalanyata_flash_set('frontend_error', 'Nama template wajib diisi.');
                jalanyata_redirect('/admin/frontend.php?template_id=' . (int) $templateId);
            }

            jalanyata_frontend_template_save($conn, $templateId, $templateName, $config);

            if ((int) $isActive === 1) {
                jalanyata_frontend_template_set_active($conn, $templateId);
            }

            jalanyata_flash_set('frontend_success', 'Template front-end berhasil disimpan.');
        } catch (Throwable $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }

            jalanyata_flash_set('frontend_error', 'Terjadi kesalahan database: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/frontend.php?template_id=' . (int) $templateId);
    }
}

<?php

if (!function_exists('jalanyata_fetch_company_record')) {
    function jalanyata_fetch_company_record(PDO $conn)
    {
        return $conn->query('SELECT * FROM company_info LIMIT 1')->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_fetch_company_brand')) {
    function jalanyata_fetch_company_brand(PDO $conn)
    {
        return $conn->query('SELECT company_name, company_logo_url FROM company_info LIMIT 1')
            ->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_save_company_record')) {
    function jalanyata_save_company_record(PDO $conn, $companyData)
    {
        $params = [
            ':name' => $companyData['company_name'],
            ':address' => $companyData['company_address'],
            ':phone' => $companyData['company_phone'],
            ':whatsapp' => $companyData['company_whatsapp'],
            ':logo' => $companyData['company_logo_url'],
        ];

        if (empty($companyData['id'])) {
            $stmt = $conn->prepare(
                'INSERT INTO company_info (company_name, company_address, company_phone, company_whatsapp, company_logo_url)
                 VALUES (:name, :address, :phone, :whatsapp, :logo)'
            );
        } else {
            $stmt = $conn->prepare(
                'UPDATE company_info
                 SET company_name = :name, company_address = :address, company_phone = :phone, company_whatsapp = :whatsapp, company_logo_url = :logo
                 WHERE id = :id'
            );
            $params[':id'] = $companyData['id'];
        }

        $stmt->execute($params);
    }
}

if (!function_exists('jalanyata_handle_company_update_request')) {
    function jalanyata_handle_company_update_request(PDO $conn, $companyData, $companyLogoFile = null)
    {
        $companyLogoUrl = $companyData['company_logo_url'] ?? null;

        try {
            if (is_array($companyLogoFile) && ($companyLogoFile['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $logoValidation = jalanyata_validate_image_upload($companyLogoFile);
                if (is_string($logoValidation)) {
                    jalanyata_flash_set('company_error', $logoValidation);
                    jalanyata_redirect('/admin/company.php');
                }

                $companyLogoUrl = jalanyata_store_uploaded_file($companyLogoFile, $logoValidation['extension']);
                if ($companyLogoUrl === null) {
                    jalanyata_flash_set('company_error', 'Gagal mengunggah file logo.');
                    jalanyata_redirect('/admin/company.php');
                }
            }

            $companyData['company_logo_url'] = $companyLogoUrl;
            jalanyata_save_company_record($conn, $companyData);

            jalanyata_flash_set('company_success', 'Data perusahaan berhasil disimpan.');
        } catch (PDOException $e) {
            jalanyata_flash_set('company_error', 'Terjadi kesalahan database: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/company.php');
    }
}

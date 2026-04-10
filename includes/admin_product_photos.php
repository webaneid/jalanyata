<?php

if (!function_exists('jalanyata_fetch_product_photos')) {
    function jalanyata_fetch_product_photos(PDO $conn)
    {
        return $conn->query(
            'SELECT id, kodeukuran, product_weight, photo_url FROM product_photos ORDER BY kodeukuran ASC, product_weight ASC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_product_photo_code_exists')) {
    function jalanyata_product_photo_code_exists(PDO $conn, $sizeCode)
    {
        $stmt = $conn->prepare('SELECT COUNT(*) FROM product_photos WHERE kodeukuran = :kodeukuran');
        $stmt->bindValue(':kodeukuran', $sizeCode, PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }
}

if (!function_exists('jalanyata_find_product_photo_url_by_id')) {
    function jalanyata_find_product_photo_url_by_id(PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT photo_url FROM product_photos WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}

if (!function_exists('jalanyata_create_product_photo')) {
    function jalanyata_create_product_photo(PDO $conn, $sizeCode, $productWeight, $photoUrl)
    {
        $stmt = $conn->prepare(
            'INSERT INTO product_photos (kodeukuran, product_weight, photo_url) VALUES (:kodeukuran, :weight, :url)'
        );
        $stmt->bindValue(':kodeukuran', $sizeCode, PDO::PARAM_STR);
        $stmt->bindValue(':weight', $productWeight, PDO::PARAM_STR);
        $stmt->bindValue(':url', $photoUrl, PDO::PARAM_STR);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_update_product_photo')) {
    function jalanyata_update_product_photo(PDO $conn, $id, $sizeCode, $productWeight, $photoUrl)
    {
        $stmt = $conn->prepare(
            'UPDATE product_photos SET kodeukuran = :kodeukuran, product_weight = :weight, photo_url = :url WHERE id = :id'
        );
        $stmt->bindValue(':kodeukuran', $sizeCode, PDO::PARAM_STR);
        $stmt->bindValue(':weight', $productWeight, PDO::PARAM_STR);
        $stmt->bindValue(':url', $photoUrl, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_delete_product_photo')) {
    function jalanyata_delete_product_photo(PDO $conn, $id)
    {
        $stmt = $conn->prepare('DELETE FROM product_photos WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_handle_product_photo_add_request')) {
    function jalanyata_handle_product_photo_add_request(PDO $conn, $sizeCode, $productWeight, $photoFile)
    {
        $sizeCode = strtoupper(trim((string) $sizeCode));
        $productWeight = trim((string) $productWeight);

        if ($sizeCode === '' || $productWeight === '') {
            jalanyata_flash_set('photo_error', 'Kode ukuran dan ukuran wajib diisi.');
            jalanyata_redirect('/admin/product_photos.php');
        }

        if (!is_array($photoFile) || ($photoFile['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            jalanyata_flash_set('photo_error', 'Gagal mengunggah file foto.');
            jalanyata_redirect('/admin/product_photos.php');
        }

        try {
            $photoValidation = jalanyata_validate_image_upload($photoFile);
            if (is_string($photoValidation)) {
                jalanyata_flash_set('photo_error', $photoValidation);
                jalanyata_redirect('/admin/product_photos.php');
            }

            if (jalanyata_product_photo_code_exists($conn, $sizeCode)) {
                jalanyata_flash_set('photo_error', "Kode ukuran {$sizeCode} sudah ada.");
                jalanyata_redirect('/admin/product_photos.php');
            }

            $photoUrl = jalanyata_store_uploaded_file($photoFile, $photoValidation['extension']);
            if ($photoUrl !== null) {
                jalanyata_create_product_photo($conn, $sizeCode, $productWeight, $photoUrl);
                jalanyata_flash_set('photo_success', 'Foto produk berhasil ditambahkan.');
            } else {
                jalanyata_flash_set('photo_error', 'Gagal memindahkan file yang diunggah.');
            }
        } catch (PDOException $e) {
            jalanyata_flash_set('photo_error', 'Terjadi kesalahan database: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/product_photos.php');
    }
}

if (!function_exists('jalanyata_handle_product_photo_edit_request')) {
    function jalanyata_handle_product_photo_edit_request(PDO $conn, $id, $sizeCode, $productWeight, $photoFile = null)
    {
        $sizeCode = strtoupper(trim((string) $sizeCode));
        $productWeight = trim((string) $productWeight);
        $photoUrl = null;

        if ($sizeCode === '' || $productWeight === '') {
            jalanyata_flash_set('photo_error', 'Kode ukuran dan ukuran wajib diisi.');
            jalanyata_redirect('/admin/product_photos.php');
        }

        try {
            if (is_array($photoFile) && ($photoFile['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $photoValidation = jalanyata_validate_image_upload($photoFile);
                if (is_string($photoValidation)) {
                    jalanyata_flash_set('photo_error', $photoValidation);
                    jalanyata_redirect('/admin/product_photos.php');
                }

                $oldPhoto = jalanyata_find_product_photo_url_by_id($conn, $id);
                $photoUrl = jalanyata_store_uploaded_file($photoFile, $photoValidation['extension']);

                if ($photoUrl !== null) {
                    jalanyata_delete_uploaded_file_by_url($oldPhoto);
                } else {
                    jalanyata_flash_set('photo_error', 'Gagal memindahkan file yang diunggah.');
                    jalanyata_redirect('/admin/product_photos.php');
                }
            } else {
                $photoUrl = jalanyata_find_product_photo_url_by_id($conn, $id);
            }

            jalanyata_update_product_photo($conn, $id, $sizeCode, $productWeight, $photoUrl);
            jalanyata_flash_set('photo_success', 'Foto produk berhasil diubah.');
        } catch (PDOException $e) {
            jalanyata_flash_set('photo_error', 'Terjadi kesalahan database: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/product_photos.php');
    }
}

if (!function_exists('jalanyata_handle_product_photo_delete_request')) {
    function jalanyata_handle_product_photo_delete_request(PDO $conn, $id)
    {
        try {
            $photoUrlToDelete = jalanyata_find_product_photo_url_by_id($conn, $id);
            jalanyata_delete_product_photo($conn, $id);
            jalanyata_delete_uploaded_file_by_url($photoUrlToDelete);

            jalanyata_flash_set('photo_success', 'Foto produk berhasil dihapus.');
        } catch (PDOException $e) {
            jalanyata_flash_set('photo_error', 'Gagal menghapus foto produk: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/product_photos.php');
    }
}

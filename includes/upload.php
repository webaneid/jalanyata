<?php

require_once __DIR__ . '/config.php';

if (!function_exists('jalanyata_upload_error_message')) {
    function jalanyata_upload_error_message($errorCode)
    {
        switch ((int) $errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'Ukuran file melebihi batas yang diizinkan.';
            case UPLOAD_ERR_PARTIAL:
                return 'File gagal terunggah secara lengkap.';
            case UPLOAD_ERR_NO_FILE:
                return 'File belum dipilih.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Folder temporary upload tidak tersedia.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'File gagal ditulis ke server.';
            case UPLOAD_ERR_EXTENSION:
                return 'Upload file dihentikan oleh ekstensi server.';
            default:
                return 'Terjadi kesalahan saat mengunggah file.';
        }
    }
}

if (!function_exists('jalanyata_random_upload_name')) {
    function jalanyata_random_upload_name($extension)
    {
        try {
            $random = bin2hex(random_bytes(16));
        } catch (Exception $e) {
            $random = uniqid('', true);
        }

        return $random . '.' . ltrim(strtolower((string) $extension), '.');
    }
}

if (!function_exists('jalanyata_upload_directory')) {
    function jalanyata_upload_directory()
    {
        return dirname(__DIR__) . '/uploads/';
    }
}

if (!function_exists('jalanyata_upload_public_url')) {
    function jalanyata_upload_public_url($fileName)
    {
        return app_url('/uploads/' . ltrim((string) $fileName, '/'));
    }
}

if (!function_exists('jalanyata_upload_file_path_from_url')) {
    function jalanyata_upload_file_path_from_url($url)
    {
        $path = parse_url((string) $url, PHP_URL_PATH);

        if (!$path) {
            return null;
        }

        $basePath = app_base_path();
        if ($basePath !== '' && strpos($path, $basePath . '/') === 0) {
            $path = substr($path, strlen($basePath) + 1);
        } else {
            $path = ltrim($path, '/');
        }

        return dirname(__DIR__) . '/' . $path;
    }
}

if (!function_exists('jalanyata_delete_uploaded_file_by_url')) {
    function jalanyata_delete_uploaded_file_by_url($url)
    {
        $filePath = jalanyata_upload_file_path_from_url($url);

        if (!$filePath || !file_exists($filePath)) {
            return false;
        }

        return unlink($filePath);
    }
}

if (!function_exists('jalanyata_store_uploaded_file')) {
    function jalanyata_store_uploaded_file($file, $extension)
    {
        $targetDir = jalanyata_upload_directory();

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = jalanyata_random_upload_name($extension);
        $targetFile = $targetDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            return null;
        }

        return jalanyata_upload_public_url($fileName);
    }
}

if (!function_exists('jalanyata_validate_image_upload')) {
    function jalanyata_validate_image_upload($file, $required = true)
    {
        if (!isset($file) || !is_array($file)) {
            return $required ? 'File gambar tidak ditemukan.' : null;
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return $required ? 'File gambar belum dipilih.' : null;
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return jalanyata_upload_error_message($file['error']);
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return 'Sumber file upload tidak valid.';
        }

        if (($file['size'] ?? 0) <= 0 || $file['size'] > 5 * 1024 * 1024) {
            return 'Ukuran file gambar maksimal 5MB.';
        }

        $extension = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extension, $allowedExtensions, true)) {
            return 'Format gambar harus JPG, JPEG, PNG, atau WEBP.';
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            return 'Tipe file gambar tidak valid.';
        }

        if (@getimagesize($file['tmp_name']) === false) {
            return 'File gambar tidak valid.';
        }

        return [
            'extension' => $extension === 'jpeg' ? 'jpg' : $extension,
            'mime_type' => $mimeType,
        ];
    }
}

if (!function_exists('jalanyata_validate_excel_upload')) {
    function jalanyata_validate_excel_upload($file)
    {
        if (!isset($file) || !is_array($file)) {
            return 'File Excel tidak ditemukan.';
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return jalanyata_upload_error_message($file['error'] ?? UPLOAD_ERR_NO_FILE);
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return 'Sumber file upload tidak valid.';
        }

        if (($file['size'] ?? 0) <= 0 || $file['size'] > 10 * 1024 * 1024) {
            return 'Ukuran file Excel maksimal 10MB.';
        }

        $extension = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        if ($extension !== 'xlsx') {
            return 'Format file harus .xlsx.';
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $allowedMimeTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/zip',
            'application/x-zip-compressed',
            'application/octet-stream',
        ];

        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            return 'Tipe file Excel tidak valid.';
        }

        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            $openResult = $zip->open($file['tmp_name']);

            if ($openResult !== true) {
                return 'Struktur file Excel tidak valid.';
            }

            $hasContentTypes = $zip->locateName('[Content_Types].xml') !== false;
            $hasWorkbook = $zip->locateName('xl/workbook.xml') !== false;
            $zip->close();

            if (!$hasContentTypes || !$hasWorkbook) {
                return 'Struktur file Excel tidak valid.';
            }
        }

        return null;
    }
}

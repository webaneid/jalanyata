<?php
// File: api/product_photos.php
// Fungsi: API untuk mengelola foto produk

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_product_photos.php';
require_once __DIR__ . '/../includes/upload.php';
require_once __DIR__ . '/../config/database.php';

jalanyata_require_role('admin');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($requestMethod === 'POST') {
    if ($action === 'add') {
        jalanyata_handle_product_photo_add_request(
            $conn,
            $_POST['kodeukuran'] ?? '',
            $_POST['product_weight'] ?? '',
            $_FILES['photo_file'] ?? null
        );
    } elseif ($action === 'edit') {
        jalanyata_handle_product_photo_edit_request(
            $conn,
            $_POST['id'] ?? '',
            $_POST['kodeukuran'] ?? '',
            $_POST['product_weight'] ?? '',
            $_FILES['photo_file'] ?? null
        );
    } elseif ($action === 'delete') {
        jalanyata_handle_product_photo_delete_request($conn, $_POST['id'] ?? '');
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
}

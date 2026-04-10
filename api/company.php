<?php
// File: api/company.php
// Fungsi: API untuk mengelola data perusahaan

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_company.php';
require_once __DIR__ . '/../includes/upload.php';
require_once __DIR__ . '/../config/database.php';
jalanyata_require_role('admin');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($requestMethod === 'POST' && $action === 'update') {
    jalanyata_handle_company_update_request($conn, [
        'id' => $_POST['id'] ?? '',
        'company_name' => $_POST['company_name'] ?? '',
        'company_address' => $_POST['company_address'] ?? '',
        'company_phone' => $_POST['company_phone'] ?? '',
        'company_whatsapp' => $_POST['company_whatsapp'] ?? '',
        'company_logo_url' => $_POST['company_logo_url'] ?? null,
    ], $_FILES['company_logo'] ?? null);
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
}

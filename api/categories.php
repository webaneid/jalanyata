<?php
// File: api/categories.php
// Fungsi: API untuk menambahkan kategori produk dari halaman foto produk

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/categories.php';
require_once __DIR__ . '/../config/database.php';

jalanyata_require_role('admin');

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_GET['action'] ?? '';
if ($action !== 'add') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Aksi tidak valid.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$categoryName = trim((string) ($_POST['name'] ?? ''));
if ($categoryName === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Nama kategori wajib diisi.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $category = jalanyata_create_category($conn, $categoryName);
    if ($category === null) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Nama kategori wajib diisi.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Kategori berhasil ditambahkan.',
        'category' => [
            'id' => (int) $category['id'],
            'name' => (string) $category['name'],
        ],
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan database: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}

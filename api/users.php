<?php
// File: api/users.php
// Fungsi: API untuk mengelola user (login dan CRUD user).

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_users.php';
require_once __DIR__ . '/../config/database.php';
jalanyata_session_start();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($requestMethod === 'POST') {
    if ($action === 'login') {
        jalanyata_handle_login_request($conn, $_POST['username'] ?? null, $_POST['password'] ?? null);
    } else {
        jalanyata_require_role('admin');

        if ($action === 'add') {
            jalanyata_handle_user_add_request(
                $conn,
                $_POST['username'] ?? '',
                $_POST['password'] ?? '',
                $_POST['role'] ?? 'admin'
            );
        } elseif ($action === 'edit') {
            jalanyata_handle_user_edit_request(
                $conn,
                $_POST['id'] ?? '',
                $_POST['username'] ?? '',
                $_POST['password'] ?? '',
                $_POST['role'] ?? 'admin'
            );
        } elseif ($action === 'delete') {
            jalanyata_handle_user_delete_request($conn, $_POST['id'] ?? '');
        }
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
}

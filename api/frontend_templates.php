<?php
require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');

require_once __DIR__ . '/../includes/frontend_templates.php';
require_once __DIR__ . '/../config/database.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($requestMethod === 'POST' && $action === 'update') {
    jalanyata_handle_frontend_template_update_request(
        $conn,
        $_POST['id'] ?? '',
        $_POST['template_name'] ?? '',
        jalanyata_frontend_template_config_from_input($_POST),
        isset($_POST['is_active']) ? 1 : 0
    );
}

http_response_code(405);
echo json_encode(['message' => 'Method tidak diizinkan.']);

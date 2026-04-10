<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/products.php';
require_once __DIR__ . '/../includes/upload.php';
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        $action = $_GET['action'] ?? '';

        if ($action === 'generated_excel') {
            jalanyata_require_role('developer');

            $batch = jalanyata_get_generated_products_batch();
            if ($batch === null || empty($batch['items'])) {
                http_response_code(404);
                echo 'Data hasil generate tidak ditemukan.';
                exit;
            }

            jalanyata_export_generated_products_excel($batch);
        }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        $productIdCode = $_GET['code'] ?? '';
        $response = [
            'success' => false,
            'message' => 'Kode produk tidak ditemukan.',
            'product' => null
        ];

        if (empty($productIdCode)) {
            $response['message'] = 'Harap masukkan kode produk.';
            echo json_encode($response);
            exit;
        }

        try {
            $product = jalanyata_find_product_by_code($conn, $productIdCode);

            if ($product) {
                $photoUrl = jalanyata_find_product_photo_url_by_weight($conn, $product['product_weight']);

                $response['success'] = true;
                $response['message'] = 'Verifikasi berhasil!';
                $response['product'] = [
                    'id' => $product['product_id_code'],
                    'weight' => $product['product_weight'],
                    'date' => $product['product_date'],
                    'photo_url' => $photoUrl
                ];
            }
        } catch(PDOException $e) {
            $response['message'] = 'Error koneksi database: ' . $e->getMessage();
        }

        echo json_encode($response);
        break;

    case 'POST':
        $action = $_GET['action'] ?? '';
        jalanyata_require_role('admin');

        if ($action == 'add') {
            jalanyata_handle_product_add_request(
                $conn,
                $_POST['product_id_code'] ?? '',
                $_POST['product_weight'] ?? '',
                $_POST['product_date'] ?? ''
            );
        } elseif ($action == 'edit') {
            jalanyata_handle_product_edit_request(
                $conn,
                $_POST['id'] ?? '',
                $_POST['product_id_code'] ?? '',
                $_POST['product_weight'] ?? '',
                $_POST['product_date'] ?? ''
            );
        } elseif ($action == 'delete') {
            jalanyata_handle_product_delete_request($conn, $_POST['id'] ?? '');
        } elseif ($action == 'upload') {
            jalanyata_handle_product_upload_request($conn, $_FILES['excel_file'] ?? null, function ($tmpFilePath) {
                if (!class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
                    throw new Exception('PhpSpreadsheet library not found. Please run `composer install`.');
                }

                $spreadsheet = IOFactory::load($tmpFilePath);
                return $spreadsheet->getActiveSheet()->toArray();
            });
        } elseif ($action == 'generate') {
            jalanyata_require_role('developer');
            jalanyata_handle_product_generate_request(
                $conn,
                $_POST['kodeukuran'] ?? '',
                $_POST['product_weight'] ?? '',
                $_POST['production_code'] ?? '',
                $_POST['start_sequence'] ?? '',
                $_POST['quantity'] ?? ''
            );
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method tidak diizinkan."]);
        break;
}
?>

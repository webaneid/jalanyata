<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/products.php';
session_start();

$request = $_SERVER['REQUEST_URI'];

// Strip path folder proyek dari awal URL
$request = str_replace($baseUrl, '', $request);
$request = trim($request, '/');

// Routing
switch ($request) {
    case '':
    case 'home':
        require __DIR__ . '/includes/header.php';
        require __DIR__ . '/views/home.php';
        require __DIR__ . '/includes/footer.php';
        break;

    case 'login':
        require __DIR__ . '/admin/login.php';
        break;

    case 'dashboard':
        if (isset($_SESSION['user_id'])) {
            require __DIR__ . '/admin/dashboard.php';
        } else {
            header("Location: {$baseUrl}/login");
            exit;
        }
        break;

    default:
        if (preg_match('/^cek\/(.+)$/', $request, $matches)) {
            $productCode = $matches[1];
            require __DIR__ . '/config/database.php';

            try {
                $product = jalanyata_find_verified_product_by_code($conn, $productCode);

                require __DIR__ . '/includes/header.php';
                if ($product && $product['product_id_code']) {
                    require __DIR__ . '/views/dataasli.php';
                } else {
                    require __DIR__ . '/views/datatidakasli.php';
                }
                require __DIR__ . '/includes/footer.php';

            } catch(PDOException $e) {
                http_response_code(500);
                echo "Error koneksi database: " . $e->getMessage();
            }
        } else {
            http_response_code(404);
            echo "404 - Halaman tidak ditemukan";
        }
        break;
}

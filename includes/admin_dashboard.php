<?php

if (!function_exists('jalanyata_fetch_dashboard_summary')) {
    function jalanyata_fetch_dashboard_summary(PDO $conn)
    {
        $totalProducts = (int) $conn->query('SELECT COUNT(*) FROM products')->fetchColumn();
        $totalUsers = (int) $conn->query("SELECT COUNT(*) FROM users WHERE role <> 'developer'")->fetchColumn();

        $productWeightResults = $conn->query(
            'SELECT product_weight, COUNT(*) AS count FROM products GROUP BY product_weight'
        )->fetchAll(PDO::FETCH_ASSOC);

        $productGrowthResults = $conn->query(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count FROM products GROUP BY month ORDER BY month ASC"
        )->fetchAll(PDO::FETCH_ASSOC);

        return [
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'productWeightData' => [
                'labels' => array_column($productWeightResults, 'product_weight'),
                'data' => array_column($productWeightResults, 'count'),
            ],
            'productGrowthData' => [
                'labels' => array_column($productGrowthResults, 'month'),
                'data' => array_column($productGrowthResults, 'count'),
            ],
        ];
    }
}

if (!function_exists('jalanyata_dashboard_shortcut_links')) {
    function jalanyata_dashboard_shortcut_links($currentRole = null)
    {
        $links = [
            ['/admin/products.php', 'Kelola Produk', 'Tambah, edit, atau hapus data produk.'],
            ['/admin/users.php', 'Kelola User', 'Tambah atau edit akun admin.'],
            ['/admin/upload_excel.php', 'Upload Data Produk', 'Import data produk dari file Excel.'],
            ['/admin/company.php', 'Kelola Perusahaan', 'Atur data dan logo perusahaan.'],
            ['/admin/product_photos.php', 'Kelola Foto Produk', 'Atur foto produk berdasarkan berat.'],
        ];

        if ($currentRole === 'developer') {
            array_splice($links, 3, 0, [['/admin/generate_products.php', 'Generate Produk', 'Buat produk massal berurutan khusus developer.']]);
        }

        return $links;
    }
}

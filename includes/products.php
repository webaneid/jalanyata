<?php

if (!function_exists('jalanyata_product_filter_state')) {
    function jalanyata_product_filter_state($defaultLimit)
    {
        $limit = max(1, (int) $defaultLimit);
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

        return [
            'searchQuery' => isset($_GET['search']) ? trim((string) $_GET['search']) : '',
            'weightFilter' => isset($_GET['weight']) ? trim((string) $_GET['weight']) : '',
            'sortOrder' => isset($_GET['sort']) ? trim((string) $_GET['sort']) : '',
            'page' => $page,
            'limit' => $limit,
            'offset' => ($page - 1) * $limit,
        ];
    }
}

if (!function_exists('jalanyata_fetch_product_size_options')) {
    function jalanyata_fetch_product_size_options(PDO $conn)
    {
        return $conn->query(
            'SELECT id, kodeukuran, product_weight, photo_url FROM product_photos ORDER BY id ASC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_generated_products_session_start')) {
    function jalanyata_generated_products_session_start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

if (!function_exists('jalanyata_store_generated_products_batch')) {
    function jalanyata_store_generated_products_batch(array $batch)
    {
        jalanyata_generated_products_session_start();
        $_SESSION['generated_products_batch'] = $batch;
    }
}

if (!function_exists('jalanyata_get_generated_products_batch')) {
    function jalanyata_get_generated_products_batch()
    {
        jalanyata_generated_products_session_start();
        $batch = $_SESSION['generated_products_batch'] ?? null;

        return is_array($batch) ? $batch : null;
    }
}

if (!function_exists('jalanyata_find_product_size_by_code')) {
    function jalanyata_find_product_size_by_code(PDO $conn, $sizeCode)
    {
        $stmt = $conn->prepare(
            'SELECT id, kodeukuran, product_weight, photo_url FROM product_photos WHERE kodeukuran = :kodeukuran LIMIT 1'
        );
        $stmt->bindValue(':kodeukuran', strtoupper(trim((string) $sizeCode)), PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

if (!function_exists('jalanyata_product_filter_clauses')) {
    function jalanyata_product_filter_clauses($filters)
    {
        $whereClauses = [];
        $params = [];

        if (($filters['searchQuery'] ?? '') !== '') {
            $whereClauses[] = 'product_id_code LIKE :searchQuery';
            $params[':searchQuery'] = '%' . $filters['searchQuery'] . '%';
        }

        if (($filters['weightFilter'] ?? '') !== '') {
            $whereClauses[] = 'product_weight = :weightFilter';
            $params[':weightFilter'] = $filters['weightFilter'];
        }

        return [
            'where' => $whereClauses,
            'params' => $params,
        ];
    }
}

if (!function_exists('jalanyata_product_order_by_clause')) {
    function jalanyata_product_order_by_clause($sortOrder)
    {
        if ($sortOrder === 'asc') {
            return ' ORDER BY product_id_code ASC';
        }

        if ($sortOrder === 'desc') {
            return ' ORDER BY product_id_code DESC';
        }

        return '';
    }
}

if (!function_exists('jalanyata_bind_product_filter_params')) {
    function jalanyata_bind_product_filter_params(PDOStatement $stmt, $params)
    {
        foreach ($params as $name => $value) {
            $stmt->bindValue($name, $value, PDO::PARAM_STR);
        }
    }
}

if (!function_exists('jalanyata_fetch_product_page')) {
    function jalanyata_fetch_product_page(PDO $conn, $filters, $columns = 'id, product_id_code, product_weight, product_date')
    {
        $clauses = jalanyata_product_filter_clauses($filters);
        $whereSql = $clauses['where'] ? ' WHERE ' . implode(' AND ', $clauses['where']) : '';
        $orderSql = jalanyata_product_order_by_clause($filters['sortOrder'] ?? '');

        $countStmt = $conn->prepare('SELECT COUNT(*) FROM products' . $whereSql);
        jalanyata_bind_product_filter_params($countStmt, $clauses['params']);
        $countStmt->execute();

        $totalProducts = (int) $countStmt->fetchColumn();
        $limit = (int) ($filters['limit'] ?? 20);
        $totalPages = (int) ceil($totalProducts / $limit);

        $stmt = $conn->prepare(
            'SELECT ' . $columns . ' FROM products' . $whereSql . $orderSql . ' LIMIT :limit OFFSET :offset'
        );
        jalanyata_bind_product_filter_params($stmt, $clauses['params']);
        $stmt->bindValue(':limit', (int) $filters['limit'], PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $filters['offset'], PDO::PARAM_INT);
        $stmt->execute();

        return [
            'products' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalProducts' => $totalProducts,
            'totalPages' => $totalPages,
        ];
    }
}

if (!function_exists('jalanyata_fetch_filtered_products')) {
    function jalanyata_fetch_filtered_products(PDO $conn, $filters, $columns = 'product_id_code')
    {
        $clauses = jalanyata_product_filter_clauses($filters);
        $whereSql = $clauses['where'] ? ' WHERE ' . implode(' AND ', $clauses['where']) : '';
        $orderSql = jalanyata_product_order_by_clause($filters['sortOrder'] ?? '');

        $stmt = $conn->prepare('SELECT ' . $columns . ' FROM products' . $whereSql . $orderSql);
        jalanyata_bind_product_filter_params($stmt, $clauses['params']);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_fetch_product_weights')) {
    function jalanyata_fetch_product_weights(PDO $conn)
    {
        return $conn->query('SELECT DISTINCT product_weight FROM products ORDER BY product_weight ASC')
            ->fetchAll(PDO::FETCH_COLUMN);
    }
}

if (!function_exists('jalanyata_find_product_by_code')) {
    function jalanyata_find_product_by_code(PDO $conn, $productIdCode)
    {
        $stmt = $conn->prepare(
            'SELECT id, product_id_code, product_weight, product_date FROM products WHERE product_id_code = :code'
        );
        $stmt->bindValue(':code', $productIdCode, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_find_verified_product_by_code')) {
    function jalanyata_find_verified_product_by_code(PDO $conn, $productIdCode)
    {
        $stmt = $conn->prepare(
            'SELECT p.id, p.product_id_code, p.product_weight, p.product_date, pp.photo_url
             FROM products p
             LEFT JOIN product_photos pp ON pp.product_weight = p.product_weight
             WHERE p.product_id_code = :code
             LIMIT 1'
        );
        $stmt->bindValue(':code', $productIdCode, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_find_product_photo_url_by_weight')) {
    function jalanyata_find_product_photo_url_by_weight(PDO $conn, $productWeight)
    {
        $stmt = $conn->prepare('SELECT photo_url FROM product_photos WHERE product_weight = :weight');
        $stmt->bindValue(':weight', $productWeight, PDO::PARAM_STR);
        $stmt->execute();

        $photoUrl = $stmt->fetchColumn();

        return $photoUrl === false ? null : $photoUrl;
    }
}

if (!function_exists('jalanyata_fetch_first_product_year')) {
    function jalanyata_fetch_first_product_year(PDO $conn)
    {
        $firstDate = $conn->query('SELECT MIN(product_date) AS first_date FROM products')->fetchColumn();

        if (is_string($firstDate) && preg_match('/\d{4}/', $firstDate, $matches) === 1) {
            return $matches[0];
        }

        return date('Y');
    }
}

if (!function_exists('jalanyata_count_products_by_code')) {
    function jalanyata_count_products_by_code(PDO $conn, $productIdCode)
    {
        $stmt = $conn->prepare('SELECT COUNT(*) FROM products WHERE product_id_code = :code');
        $stmt->bindValue(':code', $productIdCode, PDO::PARAM_STR);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}

if (!function_exists('jalanyata_create_product')) {
    function jalanyata_create_product(PDO $conn, $productIdCode, $productWeight, $productDate)
    {
        $stmt = $conn->prepare(
            'INSERT INTO products (product_id_code, product_weight, product_date) VALUES (:code, :weight, :date)'
        );
        $stmt->bindValue(':code', $productIdCode, PDO::PARAM_STR);
        $stmt->bindValue(':weight', $productWeight, PDO::PARAM_STR);
        $stmt->bindValue(':date', $productDate, PDO::PARAM_STR);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_build_product_date_from_code')) {
    function jalanyata_build_product_date_from_code($productionCode)
    {
        $productionCode = trim((string) $productionCode);

        if (preg_match('/^\d{4}$/', $productionCode) !== 1) {
            throw new InvalidArgumentException('Kode tanggal produksi harus berformat 4 digit MMYY.');
        }

        $monthNumber = (int) substr($productionCode, 0, 2);
        $yearNumber = (int) substr($productionCode, 2, 2);
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        if (!isset($monthNames[$monthNumber])) {
            throw new InvalidArgumentException('Bulan pada kode tanggal produksi tidak valid.');
        }

        return $monthNames[$monthNumber] . ' ' . (2000 + $yearNumber);
    }
}

if (!function_exists('jalanyata_generate_product_code_batch')) {
    function jalanyata_generate_product_code_batch($sizeCode, $productionCode, $startSequence, $quantity)
    {
        $sizeCode = strtoupper(trim((string) $sizeCode));
        $productionCode = trim((string) $productionCode);
        $startSequence = trim((string) $startSequence);
        $quantity = (int) $quantity;

        if ($sizeCode === '') {
            throw new InvalidArgumentException('Kode ukuran wajib dipilih.');
        }

        if (preg_match('/^\d{4}$/', $productionCode) !== 1) {
            throw new InvalidArgumentException('Kode tanggal produksi harus 4 digit MMYY.');
        }

        if (preg_match('/^\d+$/', $startSequence) !== 1) {
            throw new InvalidArgumentException('Urutan pertama harus berupa angka.');
        }

        if ($quantity < 1) {
            throw new InvalidArgumentException('Jumlah produk minimal 1.');
        }

        $sequenceLength = strlen($startSequence);
        $startNumber = (int) $startSequence;
        $endNumber = $startNumber + $quantity - 1;

        if (strlen((string) $endNumber) > $sequenceLength) {
            throw new InvalidArgumentException('Jumlah produk melebihi kapasitas digit urutan yang diberikan.');
        }

        $codes = [];
        for ($number = $startNumber; $number <= $endNumber; $number++) {
            $codes[] = $sizeCode . $productionCode . str_pad((string) $number, $sequenceLength, '0', STR_PAD_LEFT);
        }

        return $codes;
    }
}

if (!function_exists('jalanyata_count_existing_products_by_codes')) {
    function jalanyata_count_existing_products_by_codes(PDO $conn, array $productCodes)
    {
        if ($productCodes === []) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($productCodes), '?'));
        $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE product_id_code IN ($placeholders)");

        foreach (array_values($productCodes) as $index => $productCode) {
            $stmt->bindValue($index + 1, $productCode, PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}

if (!function_exists('jalanyata_create_products_batch')) {
    function jalanyata_create_products_batch(PDO $conn, array $productCodes, $productWeight, $productDate)
    {
        if ($productCodes === []) {
            return 0;
        }

        $stmt = $conn->prepare(
            'INSERT INTO products (product_id_code, product_weight, product_date) VALUES (:code, :weight, :date)'
        );

        foreach ($productCodes as $productCode) {
            $stmt->bindValue(':code', $productCode, PDO::PARAM_STR);
            $stmt->bindValue(':weight', $productWeight, PDO::PARAM_STR);
            $stmt->bindValue(':date', $productDate, PDO::PARAM_STR);
            $stmt->execute();
        }

        return count($productCodes);
    }
}

if (!function_exists('jalanyata_build_generated_products_batch')) {
    function jalanyata_build_generated_products_batch(array $productCodes, $productWeight, $productDate)
    {
        $items = [];

        foreach ($productCodes as $productCode) {
            $items[] = [
                'product_id_code' => $productCode,
                'product_weight' => $productWeight,
                'product_date' => $productDate,
                'verification_url' => app_url('/cek/' . rawurlencode($productCode)),
            ];
        }

        return [
            'created_at' => date('Y-m-d H:i:s'),
            'count' => count($items),
            'items' => $items,
        ];
    }
}

if (!function_exists('jalanyata_export_generated_products_excel')) {
    function jalanyata_export_generated_products_excel(array $batch)
    {
        if (!class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            throw new RuntimeException('PhpSpreadsheet library not found. Please run `composer install`.');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Generated Products');
        $sheet->fromArray(
            ['Kode Produk', 'Ukuran', 'Tanggal Produksi', 'URL Verifikasi'],
            null,
            'A1'
        );

        $rowIndex = 2;
        foreach (($batch['items'] ?? []) as $item) {
            $sheet->fromArray(
                [
                    $item['product_id_code'] ?? '',
                    $item['product_weight'] ?? '',
                    $item['product_date'] ?? '',
                    $item['verification_url'] ?? '',
                ],
                null,
                'A' . $rowIndex
            );
            $rowIndex++;
        }

        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="generated-products.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

if (!function_exists('jalanyata_update_product')) {
    function jalanyata_update_product(PDO $conn, $id, $productIdCode, $productWeight, $productDate)
    {
        $stmt = $conn->prepare(
            'UPDATE products SET product_id_code = :code, product_weight = :weight, product_date = :date WHERE id = :id'
        );
        $stmt->bindValue(':code', $productIdCode, PDO::PARAM_STR);
        $stmt->bindValue(':weight', $productWeight, PDO::PARAM_STR);
        $stmt->bindValue(':date', $productDate, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_delete_product')) {
    function jalanyata_delete_product(PDO $conn, $id)
    {
        $stmt = $conn->prepare('DELETE FROM products WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_import_products_rows')) {
    function jalanyata_import_products_rows(PDO $conn, $rows)
    {
        $totalRows = 0;
        $successCount = 0;
        $failedCount = 0;
        $failedDetails = [];

        foreach ($rows as $row) {
            if (empty(array_filter($row))) {
                continue;
            }

            $totalRows++;

            $productIdCode = $row[0] ?? null;
            $productWeight = $row[1] ?? null;
            $productDate = $row[2] ?? null;

            if (empty($productIdCode) || empty($productWeight) || empty($productDate)) {
                $failedCount++;
                $failedDetails[] = "Baris dengan kode ID '{$productIdCode}' gagal: data tidak lengkap.";
                continue;
            }

            if (jalanyata_count_products_by_code($conn, $productIdCode) > 0) {
                $failedCount++;
                $failedDetails[] = "Baris dengan kode ID '{$productIdCode}' gagal: kode sudah ada.";
                continue;
            }

            jalanyata_create_product($conn, $productIdCode, $productWeight, $productDate);
            $successCount++;
        }

        return [
            'totalRows' => $totalRows,
            'successCount' => $successCount,
            'failedCount' => $failedCount,
            'failedDetails' => $failedDetails,
        ];
    }
}

if (!function_exists('jalanyata_handle_product_add_request')) {
    function jalanyata_handle_product_add_request(PDO $conn, $productIdCode, $productWeight, $productDate)
    {
        try {
            if (jalanyata_count_products_by_code($conn, $productIdCode) > 0) {
                jalanyata_flash_set('product_error', 'Gagal menambahkan produk: Kode produk sudah ada. Mohon gunakan kode lain.');
                jalanyata_redirect('/admin/products.php');
            }

            jalanyata_create_product($conn, $productIdCode, $productWeight, $productDate);
            jalanyata_flash_set('product_success', 'Produk berhasil ditambahkan.');
        } catch (PDOException $e) {
            jalanyata_flash_set('product_error', 'Terjadi kesalahan saat menambah produk: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/products.php');
    }
}

if (!function_exists('jalanyata_handle_product_edit_request')) {
    function jalanyata_handle_product_edit_request(PDO $conn, $id, $productIdCode, $productWeight, $productDate)
    {
        try {
            jalanyata_update_product($conn, $id, $productIdCode, $productWeight, $productDate);
            jalanyata_flash_set('product_success', 'Produk berhasil diubah.');
        } catch (PDOException $e) {
            jalanyata_flash_set('product_error', 'Terjadi kesalahan saat mengedit produk: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/products.php');
    }
}

if (!function_exists('jalanyata_handle_product_delete_request')) {
    function jalanyata_handle_product_delete_request(PDO $conn, $id)
    {
        try {
            jalanyata_delete_product($conn, $id);
            jalanyata_flash_set('product_success', 'Produk berhasil dihapus.');
        } catch (PDOException $e) {
            jalanyata_flash_set('product_error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/products.php');
    }
}

if (!function_exists('jalanyata_handle_product_upload_request')) {
    function jalanyata_handle_product_upload_request(PDO $conn, $file, $spreadsheetLoader)
    {
        if (!isset($file) || !is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            jalanyata_flash_set('product_error', 'Gagal mengunggah file. Mohon coba lagi.');
            jalanyata_redirect('/admin/upload_excel.php');
        }

        $excelValidation = jalanyata_validate_excel_upload($file);
        if (is_string($excelValidation)) {
            jalanyata_flash_set('product_error', $excelValidation);
            jalanyata_redirect('/admin/upload_excel.php');
        }

        try {
            $rows = $spreadsheetLoader($file['tmp_name']);
            $importSummary = jalanyata_import_products_rows($conn, $rows);
            $totalRows = $importSummary['totalRows'];
            $successCount = $importSummary['successCount'];
            $failedCount = $importSummary['failedCount'];
            $failedDetails = $importSummary['failedDetails'];

            if ($failedCount > 0) {
                jalanyata_flash_set('product_error', "Ada {$failedCount} dari {$totalRows} baris yang gagal diunggah. Detail: " . implode(' ', $failedDetails));
            }

            jalanyata_flash_set('product_success', "Berhasil mengunggah {$successCount} produk.");
        } catch (Exception $e) {
            jalanyata_flash_set('product_error', 'Terjadi kesalahan saat memproses file Excel: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/products.php');
    }
}

if (!function_exists('jalanyata_handle_product_generate_request')) {
    function jalanyata_handle_product_generate_request(PDO $conn, $sizeCode, $productWeight, $productionCode, $startSequence, $quantity)
    {
        try {
            $size = jalanyata_find_product_size_by_code($conn, $sizeCode);
            if ($size === null) {
                jalanyata_flash_set('generator_error', 'Kode ukuran tidak ditemukan.');
                jalanyata_redirect('/admin/generate_products.php');
            }

            $selectedWeight = trim((string) $productWeight);
            if ($selectedWeight === '' || $selectedWeight !== (string) $size['product_weight']) {
                jalanyata_flash_set('generator_error', 'Ukuran tidak cocok dengan kode ukuran yang dipilih.');
                jalanyata_redirect('/admin/generate_products.php');
            }

            $productDate = jalanyata_build_product_date_from_code($productionCode);
            $productCodes = jalanyata_generate_product_code_batch(
                $size['kodeukuran'],
                $productionCode,
                $startSequence,
                $quantity
            );

            if (jalanyata_count_existing_products_by_codes($conn, $productCodes) > 0) {
                jalanyata_flash_set('generator_error', 'Sebagian kode produk hasil generate sudah ada di database.');
                jalanyata_redirect('/admin/generate_products.php');
            }

            $conn->beginTransaction();
            $createdCount = jalanyata_create_products_batch($conn, $productCodes, $size['product_weight'], $productDate);
            $conn->commit();

            jalanyata_store_generated_products_batch(
                jalanyata_build_generated_products_batch($productCodes, $size['product_weight'], $productDate)
            );
            jalanyata_flash_set('generator_success', "Berhasil membuat {$createdCount} produk.");
            jalanyata_redirect('/admin/generated_products_result.php');
        } catch (InvalidArgumentException $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }

            jalanyata_flash_set('generator_error', $e->getMessage());
        } catch (PDOException $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }

            jalanyata_flash_set('generator_error', 'Gagal membuat produk massal: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/generate_products.php');
    }
}

if (!function_exists('jalanyata_product_pagination_base_url')) {
    function jalanyata_product_pagination_base_url($path, $filters)
    {
        return jalanyata_product_filter_url($path, $filters);
    }
}

if (!function_exists('jalanyata_product_filter_url')) {
    function jalanyata_product_filter_url($path, $filters, $overrides = [])
    {
        $query = [];

        if (($filters['searchQuery'] ?? '') !== '') {
            $query['search'] = $filters['searchQuery'];
        }

        if (($filters['weightFilter'] ?? '') !== '') {
            $query['weight'] = $filters['weightFilter'];
        }

        if (($filters['sortOrder'] ?? '') !== '') {
            $query['sort'] = $filters['sortOrder'];
        }

        foreach ($overrides as $key => $value) {
            if ($value === null || $value === '') {
                unset($query[$key]);
                continue;
            }

            $query[$key] = $value;
        }

        $queryString = http_build_query($query);
        $separator = $queryString === '' ? '?' : '?' . $queryString;

        return app_path_url($path) . $separator;
    }
}

if (!function_exists('jalanyata_product_page_url')) {
    function jalanyata_product_page_url($path, $filters, $page)
    {
        return jalanyata_product_filter_url($path, $filters, ['page' => max(1, (int) $page)]);
    }
}

if (!function_exists('jalanyata_render_product_filter_controls')) {
    function jalanyata_render_product_filter_controls($path, $filters, $weights)
    {
        $weightLabel = ($filters['weightFilter'] ?? '') !== '' ? $filters['weightFilter'] : 'Semua';

        echo '<div class="ane-dropdown">';
        echo '<button id="sort-btn" class="ane-button ane-button--secondary ane-dropdown__toggle">';
        echo 'Urutkan';
        echo '<svg class="ane-dropdown__icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
        echo '</button>';
        echo '<div id="sort-dropdown" class="ane-dropdown__menu ane-hidden">';
        echo '<a href="' . htmlspecialchars(jalanyata_product_filter_url($path, $filters, ['sort' => 'asc']), ENT_QUOTES, 'UTF-8') . '" class="ane-dropdown__item" role="menuitem">Kode ID (A-Z)</a>';
        echo '<a href="' . htmlspecialchars(jalanyata_product_filter_url($path, $filters, ['sort' => 'desc']), ENT_QUOTES, 'UTF-8') . '" class="ane-dropdown__item" role="menuitem">Kode ID (Z-A)</a>';
        echo '</div>';
        echo '</div>';
        echo '<div class="ane-dropdown">';
        echo '<button id="weight-filter-btn" class="ane-button ane-button--secondary ane-dropdown__toggle">';
        echo 'Berat: ' . htmlspecialchars($weightLabel, ENT_QUOTES, 'UTF-8');
        echo '<svg class="ane-dropdown__icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
        echo '</button>';
        echo '<div id="weight-dropdown" class="ane-dropdown__menu ane-hidden">';
        echo '<a href="' . htmlspecialchars(jalanyata_product_filter_url($path, $filters, ['weight' => '']), ENT_QUOTES, 'UTF-8') . '" class="ane-dropdown__item" role="menuitem">Semua Berat</a>';

        foreach ($weights as $weight) {
            echo '<a href="' . htmlspecialchars(jalanyata_product_filter_url($path, $filters, ['weight' => $weight]), ENT_QUOTES, 'UTF-8') . '" class="ane-dropdown__item" role="menuitem">' . htmlspecialchars($weight, ENT_QUOTES, 'UTF-8') . '</a>';
        }

        echo '</div>';
        echo '</div>';
    }
}

if (!function_exists('jalanyata_render_product_pagination')) {
    function jalanyata_render_product_pagination($path, $filters, $page, $totalPages)
    {
        echo '<div class="ane-pagination">';

        if ($page > 1) {
            echo '<a href="' . htmlspecialchars(jalanyata_product_page_url($path, $filters, 1), ENT_QUOTES, 'UTF-8') . '" class="ane-pagination__item">First Page</a>';
            echo '<a href="' . htmlspecialchars(jalanyata_product_page_url($path, $filters, $page - 1), ENT_QUOTES, 'UTF-8') . '" class="ane-pagination__item">Sebelumnya</a>';
        }

        $startPage = max(1, $page - 2);
        $endPage = min($totalPages, $page + 2);

        for ($i = $startPage; $i <= $endPage; $i++) {
            $activeClass = $i === (int) $page ? ' is-active' : '';
            echo '<a href="' . htmlspecialchars(jalanyata_product_page_url($path, $filters, $i), ENT_QUOTES, 'UTF-8') . '" class="ane-pagination__item' . $activeClass . '">' . $i . '</a>';
        }

        if ($page < $totalPages) {
            echo '<a href="' . htmlspecialchars(jalanyata_product_page_url($path, $filters, $page + 1), ENT_QUOTES, 'UTF-8') . '" class="ane-pagination__item">Berikutnya</a>';
            echo '<a href="' . htmlspecialchars(jalanyata_product_page_url($path, $filters, $totalPages), ENT_QUOTES, 'UTF-8') . '" class="ane-pagination__item">Last Page</a>';
        }

        echo '</div>';
    }
}

if (!function_exists('jalanyata_render_admin_product_row_actions')) {
    function jalanyata_render_admin_product_row_actions($product)
    {
        echo '<div class="ane-table-actions">';
        echo '<button onclick="editProduct(this)" class="ane-link ane-link-button">Edit</button>';
        echo '<form action="' . htmlspecialchars(app_path_url('/api/products.php?action=delete'), ENT_QUOTES, 'UTF-8') . '" method="POST" class="ane-inline-form" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\');">';
        echo '<input type="hidden" name="id" value="' . (int) $product['id'] . '">';
        echo '<button type="submit" class="ane-link ane-link-button ane-link-button--danger">Hapus</button>';
        echo '</form>';
        echo '</div>';
    }
}

if (!function_exists('jalanyata_render_reader_product_row_actions')) {
    function jalanyata_render_reader_product_row_actions($product)
    {
        echo '<div class="ane-table-actions">';
        echo '<button onclick="window.print()" class="ane-link ane-link-button">Cetak Halaman</button>';
        echo '</div>';
    }
}

<?php

if (!function_exists('jalanyata_fetch_categories')) {
    function jalanyata_fetch_categories(PDO $conn)
    {
        return $conn->query(
            'SELECT c.id, c.name, COUNT(pp.id) AS product_photo_count
             FROM categories c
             LEFT JOIN product_photos pp ON pp.category_id = c.id
             GROUP BY c.id, c.name
             ORDER BY c.name ASC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_category_exists')) {
    function jalanyata_category_exists(PDO $conn, $categoryId)
    {
        $stmt = $conn->prepare('SELECT COUNT(*) FROM categories WHERE id = :id');
        $stmt->bindValue(':id', (int) $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }
}

if (!function_exists('jalanyata_find_category_by_id')) {
    function jalanyata_find_category_by_id(PDO $conn, $categoryId)
    {
        $stmt = $conn->prepare('SELECT id, name FROM categories WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', (int) $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

if (!function_exists('jalanyata_find_category_by_name')) {
    function jalanyata_find_category_by_name(PDO $conn, $categoryName)
    {
        $stmt = $conn->prepare('SELECT id, name FROM categories WHERE name = :name LIMIT 1');
        $stmt->bindValue(':name', trim((string) $categoryName), PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

if (!function_exists('jalanyata_category_name_exists')) {
    function jalanyata_category_name_exists(PDO $conn, $categoryName, $excludeId = null)
    {
        $sql = 'SELECT COUNT(*) FROM categories WHERE name = :name';
        if ($excludeId !== null && (int) $excludeId > 0) {
            $sql .= ' AND id <> :excludeId';
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', trim((string) $categoryName), PDO::PARAM_STR);

        if ($excludeId !== null && (int) $excludeId > 0) {
            $stmt->bindValue(':excludeId', (int) $excludeId, PDO::PARAM_INT);
        }

        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }
}

if (!function_exists('jalanyata_create_category')) {
    function jalanyata_create_category(PDO $conn, $categoryName)
    {
        $categoryName = trim((string) $categoryName);
        if ($categoryName === '') {
            return null;
        }

        $existingCategory = jalanyata_find_category_by_name($conn, $categoryName);
        if ($existingCategory !== null) {
            return $existingCategory;
        }

        $stmt = $conn->prepare('INSERT INTO categories (name) VALUES (:name)');
        $stmt->bindValue(':name', $categoryName, PDO::PARAM_STR);
        $stmt->execute();

        return [
            'id' => (int) $conn->lastInsertId(),
            'name' => $categoryName,
        ];
    }
}

if (!function_exists('jalanyata_update_category')) {
    function jalanyata_update_category(PDO $conn, $categoryId, $categoryName)
    {
        $categoryId = (int) $categoryId;
        $categoryName = trim((string) $categoryName);

        if ($categoryId <= 0 || $categoryName === '') {
            return null;
        }

        $existingCategory = jalanyata_find_category_by_id($conn, $categoryId);
        if ($existingCategory === null) {
            return null;
        }

        if (jalanyata_category_name_exists($conn, $categoryName, $categoryId)) {
            return false;
        }

        $stmt = $conn->prepare('UPDATE categories SET name = :name WHERE id = :id');
        $stmt->bindValue(':name', $categoryName, PDO::PARAM_STR);
        $stmt->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'id' => $categoryId,
            'name' => $categoryName,
        ];
    }
}

if (!function_exists('jalanyata_category_usage_count')) {
    function jalanyata_category_usage_count(PDO $conn, $categoryId)
    {
        $stmt = $conn->prepare('SELECT COUNT(*) FROM product_photos WHERE category_id = :id');
        $stmt->bindValue(':id', (int) $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}

if (!function_exists('jalanyata_category_has_children')) {
    function jalanyata_category_has_children(PDO $conn, $categoryId)
    {
        return jalanyata_category_usage_count($conn, $categoryId) > 0;
    }
}

if (!function_exists('jalanyata_delete_category')) {
    function jalanyata_delete_category(PDO $conn, $categoryId)
    {
        $categoryId = (int) $categoryId;

        if ($categoryId <= 0) {
            return false;
        }

        if (jalanyata_category_has_children($conn, $categoryId)) {
            return false;
        }

        $stmt = $conn->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}

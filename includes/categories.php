<?php

if (!function_exists('jalanyata_fetch_categories')) {
    function jalanyata_fetch_categories(PDO $conn)
    {
        return $conn->query('SELECT id, name FROM categories ORDER BY name ASC')->fetchAll(PDO::FETCH_ASSOC);
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

if (!function_exists('jalanyata_find_category_by_name')) {
    function jalanyata_find_category_by_name(PDO $conn, $categoryName)
    {
        $stmt = $conn->prepare('SELECT id, name FROM categories WHERE name = :name LIMIT 1');
        $stmt->bindValue(':name', trim((string) $categoryName), PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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

<?php

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$adminLinks = [
    [
        'label' => 'Dashboard',
        'href' => app_path_url('/dashboard'),
        'match' => ['/dashboard'],
    ],
    [
        'label' => 'Produk',
        'href' => app_path_url('/admin/products.php'),
        'match' => ['/admin/products.php'],
    ],
    [
        'label' => 'Upload Excel',
        'href' => app_path_url('/admin/upload_excel.php'),
        'match' => ['/admin/upload_excel.php'],
    ],
    [
        'label' => 'Foto Produk',
        'href' => app_path_url('/admin/product_photos.php'),
        'match' => ['/admin/product_photos.php'],
    ],
    [
        'label' => 'Perusahaan',
        'href' => app_path_url('/admin/company.php'),
        'match' => ['/admin/company.php'],
    ],
    [
        'label' => 'Users',
        'href' => app_path_url('/admin/users.php'),
        'match' => ['/admin/users.php'],
    ],
];

if (($_SESSION['user_role'] ?? null) === 'developer') {
    array_splice($adminLinks, 3, 0, [[
        'label' => 'Generate Produk',
        'href' => app_path_url('/admin/generate_products.php'),
        'match' => ['/admin/generate_products.php'],
    ]]);
}
?>
<nav class="ane-admin-nav" aria-label="Admin navigation">
    <?php foreach ($adminLinks as $link): ?>
        <?php $isActive = in_array($currentPath, $link['match'], true); ?>
        <a href="<?= htmlspecialchars($link['href']) ?>" class="ane-admin-nav__link<?= $isActive ? ' is-active' : '' ?>">
            <?= htmlspecialchars($link['label']) ?>
        </a>
    <?php endforeach; ?>
</nav>

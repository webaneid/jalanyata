<?php
require_once __DIR__ . '/layout_context.php';
require_once __DIR__ . '/../config/database.php';

jalanyata_bootstrap_layout_session_context($conn);

$layoutContext = jalanyata_build_layout_context([
    'layoutMode' => $layoutMode ?? null,
    'pageTitle' => $pageTitle ?? null,
    'pageDescription' => $pageDescription ?? null,
    'ogImage' => $ogImage ?? null,
    'bodyClass' => $bodyClass ?? null,
]);

$layoutMode = $layoutContext['layoutMode'];
$pageTitle = $layoutContext['pageTitle'];
$pageDescription = $layoutContext['pageDescription'];
$ogImage = $layoutContext['ogImage'];
$bodyClass = $layoutContext['bodyClass'];
$isAdminLayout = $layoutContext['isAdminLayout'];
$layoutStylesheet = $layoutContext['layoutStylesheet'];
$dashboardUrl = $layoutContext['dashboardUrl'];
$companyName = $layoutContext['companyName'];
$companyLogoUrl = $layoutContext['companyLogoUrl'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
    <meta property="og:url" content="<?= htmlspecialchars(app_url()) ?>">
    <meta property="og:type" content="website">

    <link rel="icon" type="image/png" href="<?= htmlspecialchars(app_path_url('/assets/images/favicon.png')) ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_path_url($layoutStylesheet)) ?>">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap');
    </style>
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
    <header class="ane-topbar">
        <div class="ane-topbar__inner">
            <a href="<?= htmlspecialchars(app_url()) ?>" class="ane-logo">
                <?php if (!empty($companyLogoUrl)): ?>
                    <img src="<?= htmlspecialchars($companyLogoUrl) ?>" alt="Logo Perusahaan" class="ane-logo__image">
                <?php else: ?>
                    <span><?= htmlspecialchars($companyName) ?></span>
                <?php endif; ?>
            </a>

            <nav class="ane-topbar__nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?= htmlspecialchars($dashboardUrl) ?>" class="ane-topbar__link">Dashboard</a>
                    <a href="<?= htmlspecialchars(app_path_url('/logout.php')) ?>" class="ane-topbar__link">Logout</a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars(app_url()) ?>" class="ane-topbar__link">Cek Produk</a>
                    <a href="<?= htmlspecialchars(app_path_url('/login')) ?>" class="ane-topbar__link">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <?php if ($isAdminLayout): ?>
    <div class="ane-shell">
        <aside class="ane-shell__sidebar">
            <div class="ane-shell__sidebar-head">
                <div class="ane-shell__eyebrow">Backoffice</div>
                <div class="ane-shell__title">Jalanyata Admin</div>
            </div>
            <?php require __DIR__ . '/admin_nav.php'; ?>
        </aside>
        <div class="ane-shell__main">
    <?php endif; ?>

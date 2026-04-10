<?php

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/admin_company.php';
require_once __DIR__ . '/products.php';

if (!function_exists('jalanyata_bootstrap_layout_session_context')) {
    function jalanyata_bootstrap_layout_session_context(PDO $conn)
    {
        jalanyata_session_start();

        try {
            $companyInfo = jalanyata_fetch_company_brand($conn);
            if ($companyInfo) {
                $_SESSION['company_name'] = $companyInfo['company_name'];
                $_SESSION['company_logo_url'] = $companyInfo['company_logo_url'];
            } else {
                $_SESSION['company_name'] = 'Verifane';
                $_SESSION['company_logo_url'] = null;
            }

            $_SESSION['first_product_year'] = jalanyata_fetch_first_product_year($conn);
        } catch (PDOException $e) {
            $_SESSION['company_name'] = 'Verifane';
            $_SESSION['company_logo_url'] = null;
            $_SESSION['first_product_year'] = date('Y');
        }
    }
}

if (!function_exists('jalanyata_build_layout_context')) {
    function jalanyata_build_layout_context($options = [])
    {
        $layoutMode = $options['layoutMode'] ?? 'public';
        $companyName = $_SESSION['company_name'] ?? 'Verifane';
        $companyLogoUrl = $_SESSION['company_logo_url'] ?? null;
        $pageTitle = $options['pageTitle'] ?? ('Cek Keaslian Produk ' . $companyName);
        $pageDescription = $options['pageDescription'] ?? ('Cek Keaslian produk ' . $companyName . '. Gunakan website ini untuk memeriksa keaslian produk yang Anda miliki');
        $ogImage = $options['ogImage'] ?? app_url('/assets/images/og-image.webp');
        $bodyClass = $options['bodyClass'] ?? ($layoutMode === 'admin' ? 'ane-body ane-body--admin' : 'ane-body');
        $isAdminLayout = $layoutMode === 'admin';

        return [
            'layoutMode' => $layoutMode,
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'ogImage' => $ogImage,
            'bodyClass' => $bodyClass,
            'isAdminLayout' => $isAdminLayout,
            'layoutStylesheet' => $isAdminLayout ? '/css/admin.min.css' : '/css/public.min.css',
            'dashboardUrl' => (($_SESSION['user_role'] ?? '') === 'reader')
                ? app_path_url('/reader/dashboard.php')
                : app_path_url('/dashboard'),
            'companyName' => $companyName,
            'companyLogoUrl' => $companyLogoUrl,
        ];
    }
}

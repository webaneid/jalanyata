<?php

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/admin_company.php';
require_once __DIR__ . '/frontend_templates.php';
require_once __DIR__ . '/products.php';

if (!function_exists('jalanyata_bootstrap_layout_session_context')) {
    function jalanyata_bootstrap_layout_session_context(PDO $conn)
    {
        jalanyata_session_start();
        $frontendTemplate = null;
        $frontendTemplateConfig = jalanyata_frontend_template_defaults();

        try {
            $companyInfo = jalanyata_fetch_company_brand($conn);
            if ($companyInfo) {
                $_SESSION['company_name'] = $companyInfo['company_name'];
                $_SESSION['company_logo_url'] = $companyInfo['company_logo_url'];
            } else {
                $_SESSION['company_name'] = 'Jalanyata';
                $_SESSION['company_logo_url'] = null;
            }

            $frontendTemplate = jalanyata_fetch_active_frontend_template($conn);
            if ($frontendTemplate) {
                $frontendTemplateConfig = jalanyata_frontend_template_config_from_row($frontendTemplate);
            }

            $_SESSION['frontend_template_id'] = $frontendTemplate['id'] ?? null;
            $_SESSION['frontend_template_key'] = $frontendTemplate['template_key'] ?? 'silver-classic';
            $_SESSION['frontend_template_name'] = $frontendTemplate['template_name'] ?? 'Silver Classic';
            $_SESSION['frontend_template_config'] = $frontendTemplateConfig;
            $_SESSION['first_product_year'] = jalanyata_fetch_first_product_year($conn);
        } catch (PDOException $e) {
            $_SESSION['company_name'] = 'Jalanyata';
            $_SESSION['company_logo_url'] = null;
            $_SESSION['frontend_template_id'] = null;
            $_SESSION['frontend_template_key'] = 'silver-classic';
            $_SESSION['frontend_template_name'] = 'Silver Classic';
            $_SESSION['frontend_template_config'] = $frontendTemplateConfig;
            $_SESSION['first_product_year'] = date('Y');
        }
    }
}

if (!function_exists('jalanyata_build_layout_context')) {
    function jalanyata_build_layout_context($options = [])
    {
        $layoutMode = $options['layoutMode'] ?? 'public';
        $companyName = $_SESSION['company_name'] ?? 'Jalanyata';
        $companyLogoUrl = $_SESSION['company_logo_url'] ?? null;
        $frontendTemplateKey = $_SESSION['frontend_template_key'] ?? 'silver-classic';
        $frontendTemplateName = $_SESSION['frontend_template_name'] ?? 'Silver Classic';
        $frontendTemplateConfig = $_SESSION['frontend_template_config'] ?? jalanyata_frontend_template_defaults();
        $pageTitle = $options['pageTitle'] ?? ($frontendTemplateConfig['page_title'] ?? ('Cek Keaslian Produk ' . $companyName));
        $pageDescription = $options['pageDescription'] ?? ($frontendTemplateConfig['page_description'] ?? ('Cek Keaslian produk ' . $companyName . '. Gunakan website ini untuk memeriksa keaslian produk yang Anda miliki'));
        $ogImage = $options['ogImage'] ?? $companyLogoUrl;
        $bodyClass = $options['bodyClass'] ?? ($layoutMode === 'admin'
            ? 'ane-body ane-body--admin'
            : 'ane-body ane-body--template-' . preg_replace('/[^a-z0-9_-]/i', '-', (string) $frontendTemplateKey));
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
            'frontendTemplateKey' => $frontendTemplateKey,
            'frontendTemplateName' => $frontendTemplateName,
            'frontendTemplateConfig' => $frontendTemplateConfig,
        ];
    }
}

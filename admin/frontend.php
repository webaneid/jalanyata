<?php
// File: admin/frontend.php
// Fungsi: Kelola template dan copy front-end publik

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');
require_once __DIR__ . '/../includes/frontend_templates.php';
require_once __DIR__ . '/../config/database.php';

$layoutMode = 'admin';
$pageTitle = 'Kelola Front-end';
$frontendTemplateAction = app_path_url('/api/frontend_templates.php?action=update');
$frontendTemplates = [];
$selectedTemplate = null;
$selectedTemplateConfig = jalanyata_frontend_template_defaults();

try {
    $frontendTemplates = jalanyata_fetch_frontend_templates($conn);
    $selectedTemplateId = isset($_GET['template_id']) ? (int) $_GET['template_id'] : (int) ($frontendTemplates[0]['id'] ?? 0);

    foreach ($frontendTemplates as $frontendTemplate) {
        if ((int) $frontendTemplate['id'] === $selectedTemplateId) {
            $selectedTemplate = $frontendTemplate;
            break;
        }
    }

    if ($selectedTemplate === null && $frontendTemplates !== []) {
        $selectedTemplate = $frontendTemplates[0];
    }

    if ($selectedTemplate !== null) {
        $selectedTemplateConfig = jalanyata_frontend_template_config_from_row($selectedTemplate);
    }
} catch (PDOException $e) {
    echo 'Error mengambil data front-end: ' . $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <?php require __DIR__ . '/../views/admin/frontend/page-head.php'; ?>
    <?php require __DIR__ . '/../views/admin/frontend/list-section.php'; ?>
    <?php require __DIR__ . '/../views/admin/frontend/form-section.php'; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

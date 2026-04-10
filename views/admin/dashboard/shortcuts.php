<section class="ane-panel ane-panel--padded">
    <h3 class="ane-page-head__title" style="font-size:1.25rem;">Menu Administrasi</h3>
    <p class="ane-page-head__meta">Akses modul utama backoffice.</p>
    <div class="ane-grid ane-grid--3" style="margin-top:16px;">
        <?php foreach ($dashboardShortcutLinks as $link): ?>
            <a href="<?= htmlspecialchars(app_path_url($link[0]), ENT_QUOTES, 'UTF-8') ?>" class="ane-card-link">
                <h4 class="ane-card-link__title"><?= htmlspecialchars($link[1], ENT_QUOTES, 'UTF-8') ?></h4>
                <p class="ane-card-link__meta"><?= htmlspecialchars($link[2], ENT_QUOTES, 'UTF-8') ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

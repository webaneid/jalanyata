<section class="ane-panel ane-panel--padded">
    <h2 class="ane-page-head__title" style="font-size:1.25rem;">Template Tersedia</h2>
    <div class="ane-table-wrap" style="margin-top:16px;">
        <table class="ane-table">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Key</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($frontendTemplates as $frontendTemplate): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $frontendTemplate['template_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $frontendTemplate['template_key'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= (int) $frontendTemplate['is_active'] === 1 ? 'Aktif' : 'Nonaktif' ?></td>
                        <td>
                            <a href="<?= htmlspecialchars(app_path_url('/admin/frontend.php?template_id=' . (int) $frontendTemplate['id']), ENT_QUOTES, 'UTF-8') ?>" class="ane-link">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

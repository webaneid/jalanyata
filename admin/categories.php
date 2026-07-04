<?php
// File: admin/categories.php
// Fungsi: Kelola kategori produk.

require_once __DIR__ . '/../includes/auth.php';
jalanyata_require_role('admin');

require_once __DIR__ . '/../includes/categories.php';
require_once __DIR__ . '/../config/database.php';

$layoutMode = 'admin';
$pageTitle = 'Kelola Kategori';
$categories = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $categoryId = (int) ($_POST['id'] ?? 0);
        $categoryName = trim((string) ($_POST['name'] ?? ''));

        if ($action === 'save') {
            if ($categoryName === '') {
                jalanyata_flash_set('category_error', 'Nama kategori wajib diisi.');
                jalanyata_redirect('/admin/categories.php');
            }

            if ($categoryId > 0) {
                $updatedCategory = jalanyata_update_category($conn, $categoryId, $categoryName);
                if ($updatedCategory === false) {
                    jalanyata_flash_set('category_error', 'Nama kategori sudah dipakai kategori lain.');
                } elseif ($updatedCategory === null) {
                    jalanyata_flash_set('category_error', 'Kategori tidak ditemukan.');
                } else {
                    jalanyata_flash_set('category_success', 'Kategori berhasil diubah.');
                }
            } else {
                $createdCategory = jalanyata_create_category($conn, $categoryName);
                if ($createdCategory === null) {
                    jalanyata_flash_set('category_error', 'Nama kategori wajib diisi.');
                } else {
                    jalanyata_flash_set('category_success', 'Kategori berhasil ditambahkan.');
                }
            }

            jalanyata_redirect('/admin/categories.php');
        }

        if ($action === 'delete') {
            if ($categoryId <= 0) {
                jalanyata_flash_set('category_error', 'Kategori tidak valid.');
                jalanyata_redirect('/admin/categories.php');
            }

            if (jalanyata_category_usage_count($conn, $categoryId) > 0) {
                jalanyata_flash_set('category_error', 'Kategori masih dipakai oleh data foto produk.');
                jalanyata_redirect('/admin/categories.php');
            }

            if (jalanyata_delete_category($conn, $categoryId)) {
                jalanyata_flash_set('category_success', 'Kategori berhasil dihapus.');
            } else {
                jalanyata_flash_set('category_error', 'Kategori tidak ditemukan.');
            }

            jalanyata_redirect('/admin/categories.php');
        }
    }

    $categories = jalanyata_fetch_categories($conn);
} catch (PDOException $e) {
    echo 'Error mengambil data kategori: ' . $e->getMessage();
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="ane-admin-page ane-section-stack">
    <section class="ane-page-head">
        <div>
            <h1 class="ane-page-head__title">Kelola Kategori</h1>
            <p class="ane-page-head__meta">Tambah, ubah, dan hapus kategori produk.</p>
        </div>
        <a href="<?= htmlspecialchars(app_path_url('/dashboard'), ENT_QUOTES, 'UTF-8') ?>" class="ane-link">&larr; Kembali ke Dashboard</a>
    </section>

    <section class="ane-panel ane-panel--padded">
        <?php jalanyata_flash_render('category_success', 'success'); ?>
        <?php jalanyata_flash_render('category_error', 'danger'); ?>

        <form id="category-form" action="<?= htmlspecialchars(app_path_url('/admin/categories.php'), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="ane-section-stack">
            <input type="hidden" id="category_id" name="id" value="">
            <input type="hidden" id="category_action" name="action" value="save">
            <div class="ane-grid ane-grid--2">
                <div class="ane-field">
                    <label for="category_name" class="ane-label">Nama Kategori</label>
                    <input type="text" id="category_name" name="name" class="ane-input" placeholder="contoh: Platinum" required>
                </div>
            </div>
            <div class="ane-actions ane-actions--start">
                <button type="submit" id="submit-button" class="ane-button">Tambah Kategori</button>
                <button type="button" id="cancel-button" class="ane-button ane-button--secondary ane-hidden">Batal</button>
            </div>
        </form>
    </section>

    <section class="ane-panel ane-panel--padded">
        <h2 class="ane-page-head__title" style="font-size:1.25rem;">Daftar Kategori</h2>
        <div class="ane-table-wrap" style="margin-top:16px;">
            <table class="ane-table">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Dipakai</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr
                            data-id="<?= (int) $category['id'] ?>"
                            data-name="<?= htmlspecialchars((string) $category['name'], ENT_QUOTES, 'UTF-8') ?>"
                        >
                            <td><?= htmlspecialchars((string) $category['name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= (int) ($category['product_photo_count'] ?? 0) ?> foto</td>
                            <td>
                                <div class="ane-table-actions">
                                    <button type="button" onclick="editCategory(this)" class="ane-link ane-link-button">Edit</button>
                                    <form action="<?= htmlspecialchars(app_path_url('/admin/categories.php'), ENT_QUOTES, 'UTF-8') ?>" method="POST" class="ane-inline-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
                                        <button type="submit" class="ane-link ane-link-button ane-link-button--danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
function editCategory(button) {
    const row = button.closest('tr');
    const id = row.dataset.id;
    const name = row.dataset.name;

    document.getElementById('category_id').value = id;
    document.getElementById('category_name').value = name;
    document.getElementById('submit-button').innerText = 'Simpan Perubahan';
    document.getElementById('cancel-button').classList.remove('ane-hidden');
}

document.getElementById('cancel-button').addEventListener('click', () => {
    document.getElementById('category_id').value = '';
    document.getElementById('category_name').value = '';
    document.getElementById('submit-button').innerText = 'Tambah Kategori';
    document.getElementById('cancel-button').classList.add('ane-hidden');
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';

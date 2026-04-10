<div class="ane-table-wrap">
    <table class="ane-table">
        <thead>
            <tr>
                <th scope="col">Kode Ukuran</th>
                <th scope="col">Ukuran</th>
                <th scope="col">Foto</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($photos as $photo): ?>
                <tr
                    data-id="<?= (int) $photo['id'] ?>"
                    data-code="<?= htmlspecialchars((string) $photo['kodeukuran'], ENT_QUOTES, 'UTF-8') ?>"
                    data-weight="<?= htmlspecialchars((string) $photo['product_weight'], ENT_QUOTES, 'UTF-8') ?>"
                    data-photo-url="<?= htmlspecialchars((string) $photo['photo_url'], ENT_QUOTES, 'UTF-8') ?>"
                >
                    <td><?= htmlspecialchars((string) $photo['kodeukuran'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string) $photo['product_weight'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <img
                            src="<?= htmlspecialchars((string) $photo['photo_url'], ENT_QUOTES, 'UTF-8') ?>"
                            alt="Foto <?= htmlspecialchars((string) $photo['kodeukuran'], ENT_QUOTES, 'UTF-8') ?>"
                            class="ane-photo-thumb"
                        >
                    </td>
                    <td>
                        <div class="ane-table-actions">
                            <button onclick="editPhoto(this)" class="ane-link ane-link-button">Edit</button>
                            <form
                                action="<?= htmlspecialchars($productPhotoDeleteAction, ENT_QUOTES, 'UTF-8') ?>"
                                method="POST"
                                class="ane-inline-form"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto produk ini?');"
                            >
                                <input type="hidden" name="id" value="<?= (int) $photo['id'] ?>">
                                <button type="submit" class="ane-link ane-link-button ane-link-button--danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

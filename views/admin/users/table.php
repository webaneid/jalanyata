<div class="ane-table-wrap">
    <table class="ane-table">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Role</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr
                    data-id="<?= (int) $user['id'] ?>"
                    data-username="<?= htmlspecialchars((string) $user['username'], ENT_QUOTES, 'UTF-8') ?>"
                    data-role="<?= htmlspecialchars((string) $user['role'], ENT_QUOTES, 'UTF-8') ?>"
                >
                    <td><?= htmlspecialchars((string) $user['username'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string) $user['role'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <div class="ane-table-actions">
                            <button onclick="editUser(this)" class="ane-link ane-link-button">Edit</button>
                            <form
                                action="<?= htmlspecialchars($userDeleteAction, ENT_QUOTES, 'UTF-8') ?>"
                                method="POST"
                                class="ane-inline-form"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');"
                            >
                                <input type="hidden" name="id" value="<?= (int) $user['id'] ?>">
                                <button type="submit" class="ane-link ane-link-button ane-link-button--danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

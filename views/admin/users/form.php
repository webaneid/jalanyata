<h2 id="form-title" class="ane-page-head__title" style="font-size:1.25rem;">Tambah User Baru</h2>
<form id="user-form" action="<?= htmlspecialchars($userCreateAction, ENT_QUOTES, 'UTF-8') ?>" method="POST" class="ane-section-stack">
    <input type="hidden" id="user_id" name="id">
    <div class="ane-grid ane-grid--3">
        <div class="ane-field">
            <label for="username" class="ane-label">Username</label>
            <input type="text" id="username" name="username" class="ane-input" required>
        </div>
        <div class="ane-field">
            <label for="password" class="ane-label">Password</label>
            <input type="password" id="password" name="password" class="ane-input" required>
        </div>
        <div class="ane-field">
            <label for="role" class="ane-label">Role</label>
            <select id="role" name="role" class="ane-select">
                <option value="reader">Reader</option>
                <option value="admin">Admin</option>
            </select>
        </div>
    </div>
    <div class="ane-actions ane-actions--start">
        <button type="submit" id="submit-button" class="ane-button">Tambah User</button>
        <button type="button" id="cancel-button" class="ane-button ane-button--secondary ane-hidden">Batal</button>
    </div>
</form>

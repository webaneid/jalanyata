<script>
function editUser(button) {
    const row = button.closest('tr');
    const id = row.dataset.id;
    const username = row.dataset.username;
    const role = row.dataset.role;

    document.getElementById('form-title').innerText = 'Edit User';
    document.getElementById('user-form').action = <?= json_encode($userEditAction) ?>;
    document.getElementById('user_id').value = id;
    document.getElementById('username').value = username;
    document.getElementById('password').value = '';
    document.getElementById('password').placeholder = 'Masukkan password baru (opsional)';
    document.getElementById('password').required = false;
    document.getElementById('role').value = role;
    document.getElementById('submit-button').innerText = 'Simpan Perubahan';
    document.getElementById('cancel-button').classList.remove('ane-hidden');
}

document.getElementById('cancel-button').addEventListener('click', () => {
    document.getElementById('form-title').innerText = 'Tambah User Baru';
    document.getElementById('user-form').action = <?= json_encode($userCreateAction) ?>;
    document.getElementById('user_id').value = '';
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
    document.getElementById('password').placeholder = '';
    document.getElementById('password').required = true;
    document.getElementById('role').value = 'reader';
    document.getElementById('submit-button').innerText = 'Tambah User';
    document.getElementById('cancel-button').classList.add('ane-hidden');
});
</script>

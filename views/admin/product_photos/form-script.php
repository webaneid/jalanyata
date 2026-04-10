<script>
function editPhoto(button) {
    const row = button.closest('tr');
    const id = row.dataset.id;
    const code = row.dataset.code;
    const weight = row.dataset.weight;

    document.getElementById('form-title').innerText = 'Edit Foto Produk';
    document.getElementById('photo-form').action = <?= json_encode($productPhotoEditAction) ?>;
    document.getElementById('photo_id').value = id;
    document.getElementById('kodeukuran').value = code;
    document.getElementById('product_weight').value = weight;
    document.getElementById('photo_file').required = false;
    document.getElementById('photo-note').classList.remove('ane-hidden');
    document.getElementById('submit-button').innerText = 'Simpan Perubahan';
    document.getElementById('cancel-button').classList.remove('ane-hidden');
}

document.getElementById('cancel-button').addEventListener('click', () => {
    document.getElementById('form-title').innerText = 'Tambah Foto Produk Baru';
    document.getElementById('photo-form').action = <?= json_encode($productPhotoCreateAction) ?>;
    document.getElementById('photo_id').value = '';
    document.getElementById('kodeukuran').value = '';
    document.getElementById('product_weight').value = '';
    document.getElementById('photo_file').required = true;
    document.getElementById('photo-note').classList.add('ane-hidden');
    document.getElementById('submit-button').innerText = 'Tambah Foto';
    document.getElementById('cancel-button').classList.add('ane-hidden');
});
</script>

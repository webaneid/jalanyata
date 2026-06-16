<script>
function editPhoto(button) {
    const row = button.closest('tr');
    const id = row.dataset.id;
    const categoryId = row.dataset.categoryId;
    const code = row.dataset.code;
    const weight = row.dataset.weight;

    document.getElementById('form-title').innerText = 'Edit Foto Produk';
    document.getElementById('photo-form').action = <?= json_encode($productPhotoEditAction) ?>;
    document.getElementById('photo_id').value = id;
    document.getElementById('category_id').value = categoryId;
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
    document.getElementById('category_id').value = '';
    document.getElementById('kodeukuran').value = '';
    document.getElementById('product_weight').value = '';
    document.getElementById('photo_file').required = true;
    document.getElementById('photo-note').classList.add('ane-hidden');
    document.getElementById('submit-button').innerText = 'Tambah Foto';
    document.getElementById('cancel-button').classList.add('ane-hidden');
});

(function () {
    const form = document.getElementById('photo-form');
    const select = document.getElementById('category_id');
    const openButton = document.getElementById('open-category-modal');
    const modal = document.getElementById('category-modal');
    const categoryForm = document.getElementById('category-form');
    const categoryNameInput = document.getElementById('category_name');
    const closeButtons = modal.querySelectorAll('[data-category-modal-close]');
    const createAction = form.dataset.categoryCreateAction;

    const openModal = () => {
        modal.classList.remove('ane-hidden');
        modal.setAttribute('aria-hidden', 'false');
        categoryNameInput.value = '';
        categoryNameInput.focus();
    };

    const closeModal = () => {
        modal.classList.add('ane-hidden');
        modal.setAttribute('aria-hidden', 'true');
    };

    const addCategoryOption = (id, name) => {
        const optionExists = Array.from(select.options).some((option) => option.value === String(id));
        if (!optionExists) {
            const option = document.createElement('option');
            option.value = String(id);
            option.textContent = name;
            select.appendChild(option);
        }

        select.value = String(id);
    };

    openButton.addEventListener('click', openModal);
    closeButtons.forEach((button) => button.addEventListener('click', closeModal));

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('ane-hidden')) {
            closeModal();
        }
    });

    categoryForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const name = categoryNameInput.value.trim();
        if (!name) {
            categoryNameInput.focus();
            return;
        }

        const formData = new FormData();
        formData.append('name', name);

        try {
            const response = await fetch(createAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();
            if (!response.ok || !result.success) {
                alert(result.message || 'Gagal menambahkan kategori.');
                return;
            }

            addCategoryOption(result.category.id, result.category.name);
            closeModal();
        } catch (error) {
            console.error(error);
            alert('Gagal menambahkan kategori.');
        }
    });
})();
</script>

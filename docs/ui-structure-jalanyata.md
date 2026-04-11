# UI Structure Jalanyata

Dokumen ini menetapkan struktur UI Jalanyata dengan pola yang mengacu pada `026-ui-extraction-plan.md` di Jaladana.

## Layer UI

### Theme

Theme disimpan pada stylesheet global dan menjadi sumber token visual:

- warna semantik
- typography
- spacing
- radius
- shadow

Kontrak token:

- `--ane-bg-canvas`
- `--ane-bg-panel`
- `--ane-bg-sidebar`
- `--ane-text-primary`
- `--ane-text-muted`
- `--ane-border`
- `--ane-accent`
- `--ane-accent-strong`
- `--ane-danger`
- `--ane-radius-sm`
- `--ane-radius-md`
- `--ane-radius-lg`
- `--ane-shadow-panel`

### UI Primitives

Primitives tetap berada di stylesheet global dan dipakai lintas halaman:

- `.ane-panel`
- `.ane-button`
- `.ane-button--secondary`
- `.ane-input`
- `.ane-select`
- `.ane-alert`
- `.ane-table`
- `.ane-page-head`

### Admin Shell

Shell admin dasar dibentuk oleh:

- `includes/header.php`
- `includes/footer.php`
- `includes/admin_nav.php`

Kontrak shell:

- halaman admin menetapkan `$layoutMode = 'admin'`
- header membuka wrapper shell
- footer menutup wrapper shell
- konten halaman berada di area `.ane-shell__main`

### Public Shell

Surface public dan verifikasi sekarang memakai shell yang lebih ringan:

- header public hanya menampilkan logo/brand
- header public tidak sticky
- header public tidak membawa menu navigasi
- background header public menyatu dengan kanvas halaman
- bahasa visual public memakai tema silver terang, sedangkan tombol utama tetap dark-silver

Kontrak shell public:

- halaman public tidak menampilkan nav backoffice
- halaman verifikasi valid/tidak valid dan landing page memakai bundle `css/public.min.css`
- perubahan visual public harus menjaga konsistensi antar `home`, `dataasli`, dan `datatidakasli`

## Adopsi Bertahap

Adopsi utama yang sudah selesai:

- shell admin utama
- dashboard admin
- halaman produk admin
- users
- company
- product photos
- upload excel
- landing page publik
- halaman verifikasi valid/tidak valid
- reader dashboard

Status saat ini:

- admin dan public sudah memakai bundle CSS terpisah
- JS produk admin dan reader juga sudah dipisah
- boundary partial utama berada di `views/admin/` dan `views/reader/`

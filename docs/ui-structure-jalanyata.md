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

## Adopsi Bertahap

Tahap awal adopsi dibatasi ke:

- dashboard admin
- halaman produk admin
- login admin
- landing page publik

Halaman lain tetap berjalan dengan layout lama sampai dipindahkan secara eksplisit.

# jalanyata

## Ringkasan

Jalanyata adalah aplikasi verifikasi produk berbasis PHP procedural dengan:

- verifikasi publik melalui route `/cek/{kode}`
- backoffice admin/reader
- generator produk massal khusus role `developer`
- import produk dari Excel
- master ukuran produk berbasis `kodeukuran`, `ukuran`, dan `foto`

## Setup

1. Copy `.env.example` menjadi `.env`
2. Buat database kosong
3. Jalankan `composer install`
4. Jalankan `php database/migrate.php`
5. Pastikan folder `uploads/` writable

## Database Migration

Project ini memakai migration SQL sederhana di folder `database/migrations`.

Perintah:

```bash
php database/migrate.php
```

Atau lewat Composer:

```bash
composer db:migrate
```

Migration yang sudah dijalankan dicatat di tabel `schema_migrations`.

## Deploy Produksi

Target produksi yang sudah dipakai:

- subdomain: `https://cek.shafirsilver.com`
- folder hosting: `public_html/cek`

Langkah ringkas:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php database/migrate.php
chmod 755 uploads
```

Tambahkan `.htaccess` berikut bila route seperti `/login` atau `/cek/...` belum berjalan:

```apache
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L,QSA]
```

## Update Server

Untuk update rutin di server:

```bash
cd ~/public_html/cek
git pull origin main
composer install --no-dev --optimize-autoloader
php database/migrate.php
```

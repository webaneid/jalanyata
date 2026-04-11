# Deploy Hostinger

Dokumen ini merekam langkah deploy Jalanyata pada shared hosting Hostinger dengan target:

- subdomain: `cek.shafirsilver.com`
- folder: `public_html/cek`

## Prasyarat

- subdomain sudah diarahkan ke folder project
- akses SSH aktif
- database MySQL/MariaDB sudah dibuat
- PHP CLI dan Composer tersedia di server

## Struktur `.env`

Contoh minimum:

```env
APP_URL=https://cek.shafirsilver.com
APP_BASE_PATH=

DB_HOST=localhost
DB_USER=your_db_user
DB_PASS=your_db_password
DB_NAME=your_db_name
DB_CHARSET=utf8mb4
```

Catatan:

- `APP_BASE_PATH` tetap kosong bila aplikasi hidup di root subdomain
- nama folder `public_html/cek` adalah detail file system, bukan bagian URL publik

## Install Awal

Masuk ke folder deploy:

```bash
cd ~/public_html/cek
```

Clone project:

```bash
git clone https://github.com/webaneid/jalanyata.git .
```

Install dependency:

```bash
composer install --no-dev --optimize-autoloader
```

Jalankan migrasi:

```bash
php database/migrate.php
```

Pastikan folder upload writable:

```bash
mkdir -p uploads
chmod 755 uploads
```

## Rewrite Route

Bila route seperti `/login` atau `/cek/{kode}` mengembalikan `404`, buat `.htaccess`:

```apache
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L,QSA]
```

## Update Rutin

Untuk update dari GitHub:

```bash
cd ~/public_html/cek
git pull origin main
composer install --no-dev --optimize-autoloader
php database/migrate.php
```

## Verifikasi Cepat

```bash
curl -I https://cek.shafirsilver.com
curl -I https://cek.shafirsilver.com/login
```

Hasil yang diharapkan:

- `/` mengembalikan `200`
- `/login` tidak lagi `404`

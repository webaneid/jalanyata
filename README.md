# jalanyata

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

## Default Developer Account

Setelah migration selesai, akun developer privat tersedia:

- Username: `admin@webane.com`
- Password: `Semangat*2026&Menyala`

Akun ini tidak muncul di dashboard admin biasa dan dipakai untuk akses fitur privat developer.

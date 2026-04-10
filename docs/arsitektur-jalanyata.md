# Arsitektur Jalanyata

## Ringkasan Eksekutif

Project `Jalanyata` adalah aplikasi PHP monolitik kecil berbasis file system, tanpa framework, yang berfungsi untuk:

1. Memverifikasi keaslian produk melalui kode unik.
2. Menyediakan backoffice admin untuk mengelola produk, pengguna, identitas perusahaan, dan foto produk.
3. Menyediakan dashboard terbatas untuk user dengan role `reader` agar dapat melihat data produk dan mengunduh QR code.

Arsitektur yang dipakai bersifat **procedural PHP + server-rendered pages + endpoint API sederhana**. Tidak ada pemisahan formal antara layer controller, service, repository, dan view model. Sebagian besar logika bisnis tersebar langsung di file halaman (`admin/*.php`, `reader/*.php`) dan endpoint (`api/*.php`).

Secara operasional, aplikasi ini cukup langsung dan mudah dipahami untuk skala kecil. Refactor fondasi sudah memperbaiki konfigurasi berbasis environment, guard auth, validasi upload, dan pemisahan asset utama. Namun, dari sisi maintainability, masih ada titik lemah pada layering, duplikasi query, dan coupling antarmodul.

## Tujuan Sistem

Sistem ini dibangun untuk mendukung use case verifikasi produk fisik, khususnya produk dengan identitas unik per item.

Kapabilitas utama:

- Landing page untuk input kode produk.
- Routing verifikasi ke URL berbentuk `/cek/{kode}`.
- Pencarian kode terhadap tabel `products`.
- Penampilan hasil verifikasi asli/tidak valid.
- Pengelolaan katalog produk melalui panel admin.
- Pengunggahan massal produk dari file Excel `.xlsx`.
- Pengelolaan foto produk berdasarkan berat produk.
- Pengelolaan identitas perusahaan dan logo.
- Pengelolaan akun internal dengan role `admin` dan `reader`.
- Pembuatan QR code di sisi browser untuk diunduh satuan maupun massal.

## Gaya Arsitektur

Arsitektur saat ini paling tepat dikategorikan sebagai:

- Monolith PHP tradisional.
- File-based routing sederhana.
- Server-side rendered HTML untuk halaman utama.
- JSON API minimal untuk verifikasi produk.
- Penyimpanan file upload langsung ke folder lokal `uploads/`.
- Database relasional MariaDB/MySQL yang diakses langsung via PDO.

Tidak ditemukan:

- Framework seperti Laravel, Symfony, Slim, CodeIgniter, atau sejenisnya.
- Dependency Injection container.
- ORM.
- Migration tool.
- Test suite.
- Build pipeline frontend modern.

## Struktur Folder

### Root project

- `index.php`
  Router utama aplikasi berbasis `REQUEST_URI`.
- `logout.php`
  Mengakhiri session dan redirect ke login.
- `composer.json`
  Menunjukkan hanya satu dependensi utama: `phpoffice/phpspreadsheet`.

### Konfigurasi

- `includes/config.php`
  Memuat `.env`, helper `env_value()`, `app_url()`, dan `app_path_url()` sebagai sumber konfigurasi URL terpusat.
- `config/database.php`
  Membuat koneksi PDO dari environment variable database.

### Shared helpers dan layout

- `includes/auth.php`
  Helper session, login, logout, redirect, dan guard role.
- `includes/flash.php`
  Helper flash message berbasis session.
- `includes/upload.php`
  Helper upload, validasi file, path, public URL, dan delete file upload.
- `includes/products.php`
  Helper domain produk untuk filter, query, pagination, verifikasi, mutasi, import, URL, row action kecil, dan handler action produk.
- `includes/admin_dashboard.php`
  Helper summary dashboard admin dan data shortcut modul.
- `includes/admin_company.php`
  Helper query domain perusahaan dan handler action update company.
- `includes/admin_users.php`
  Helper query, pagination, URL domain user admin, dan handler action auth/user.
- `includes/admin_product_photos.php`
  Helper query domain foto produk dan handler action CRUD foto.
- `includes/layout_context.php`
  Helper bootstrap session/layout context untuk header dan footer.
- `includes/header.php`
  Header global yang memakai helper layout context untuk bootstrap brand, metadata halaman, dan shell admin.
- `includes/footer.php`
  Footer global yang memakai helper layout context untuk mode layout dan brand text.
- `includes/admin_nav.php`
  Navigasi admin shell.

### Halaman publik

- `views/home.php`
  Landing page input kode.
- `views/dataasli.php`
  Tampilan hasil verifikasi valid.
- `views/datatidakasli.php`
  Tampilan hasil verifikasi gagal.

### Partial admin view

- `views/admin/dashboard/`
  Partial metrics, charts, shortcuts, dan script dashboard admin.
- `views/admin/company/`
  Partial page head, form, dan form section untuk data perusahaan.
- `views/admin/users/`
  Partial page head, search form, form, list section, tabel, dan script user admin.
- `views/admin/product_photos/`
  Partial page head, form, list section, tabel, dan script foto produk.
- `views/admin/products/`
  Partial page head, search form, form, list section, toolbar, dan script halaman produk admin.
- `views/admin/upload_excel/`
  Partial page head, form, dan form section upload Excel.
- `views/products/table.php`
  Partial tabel produk bersama untuk admin dan reader.

### Backoffice admin

- `admin/login.php`
  Form login kecil satu halaman; sengaja belum dipisah ke partial terpisah karena belum membawa section/layout besar.
- `admin/dashboard.php`
  Dashboard statistik dan navigasi modul admin.
- `admin/products.php`
  CRUD produk, filter, pencarian, paginasi, dan QR code bulk download.
- `admin/users.php`
  CRUD user admin/reader.
- `admin/company.php`
  Kelola identitas perusahaan dan logo.
- `admin/product_photos.php`
  Kelola foto berdasarkan berat produk.
- `admin/upload_excel.php`
  Form import produk dari Excel.

### Reader area

- `reader/dashboard.php`
  Dashboard baca-only-ish untuk role `reader`, dengan fitur lihat produk dan unduh QR code.

### API / action endpoints

- `api/products.php`
  Endpoint JSON verifikasi produk dan dispatcher mutasi produk ke helper domain.
- `api/users.php`
  Dispatcher login dan CRUD user ke helper domain.
- `api/company.php`
  Dispatcher update identitas perusahaan ke helper domain.
- `api/product_photos.php`
  Dispatcher CRUD foto produk ke helper domain.

### Data dan aset

- `uploads/`
  Penyimpanan file upload logo dan foto produk.
- `sql/u591451424_cekaurora.sql`
  Dump database lengkap.
- `css/` dan `assets/`
  Aset styling dan sumber SCSS/gambar.
- `vendor/`
  Dependensi Composer.

## Komponen Inti dan Tanggung Jawab

### 1. Router utama

`index.php` adalah entry point utama untuk trafik web publik dan sebagian trafik internal.

Perilaku routing:

- `/` atau `/home` memuat landing page.
- `/login` memuat halaman login admin.
- `/dashboard` memuat dashboard admin bila session valid.
- `/cek/{kode}` melakukan lookup produk lalu merender halaman asli atau tidak valid.
- selain route di atas menghasilkan `404`.

Ini adalah router minimal berbasis `switch` dan regex. Ia tidak memiliki konsep middleware formal, grouping route, named route, atau handler abstraction.

### 2. Session-based authentication

Autentikasi menggunakan PHP session native:

- session dimulai dengan `session_start()`.
- data login disimpan ke `$_SESSION`.
- kunci penting yang digunakan:
  - `user_id`
  - `username`
  - `user_role`

Role yang terlihat di sistem:

- `admin`
- `reader`

Otorisasi utama sekarang dipusatkan melalui helper `jalanyata_require_role()`, walau implementasinya masih procedural di level file halaman dan endpoint.

### 3. Database access layer

Tidak ada layer abstraksi database formal. Query masih berbasis PDO procedural, tetapi sebagian domain sudah dipusatkan ke helper `includes/` yang kini berperan sebagai repository sederhana + action helper:

- `prepare` + `bindParam`/`bindValue` untuk banyak query dinamis.
- `query()` untuk query statis sederhana.
- helper domain seperti `includes/products.php`, `includes/admin_users.php`, `includes/admin_company.php`, dan `includes/admin_product_photos.php`.

Koneksi database tetap dibuat melalui include `config/database.php`, lalu halaman/endpoint memanggil helper domain yang relevan.

### 4. View rendering

Rendering halaman dilakukan dengan pola include:

1. `includes/header.php`
2. file halaman konten
3. `includes/footer.php`

Ini membuat struktur layout sederhana. Bootstrap session/layout context sekarang sudah dipindah ke `includes/layout_context.php`, tetapi header dan footer masih menjadi coupling point karena keduanya tetap bergantung pada session context bersama.

### 5. File upload subsystem

Upload file dipakai untuk:

- logo perusahaan.
- foto produk berdasarkan berat.

Semua file:

- dipindahkan ke `uploads/`.
- diberi nama acak berbasis `random_bytes()` dengan fallback `uniqid()`.
- URL file disimpan ke database.

Saat ini sudah ada validasi MIME, extension, ukuran file, dan pengecekan struktur dasar file untuk image dan Excel, tetapi belum ada storage abstraction, resizing image, atau antivirus scan.

### 6. QR code generation

QR code tidak dibuat di server. Aplikasi memakai JavaScript di browser:

- `qrcodejs`
- `JSZip` saat aksi ZIP dipakai
- `FileSaver.js` saat aksi ZIP dipakai

Admin dashboard dan reader dashboard menghasilkan QR code dari URL verifikasi produk, lalu memberi opsi unduh per item atau ZIP massal.

## Alur Request Penting

## 1. Alur verifikasi produk publik

Alur end-to-end:

1. User membuka halaman home.
2. User memasukkan kode produk.
3. JavaScript di `views/home.php` mengarahkan browser ke `/cek/{kode}`.
4. `index.php` menangkap pola route tersebut.
5. `index.php` query tabel `products` berdasarkan `product_id_code`.
6. Jika produk ada, sistem include `views/dataasli.php`.
7. `views/dataasli.php` melakukan query tambahan ke `product_photos` berdasarkan `product_weight`.
8. Jika produk tidak ada, sistem include `views/datatidakasli.php`.

Karakteristik alur ini:

- Rendered di server.
- Tidak bergantung pada API JSON aktif.
- Menggunakan dua query untuk jalur produk valid.

## 2. Alur login

Alur login:

1. User membuka `/login`.
2. Form submit ke `api/users.php?action=login`.
3. Endpoint mengambil user berdasarkan `username`.
4. Password diverifikasi dengan `password_verify()`.
5. Jika hash lama masih `sha256`, login tetap diterima lalu password di-upgrade otomatis ke `password_hash()`.
6. Jika valid:
   - role `admin` diarahkan ke `/dashboard`
   - role `reader` diarahkan ke `/reader/dashboard.php`
7. Jika gagal, pesan error disimpan di session dan user dikembalikan ke `/login`.

Catatan:

- Login flow masih sederhana dan cukup mudah diikuti.
- Sistem masih menyimpan kompatibilitas sementara untuk hash `sha256` lama sampai semua user pernah login ulang.

## 3. Alur CRUD produk admin

Alur utama:

1. Admin membuka `admin/products.php`.
2. Halaman memuat:
   - filter berat dari `product_photos`
   - data produk dengan search, filter, sort, dan pagination
   - semua kode produk untuk kebutuhan bulk QR download
3. Form tambah/edit submit ke `api/products.php?action=add|edit`.
4. Delete submit ke `api/products.php?action=delete`.
5. Endpoint mengubah data, menyimpan pesan sukses/error di session, lalu redirect kembali.

Karakteristik:

- Halaman admin bertindak sebagai view + query orchestrator.
- API endpoint bertindak sebagai mutation handler dengan redirect, bukan REST API murni.

## 4. Alur upload Excel

Alur:

1. Admin membuka `admin/upload_excel.php`.
2. Upload `.xlsx` dikirim ke `api/products.php?action=upload`.
3. Endpoint memuat `vendor/autoload.php`.
4. `PhpSpreadsheet\IOFactory` membaca worksheet aktif.
5. Setiap baris dibaca sebagai:
   - kolom 0: kode produk
   - kolom 1: berat produk
   - kolom 2: tanggal produksi
6. Tiap baris dicek:
   - kosong atau tidak
   - lengkap atau tidak
   - kode produk sudah ada atau belum
7. Data valid diinsert ke tabel `products`.
8. Ringkasan sukses/gagal disimpan ke session.

Karakteristik:

- Batch import dilakukan satu per satu, tanpa transaction batching.
- Tidak ada parser schema/templating yang lebih formal.
- Tidak ada pembatasan ukuran file yang terlihat di level aplikasi.

## 5. Alur manajemen foto produk

Alur:

1. Admin mengisi berat produk dan file gambar.
2. `api/product_photos.php` memastikan berat belum dipakai saat add.
3. File diupload ke `uploads/`.
4. Record `product_photos` dibuat/diupdate.
5. Saat delete atau edit dengan file baru, file lama berusaha dihapus dari disk.

Model relasi bisnis yang dipakai:

- satu berat produk memiliki satu foto representatif.
- banyak record di `products` dapat mereferensikan satu foto melalui `product_weight`.

## 6. Alur manajemen company profile

`admin/company.php` dan `api/company.php` mengelola satu record `company_info`.

Data ini dipakai oleh `includes/header.php` untuk:

- nama perusahaan.
- logo perusahaan.
- branding halaman.

Artinya, `company_info` adalah pusat konfigurasi brand level aplikasi.

## Skema Data

Berdasarkan dump SQL, tabel inti adalah:

### `products`

Peran:

- master data produk individual yang dapat diverifikasi.

Kolom penting:

- `id`
- `product_id_code`
- `product_weight`
- `product_date`
- `created_at`

Constraint:

- primary key pada `id`
- unique key pada `product_id_code`

Interpretasi domain:

- satu baris mewakili satu kode produk unik.
- `product_weight` dan `product_date` bersifat atribut display/domain, bukan foreign key formal.

### `product_photos`

Peran:

- peta satu foto representatif untuk satu kategori berat produk.

Kolom:

- `id`
- `product_weight`
- `photo_url`

Constraint:

- primary key pada `id`
- unique key pada `product_weight`

Interpretasi domain:

- `product_weight` berfungsi sebagai natural key.
- relasi ke `products` bersifat implicit melalui string yang sama, bukan foreign key.

### `users`

Peran:

- akun internal panel aplikasi.

Kolom:

- `id`
- `username`
- `password`
- `role`
- `created_at`

Constraint:

- primary key pada `id`
- unique key pada `username`

Interpretasi domain:

- autentikasi internal sederhana.
- role disimpan langsung sebagai string.

### `company_info`

Peran:

- konfigurasi identitas perusahaan.

Kolom:

- `id`
- `company_name`
- `company_address`
- `company_phone`
- `company_whatsapp`
- `company_logo_url`

Interpretasi domain:

- tabel ini dipakai seperti singleton configuration table.

## Relasi Data Aktual

Relasi yang benar-benar dipakai aplikasi:

- `products.product_id_code` dipakai untuk verifikasi publik.
- `products.product_weight` dicocokkan dengan `product_photos.product_weight`.
- `users.role` menentukan dashboard tujuan dan akses fitur.
- `company_info` dipakai global sebagai branding layer.

Catatan penting:

- Tidak ada foreign key database.
- Integritas relasi dijaga oleh aplikasi dan kebiasaan input data.
- Pendekatan ini fleksibel, tetapi rawan mismatch string, misalnya `100 gram` vs `100gram`.

## Dependensi dan Integrasi Eksternal

### Dependensi Composer

Hanya satu paket utama yang dideklarasikan:

- `phpoffice/phpspreadsheet`

Perannya:

- membaca file Excel untuk impor massal produk.

### Dependensi frontend CDN

File-file halaman memuat library dari CDN:

- Chart.js.
- QRCode.js.
- JSZip secara lazy-load saat ZIP dipakai.
- FileSaver.js secara lazy-load saat ZIP dipakai.
- Google Fonts.

Implikasi:

- deployment sederhana.
- ada ketergantungan pada availability pihak ketiga.
- performa dan reproducibility build tidak sepenuhnya terkontrol lokal.

### Asset frontend lokal

Asset UI utama saat ini dipisah menjadi:

- `css/public.min.css`
  Bundle ringan untuk surface publik dan reader.
- `css/admin.min.css`
  Bundle untuk backoffice admin.
- `assets/js/product-qr-core.js`
  Helper QR/download bersama.
- `assets/js/product-qr-admin.js`
  Wiring khusus halaman produk admin.
- `assets/js/product-qr-reader.js`
  Wiring khusus halaman produk reader.

## Keputusan Desain yang Terlihat

Beberapa keputusan desain yang tampak jelas:

- Memilih kesederhanaan implementasi dibanding layering formal.
- Menjadikan `index.php` sebagai router sentral untuk jalur publik utama.
- Menjadikan file `api/*.php` sebagai handler action, bukan API service murni.
- Memakai session native untuk autentikasi.
- Memakai string-based relation untuk memetakan berat produk ke foto.
- Memakai filesystem lokal untuk media upload.
- Memproses QR code di sisi client agar server tidak perlu menghasilkan image.

Keputusan-keputusan ini masuk akal untuk MVP atau aplikasi internal kecil, tetapi akan menimbulkan friction saat fitur dan tim bertambah.

## Temuan Arsitektural Penting

### Kekuatan

- Struktur cukup mudah dipahami tanpa onboarding panjang.
- Fitur bisnis inti sudah lengkap untuk skenario verifikasi produk.
- Query penting umumnya sudah memakai prepared statements.
- Unique constraint di database sudah membantu mencegah duplikasi `product_id_code`, `product_weight`, dan `username`.
- Import Excel sudah terintegrasi langsung dengan data produk.
- Branding perusahaan dapat diubah tanpa edit kode view.

### Kelemahan

#### 1. Konfigurasi runtime sudah dipusatkan, tetapi fallback default masih sensitif

`includes/config.php` dan `config/database.php` sudah membaca `.env`, namun fallback default lokal masih ada di source code. Untuk production, file `.env` tetap harus dianggap mandatory.

#### 2. Layering bercampur

Banyak file merangkap sebagai:

- guard otorisasi
- query data
- logika bisnis
- render HTML
- orkestrasi redirect

Efeknya:

- kode sulit diuji.
- duplikasi tinggi.
- perubahan kecil mudah memicu inkonsistensi.

Hasil audit helper render inline saat ini:

- Final boundary helper view kecil yang tetap dipertahankan:
  - `jalanyata_flash_render()`
  - `jalanyata_render_product_filter_controls()`
  - `jalanyata_render_product_pagination()`
  - `jalanyata_render_user_pagination()`
  - `jalanyata_render_admin_product_row_actions()`
  - `jalanyata_render_reader_product_row_actions()`

Blok besar yang sudah berhasil dipindah ke partial atau view component:

- `dashboard`:
  - `views/admin/dashboard/metrics.php`
  - `views/admin/dashboard/charts.php`
  - `views/admin/dashboard/shortcuts.php`
  - `views/admin/dashboard/chart-script.php`
- `company`:
  - `views/admin/company/page-head.php`
  - `views/admin/company/form.php`
  - `views/admin/company/form-section.php`
- `users`:
  - `views/admin/users/page-head.php`
  - `views/admin/users/search-form.php`
  - `views/admin/users/form-section.php`
  - `views/admin/users/form.php`
  - `views/admin/users/list-section.php`
  - `views/admin/users/table.php`
  - `views/admin/users/form-script.php`
- `product_photos`:
  - `views/admin/product_photos/page-head.php`
  - `views/admin/product_photos/form-section.php`
  - `views/admin/product_photos/form.php`
  - `views/admin/product_photos/list-section.php`
  - `views/admin/product_photos/table.php`
  - `views/admin/product_photos/form-script.php`
- `products`:
  - `views/admin/products/page-head.php`
  - `views/admin/products/search-form.php`
  - `views/admin/products/form-section.php`
  - `views/admin/products/form.php`
  - `views/admin/products/list-section.php`
  - `views/admin/products/list-toolbar.php`
  - `views/admin/products/page-script.php`
  - `views/products/table.php`
- `upload_excel`:
  - `views/admin/upload_excel/page-head.php`
  - `views/admin/upload_excel/form.php`
  - `views/admin/upload_excel/form-section.php`

Prinsip boundary yang dipakai:

- helper view tetap dipakai untuk fragment kecil yang terutama merakit URL, filter, pagination, dan action button.
- partial atau view component dipakai untuk blok form, tabel, metrics, dan script halaman yang sudah menjadi struktur UI utuh.
- `admin/login.php` saat ini tetap dibiarkan inline karena hanya berisi satu kartu form kecil dan belum menjadi sumber duplikasi layout.
- helper view kecil yang tersisa saat ini dianggap boundary final, bukan backlog refactor baru, kecuali nanti muncul duplikasi atau kompleksitas tambahan.

Boundary repository sederhana yang saat ini dianggap final:

- `includes/products.php`
  Menjadi pusat query verifikasi, list/filter produk, mutasi produk, dan import Excel.
- `includes/admin_users.php`
  Menjadi pusat query user, hashing/verify password, login, dan CRUD user.
- `includes/admin_company.php`
  Menjadi pusat query company info dan update identitas perusahaan.
- `includes/admin_product_photos.php`
  Menjadi pusat query dan CRUD foto produk berikut orkestrasi uploadnya.

Endpoint `api/*.php` sekarang diperlakukan hanya sebagai dispatcher request ke helper domain, bukan tempat query dan orkestrasi utama.

#### 3. Otorisasi sudah lebih konsisten, tetapi masih belum berbentuk middleware terpisah

Guard utama sudah dipusatkan ke `jalanyata_require_role()`, sehingga halaman admin dan reader tidak lagi mengulang pola pengecekan session secara liar. Namun implementasinya masih procedural dan belum dipisah menjadi layer middleware/service formal.

#### 4. Migrasi password sudah berjalan, tetapi kompatibilitas hash lama masih ada

Password baru sudah memakai `password_hash()` / `password_verify()`, dan login melakukan upgrade otomatis untuk hash `sha256` lama. Risiko yang tersisa adalah keberadaan hash legacy di database sampai seluruh akun lama bermigrasi lewat login atau reset password.

#### 5. Layout bootstrap masih cukup sentral

`includes/layout_context.php` dan `includes/header.php`:

- melakukan bootstrap context brand/layout
- memetakan default metadata halaman
- memodifikasi `$_SESSION`

Akibatnya, layout menjadi coupling point yang berat.

#### 6. Relasi data berbasis string

`product_weight` dipakai sebagai penghubung antar tabel tanpa foreign key. Ini membuat konsistensi data bergantung pada format string yang sama persis.

#### 7. URL base sudah dipusatkan, tetapi router publik masih campuran

Helper `app_url()` dan `app_path_url()` sudah dipakai luas untuk asset, redirect, upload URL, dan navigasi. Residual issue yang tersisa adalah router publik `index.php` masih mempertahankan sebagian pola lama sehingga lapisan routing belum sepenuhnya seragam.

Ini jauh lebih aman daripada kondisi awal, tetapi refactor routing belum selesai penuh.

#### 8. Validasi upload dasar sudah ada, tetapi hardening lanjutan masih terbuka

Saat ini sudah ada kontrol untuk:

- whitelist MIME/file extension gambar
- ukuran maksimum file
- verifikasi `getimagesize()` untuk image
- validasi struktur dasar file `.xlsx`

Yang masih belum ada:

- sanitasi metadata
- proteksi file executable terselubung
- scanning keamanan file

#### 9. Tidak ada migrasi dan test suite

Pengelolaan schema masih mengandalkan SQL dump. Ini menyulitkan perubahan skema bertahap dan repeatable deployment.

## Alur Modul Berdasarkan Layer Konseptual

Walau implementasinya procedural, secara konseptual sistem bisa dipetakan ke layer berikut:

### Presentation layer

- `views/*.php`
- `admin/*.php`
- `reader/*.php`
- `includes/header.php`
- `includes/footer.php`

Tanggung jawab:

- render HTML
- form input
- interaksi JavaScript ringan

### Application/action layer

- `index.php`
- `api/*.php`
- `logout.php`

Tanggung jawab:

- route matching
- redirect
- validasi request sederhana
- orkestrasi query

### Persistence layer

- `config/database.php`
- query PDO inline di semua modul

Tanggung jawab:

- koneksi database
- baca/tulis data

### Infrastructure layer

- `uploads/`
- asset frontend
- `vendor/`
- SQL dump

## Estimasi Kompleksitas Operasional

Untuk skala saat ini, aplikasi ini tergolong ringan:

- deployment cukup copy file PHP + vendor + database + uploads.
- tidak ada worker, queue, cache layer, atau scheduler.
- beban utama ada pada query database sederhana dan file serving statis.

Namun, karena semuanya menyatu, biaya perubahan naik cepat bila:

- role bertambah.
- aturan validasi produk makin kompleks.
- butuh audit trail.
- butuh multi-tenant / multi-brand.
- butuh API yang benar-benar publik dan terpisah dari alur redirect browser.

## Konfigurasi Domain dan Deploy

Bagian ini mendokumentasikan kontrak konfigurasi yang berlaku saat ini dan residual step yang masih tersisa.

### Topologi target yang diinginkan

Environment yang ingin didukung:

- lokal:
  - domain aplikasi Jalanyata: `http://jalanyata.test`
- produksi:
  - website utama brand: `https://shafirsilver.com`
  - aplikasi Jalanyata: `https://cek.shafirsilver.com`
  - target folder deploy Jalanyata pada shared hosting Hostinger: `public_html/cek`

Interpretasi arsitektural:

- aplikasi Jalanyata adalah aplikasi terpisah secara URL dari website utama.
- Jalanyata tidak menjadi root app untuk `shafirsilver.com`.
- Jalanyata harus dapat berjalan baik sebagai:
  - root domain lokal
  - subdomain produksi
  - aplikasi yang secara file system berada di subfolder hosting

### Kondisi konfigurasi saat ini

Fondasi konfigurasi saat ini sudah lebih baik karena:

- `includes/config.php` sudah memuat `.env`
- helper URL terpusat sudah dipakai luas
- `config/database.php` sudah membaca env database

Residual issue yang masih ada:

- fallback default lokal masih tersimpan di source
- `baseUrl`, `baseDomain`, dan `baseOridomain` masih dipertahankan untuk kompatibilitas
- router publik dan beberapa file lama masih belum sepenuhnya dipisah dari kontrak historis tersebut

### Arah solusi lanjutan

Pendekatan lanjutan adalah menyederhanakan jejak kompatibilitas lama setelah fondasi environment-based configuration selesai dipasang.

Target prinsip:

1. Domain dan path aplikasi tidak lagi di-hardcode di source utama.
2. Local, staging, dan production bisa memakai nilai berbeda tanpa edit kode aplikasi.
3. Deploy ke shared hosting tetap sederhana dan kompatibel dengan Hostinger.
4. URL absolut, redirect, asset path, dan upload URL dibangun dari konfigurasi yang konsisten.

### Opsi konfigurasi yang dipakai saat ini

Implementasi yang sekarang aktif:

- file `.env` sebagai sumber konfigurasi environment
- fallback default lokal bila `.env` tidak tersedia
- satu lapisan helper terpusat yang dipakai untuk URL aplikasi

Konfigurasi minimum yang dipakai:

- `APP_ENV`
- `APP_URL`
- `APP_BASE_PATH`
- `APP_DOMAIN`
- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

Interpretasi awal masing-masing:

- `APP_URL`
  URL utama aplikasi Jalanyata pada environment aktif
  contoh lokal: `http://jalanyata.test`
  contoh produksi: `https://cek.shafirsilver.com`
- `APP_BASE_PATH`
  path relatif aplikasi jika suatu saat tidak diletakkan di root host
  contoh umum: kosong atau `/cek`
- `APP_DOMAIN`
  hostname aplikasi tanpa path
  contoh: `jalanyata.test` atau `cek.shafirsilver.com`

Catatan desain:

- untuk kasus produksi yang sudah memakai subdomain `cek.shafirsilver.com`, secara URL publik kemungkinan `APP_BASE_PATH` tetap kosong
- fakta bahwa folder deploy berada di `public_html/cek` adalah detail file system hosting, bukan berarti URL publik harus menjadi `https://shafirsilver.com/cek`
- karena itu pemisahan antara URL publik dan lokasi file system harus dijaga tegas

### Kontrak konfigurasi saat ini

Agar konsisten, konfigurasi URL nantinya perlu dibedakan menjadi dua level:

- URL publik aplikasi
  dipakai untuk redirect, canonical URL, QR code target, asset absolut, dan link navigasi
- lokasi file system deploy
  dipakai hanya untuk penempatan file di server, bukan untuk membentuk URL

Aturan yang dipakai:

- aplikasi tidak boleh menyimpulkan URL dari folder server
- aplikasi tidak boleh menganggap nama folder deploy sama dengan path URL
- semua link absolut harus dibentuk dari `APP_URL`
- semua redirect internal sebaiknya memakai helper terpusat

### Dampak terhadap QR code dan verifikasi

Ini penting karena QR code saat ini dibentuk dari domain aplikasi.

Target perilaku:

- lokal: QR code boleh mengarah ke `http://jalanyata.test/cek/{kode}`
- produksi: QR code harus mengarah ke `https://cek.shafirsilver.com/cek/{kode}`

Artinya, pembentukan QR code harus mengikuti `APP_URL`, bukan nilai hardcoded.

### Dampak terhadap upload file

Saat ini URL file upload dibentuk dari konfigurasi dasar aplikasi.

Rencana perbaikannya:

- path file fisik tetap diarahkan ke folder `uploads/`
- URL publik file dibentuk dari `APP_URL`
- file system path dan public URL dibedakan eksplisit

Ini penting supaya:

- lokal tetap berjalan
- produksi di subdomain tetap benar
- perpindahan domain berikutnya tidak memerlukan edit massal record atau source code

### Kesesuaian dengan Hostinger shared hosting

Rencana ini kompatibel dengan shared hosting Hostinger, dengan asumsi:

- aplikasi Jalanyata di-deploy ke folder yang memang diarahkan oleh subdomain `cek.shafirsilver.com`
- web root subdomain tersebut menunjuk ke folder project yang benar
- `.env` dapat diletakkan di lokasi yang bisa dibaca PHP dan tidak ikut terekspos publik

Catatan operasional:

- bila subdomain `cek.shafirsilver.com` diarahkan ke `public_html/cek`, maka isi project Jalanyata akan berada di sana
- itu tetap aman selama aplikasi membangun URL dari `APP_URL`, bukan dari asumsi nama folder
- struktur ini juga tetap kompatibel dengan local domain `jalanyata.test`

### Residual step konfigurasi

Langkah konfigurasi yang masih tersisa:

1. Kurangi jejak kompatibilitas `baseUrl`, `baseDomain`, dan `baseOridomain` bila semua caller lama sudah hilang.
2. Pastikan production memaksa `.env` hadir dan tidak bergantung pada fallback default.
3. Uji ulang skenario:
   - lokal `jalanyata.test`
   - produksi `cek.shafirsilver.com`
   - path asset
   - upload logo/foto
   - QR code
   - login dan redirect admin

### Keputusan arsitektural saat ini

Setelah refactor fondasi yang sudah selesai, keputusan yang berlaku saat ini adalah:

- Jalanyata akan diperlakukan sebagai aplikasi yang URL publiknya bisa berubah per environment
- konfigurasi domain akan dipindah ke pola environment-based
- shared hosting Hostinger tetap menjadi target deployment yang didukung
- URL publik dan lokasi folder server akan diperlakukan sebagai dua hal yang berbeda

## Risiko Teknis Prioritas Tinggi

Urutan prioritas yang paling penting:

1. Pastikan production mewajibkan `.env` dan hilangkan fallback sensitif dari source bila tidak lagi dibutuhkan.
2. Tuntaskan migrasi hash password legacy `sha256` dari database.
3. Ubah relasi `product_weight` menjadi foreign key eksplisit atau setidaknya master table untuk berat produk.
4. Tambahkan migration workflow.
5. Tambahkan smoke test minimal untuk login, verifikasi, dan CRUD produk.

## Rekomendasi Refactor Bertahap

Pendekatan yang aman untuk project seperti ini adalah refactor bertahap, bukan rewrite total.

### Tahap 1: Hardening tanpa mengubah arsitektur besar

- Selesai: helper guard role, redirect, flash, upload, dan URL terpusat.
- Selesai: kredensial database dibaca dari env.
- Selesai: password hashing pindah ke `password_hash()` / `password_verify()` dengan upgrade legacy hash.
- Selesai: validasi upload dasar image dan Excel.
- Selesai: pemisahan bundle CSS public/admin dan bundle JS produk admin/reader.

### Tahap 2: Rapikan pemisahan tanggung jawab

- Belum selesai: pemisahan ke layer repository/service formal.
- Sudah berjalan: boundary helper per domain mulai jelas di `includes/products.php`, `includes/admin_dashboard.php`, `includes/admin_company.php`, `includes/admin_users.php`, dan `includes/admin_product_photos.php`.
- Belum selesai: query lintas modul masih banyak berada di file halaman dan action endpoint.
- Selesai untuk halaman admin utama: blok UI besar `dashboard`, `company`, `users`, `product_photos`, `products`, dan `upload_excel` sudah dipindah ke partial atau view component di `views/admin/`.
- Tersisa sengaja kecil: `admin/login.php` belum dipisah lebih jauh karena belum membutuhkan section/component tambahan.
- Selesai untuk boundary view kecil: helper flash, filter, pagination, dan row action tetap dipertahankan sebagai boundary final saat ini.

### Tahap 3: Rapikan model domain

- Buat master data berat produk.
- Gunakan foreign key antar tabel.
- Normalisasi field tanggal produksi bila memang seharusnya bertipe tanggal/bulan, bukan string bebas.

### Tahap 4: Tingkatkan delivery engineering

- Tambahkan migration tool.
- Tambahkan smoke test minimal untuk login, verifikasi, dan CRUD produk.
- Tambahkan konfigurasi per environment.

## Kondisi Data pada Dump Saat Ini

Berdasarkan dump SQL yang ada:

- `products` berisi sekitar 13.652 data.
- `product_photos` berisi 9 data.
- `users` berisi 1 user awal.
- `company_info` berisi 1 record.

Ini mengindikasikan aplikasi dipakai untuk katalog kode produk individual dalam jumlah cukup besar, tetapi konfigurasi sistemnya sendiri masih sederhana.

## Kesimpulan

`Jalanyata` adalah aplikasi verifikasi produk berbasis PHP procedural yang pragmatis dan sudah menjalankan fungsi bisnis intinya dengan baik untuk skala kecil-menengah. Struktur saat ini cocok untuk implementasi cepat dan operasional sederhana, tetapi belum kuat untuk kebutuhan keamanan, maintainability, dan evolusi fitur jangka panjang.

Secara singkat:

- arsitektur saat ini: sederhana, langsung, efektif untuk use case inti.
- masalah utama: keamanan konfigurasi, duplikasi logika, otorisasi tidak konsisten, dan coupling antarmodul yang tinggi.
- arah perbaikan terbaik: hardening dan modularisasi bertahap, bukan rewrite penuh.

Dokumen ini menggambarkan **arsitektur aktual yang sedang berjalan** di repository saat analisa dilakukan, sehingga dapat dipakai sebagai baseline sebelum refactor berikutnya.

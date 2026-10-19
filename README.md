# MUSI RUN

Aplikasi web pendaftaran dan pengelolaan peserta MUSI RUN, dibangun dengan Laravel 12 dan PHP 8.2 atau lebih baru.

## Fitur

- Formulir pendaftaran peserta dan unggah bukti pembayaran.
- Pemeriksaan status pendaftaran oleh admin, pembuatan nomor BIB, dan notifikasi email serta WhatsApp.
- Dashboard, pengelolaan data peserta, pencatatan pengambilan RPC, dan ekspor Excel.

Daftar fitur dan lokasi implementasinya tersedia di [FITUR.md](FITUR.md).

## Persyaratan

- PHP 8.2+ beserta ekstensi PHP yang dibutuhkan Laravel.
- Composer.
- Node.js dan npm untuk membangun aset frontend.
- SQLite (konfigurasi bawaan) atau basis data lain yang didukung Laravel.

## Instalasi lokal

Dari direktori proyek:

```sh
composer install
```

Salin `.env.example` menjadi `.env` (di PowerShell dapat menggunakan `Copy-Item .env.example .env`), lalu buat application key:

```sh
php artisan key:generate
```

Atur `.env` sebelum menjalankan migrasi:

- Pilih koneksi basis data. SQLite dikonfigurasi secara bawaan; buat `database/database.sqlite` jika belum tersedia. Untuk MySQL, isi variabel `DB_*`.
- Atur `ADMIN_EMAIL` dan `ADMIN_PASSWORD` dengan kredensial admin yang kuat sebelum menjalankan seeder. Seeder juga dapat membuat akun non-admin untuk pengembangan lokal.
- Atur SMTP (`MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, dan `MAIL_FROM_ADDRESS`) agar email benar-benar dikirim. Konfigurasi bawaan `.env.example` menggunakan mail log.
- Isi `FONNTE_TOKEN` dengan token API Fonnte untuk mengaktifkan notifikasi WhatsApp. Simpan token hanya di `.env`/environment server; jangan masukkan ke source control.

Jalankan migrasi dan seeder:

```sh
php artisan migrate --seed
```

Siapkan penyimpanan bukti pembayaran dan aset frontend:

```sh
php artisan storage:link
npm install
npm run build
```

Jalankan aplikasi untuk pengembangan:

```sh
php artisan serve
```

Buka URL yang ditampilkan oleh Artisan. Halaman pendaftaran ada di `/registrasi`; halaman masuk admin ada di `/admin/login`.

## Menjalankan tes

```sh
php artisan test
```

Tes notifikasi menggunakan HTTP fake dan tidak mengirim pesan sungguhan ke Fonnte.

## Informasi operasional

- Admin meninjau bukti pembayaran dan mengubah status pendaftaran melalui halaman peserta.
- Notifikasi status dikirim ketika admin mengubah pendaftaran menjadi disetujui atau ditolak. Status tetap disimpan bila pengiriman notifikasi gagal; kegagalan dicatat di log aplikasi dan ditampilkan sebagai peringatan.
- Jalankan migrasi terbaru setiap kali memperbarui aplikasi. Jangan bagikan file `.env` karena berisi kredensial dan token.

## Deploy ke Vercel

Repository ini menyertakan konfigurasi Vercel menggunakan runtime PHP komunitas `vercel-php`, Composer untuk dependensi Laravel, dan Vite untuk aset frontend. Hubungkan repository GitHub ke Vercel dengan root directory proyek ini; konfigurasi build dan rewrite sudah ada di `vercel.json`.

Sebelum deploy, siapkan database MySQL atau PostgreSQL yang dapat diakses dari Vercel dan bucket object storage S3-compatible untuk bukti pembayaran. SQLite dan penyimpanan lokal tidak persisten di Vercel Functions.

Runtime PHP komunitas menggunakan konfigurasi `api/php.ini` untuk tidak menampilkan peringatan deprecation ke browser; error tetap dicatat di log. Konfigurasi aplikasi juga memakai konstanta SSL MySQL yang sesuai dengan versi PHP, termasuk PHP 8.5.

Tambahkan environment variables berikut di **Vercel > Project > Settings > Environment Variables**:

- `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` dengan URL deployment, dan `APP_KEY` dari `php artisan key:generate --show`.
- `VIEW_COMPILED_PATH=/tmp/laravel-views` agar Laravel dapat mengompilasi Blade pada filesystem Vercel yang read-only.
- `DB_CONNECTION` (`mysql` atau `pgsql`), `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.
- `PUBLIC_DISK_DRIVER=s3`, `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, dan `PUBLIC_DISK_URL` yang menunjuk ke URL publik bucket/CDN. Untuk penyedia S3-compatible, atur juga `AWS_ENDPOINT`; atur `AWS_USE_PATH_STYLE_ENDPOINT=true` hanya bila penyedia mewajibkannya. Bucket perlu mengizinkan pembacaan publik karena bukti pembayaran ditampilkan melalui URL file.
- `ADMIN_EMAIL` dan `ADMIN_PASSWORD` dengan kredensial admin yang kuat sebelum menjalankan seeder.
- SMTP (`MAIL_MAILER=smtp` beserta variabel `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, dan `MAIL_FROM_NAME`) untuk pengiriman email. Atur `FONNTE_TOKEN` bila notifikasi WhatsApp digunakan.

Set `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=sync`, dan `LOG_CHANNEL=stderr`. Migrasi database harus dijalankan secara terpisah, bukan pada setiap function request. Setelah menghubungkan environment production melalui Vercel CLI, jalankan:

```sh
vercel env pull .env.production
php artisan migrate --env=production --force
php artisan db:seed --class=AdminUserSeeder --env=production --force
```

Pastikan `ADMIN_EMAIL` dan `ADMIN_PASSWORD` tersedia pada environment production sebelum menjalankan seeder. Jangan jalankan seeder admin dengan nilai bawaan. Setiap upload bukti bayar menggunakan object storage ketika `PUBLIC_DISK_DRIVER=s3`; untuk pengembangan lokal, disk tetap menggunakan filesystem lokal.

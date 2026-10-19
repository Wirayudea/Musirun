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

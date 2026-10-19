# Fitur Aplikasi MUSI RUN

Dokumen ini merangkum fitur yang tersedia pada aplikasi dan lokasi implementasi utamanya.

## Halaman publik dan pendaftaran

- **Beranda dan informasi desain acara** tersedia di `/` dan `/desain`.
- **Formulir pendaftaran** tersedia di `/registrasi`. Peserta mengisi data identitas dan kontak, kategori peserta, informasi darurat, riwayat kesehatan, kategori jarak, serta mengunggah bukti pembayaran. Formulir memvalidasi data wajib dan jenis/ukuran berkas; jika bukti pembayaran berukuran lebih dari 1 MB, peringatan langsung ditampilkan saat file dipilih dan pendaftaran tidak dapat dikirim sampai file diganti.
- **Kategori jarak** mencakup 7 Kilometer dan 12 Kilometer, dengan pilihan periode harga yang ditampilkan di formulir.
- **Status awal pendaftaran** adalah menunggu pemeriksaan admin. Data pendaftaran baru tidak mendapatkan nomor BIB sampai disetujui.
- **Respons pendaftaran** mendukung pengiriman formulir biasa maupun permintaan AJAX/JSON.

Implementasi utama: [registrasi.blade.php](resources/views/registrasi.blade.php), [RegistrationController.php](app/Http/Controllers/RegistrationController.php), [Registrant.php](app/Models/Registrant.php), [routes/web.php](routes/web.php).

## Login dan pengelolaan admin

- Admin masuk melalui `/admin/login`; akun harus memiliki peran `admin`.
- **Dashboard** menampilkan jumlah pendaftar berdasarkan status dan ringkasan kategori jarak, jenis kelamin, serta ukuran jersey.
- Admin dapat melihat daftar peserta, membuka detail dan bukti pembayaran, mengubah data tertentu, serta menyetujui atau menolak pendaftaran.
- Penolakan memerlukan catatan/alasan dari panitia.
- Saat pendaftaran disetujui, sistem mengisi waktu persetujuan dan membuat nomor BIB berdasarkan jenis kelamin serta kategori jarak.
- Perubahan status ke disetujui atau ditolak memicu notifikasi email dan WhatsApp.

Implementasi utama: [AdminAuthController.php](app/Http/Controllers/AdminAuthController.php), [AdminController.php](app/Http/Controllers/AdminController.php), tampilan di [resources/views/admin](resources/views/admin).

## API aplikasi scanner RPC

- API scanner menggunakan email dan password akun admin yang sudah terdaftar; tidak perlu membuat akun scanner terpisah.
- Login API menghasilkan token Sanctum dengan izin khusus `rpc:scan`. Token itu hanya dapat digunakan untuk endpoint scan dan logout, bukan untuk akses API umum.
- Setelah deploy, jalankan `php artisan migrate` untuk membuat tabel token Sanctum.
- `POST /api/scanner/login` menerima `email`, `password`, dan opsional `device_name`; token tidak kedaluwarsa otomatis dan respons mengembalikan `expires_at: null`. Token tetap dapat dicabut melalui logout. Login dibatasi 5 percobaan per menit per alamat IP.
- `POST /api/scanner/scan` memakai header `Authorization: Bearer <token>` dan JSON `{"qr_code":"MUSI-RUN-RPC|M70001"}`. Endpoint memvalidasi peserta yang sudah disetujui lalu mencatat pengambilan RPC satu kali. Pemindaian ulang mengembalikan HTTP 409 beserta status pengambilan.
- `POST /api/scanner/logout` memakai token Bearer dan mencabut token perangkat tersebut.
- Respons pemindaian memuat nama, nomor HP (nomor telepon utama atau WhatsApp sebagai fallback), email, jenis kelamin, NIK, tanggal lahir, ukuran jersey, kategori, status RPC, waktu pengambilan, dan penanda apakah sudah pernah diambil. Nomor BIB tidak disertakan pada hasil scan.
- Contoh akses dari HP pada jaringan lokal Laragon: `http://<IP-komputer>:81/api/scanner/login`. Simpan token di penyimpanan aman Flutter dan gunakan alamat server publik saat aplikasi dipakai di luar jaringan lokal.

Contoh alur request:

```http
POST /api/scanner/login
Content-Type: application/json
Accept: application/json

{"email":"admin@example.com","password":"password-admin","device_name":"Pintu Utama"}
```

```http
POST /api/scanner/scan
Authorization: Bearer <token-dari-login>
Content-Type: application/json
Accept: application/json

{"qr_code":"MUSI-RUN-RPC|M70001"}
```

Respons scan pertama berstatus HTTP 200; peserta yang RPC-nya sudah diambil menghasilkan HTTP 409. QR yang tidak cocok formatnya menghasilkan HTTP 422, sedangkan BIB yang tidak ditemukan atau belum disetujui menghasilkan HTTP 404.

Implementasi utama: [routes/api.php](routes/api.php), [ScannerAuthController.php](app/Http/Controllers/Api/ScannerAuthController.php), [RpcScanController.php](app/Http/Controllers/Api/RpcScanController.php), [EnsureScannerToken.php](app/Http/Middleware/EnsureScannerToken.php).

## Notifikasi

- **Email persetujuan** dan **email penolakan** menggunakan templat masing-masing.
- Email persetujuan menyertakan QR Code PNG yang dibuat dari nomor BIB peserta; peserta dapat menunjukkannya saat mengambil race pack (RPC). QR Code dibuat di server dan disematkan langsung pada email.
- **WhatsApp melalui Fonnte** mengirim pesan status ke nomor peserta. Nomor lokal berawalan `0` dinormalisasi ke awalan negara `62`.
- Pesan persetujuan merangkum data peserta tanpa menyertakan nomor BIB. Pesan penolakan memuat catatan panitia.
- Kegagalan email dan WhatsApp ditangani secara terpisah. Status yang sudah disimpan tidak dibatalkan jika salah satu kanal notifikasi gagal.
- Token dibaca dari `FONNTE_TOKEN` melalui konfigurasi layanan. Kredensial email dan token harus diatur pada environment server, bukan di source code.

Implementasi utama: [RegistrantApproved.php](app/Mail/RegistrantApproved.php), [RegistrantRejected.php](app/Mail/RegistrantRejected.php), [FonnteWhatsAppService.php](app/Services/FonnteWhatsAppService.php), [services.php](config/services.php), dan templat di [resources/views/emails](resources/views/emails).

## Data peserta, RPC, dan ekspor

- Daftar peserta diterima menampilkan nomor BIB, data peserta, waktu persetujuan, dan status pengambilan RPC.
- Admin dapat menandai RPC sudah atau belum diambil; waktu pengambilan dicatat saat status berubah menjadi sudah diambil.
- Ekspor Excel tersedia untuk seluruh peserta serta daftar peserta diterima per kategori 7K dan 12K.

Implementasi utama: [AdminController.php](app/Http/Controllers/AdminController.php), [RegistrantsExport.php](app/Exports/RegistrantsExport.php), [AcceptedRegistrantsExport.php](app/Exports/AcceptedRegistrantsExport.php), [peserta_diterima.blade.php](resources/views/admin/peserta_diterima.blade.php).

## Rute utama

| URL | Fungsi |
| --- | --- |
| `/` | Beranda |
| `/desain` | Informasi desain acara |
| `/registrasi` | Formulir pendaftaran |
| `/admin/login` | Login admin |
| `/admin/dashboard` | Ringkasan dashboard admin |
| `/admin/daftar-peserta` | Daftar pendaftar/dashboard |
| `/admin/peserta` | Pengelolaan daftar peserta |
| `/admin/peserta-diterima` | Daftar peserta disetujui dan status RPC |
| `/api/scanner/login` | Login API petugas scanner |
| `/api/scanner/scan` | Validasi QR dan pencatatan pengambilan RPC |
| `/api/scanner/logout` | Pencabutan token scanner |

Rute administrasi lain untuk detail, edit, status peserta, RPC, logout, dan ekspor didefinisikan di [routes/web.php](routes/web.php).

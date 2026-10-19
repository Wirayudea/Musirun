# Panduan Implementasi Flutter — MUSI RUN RPC Scanner

Dokumen ini menjadi acuan untuk membuat aplikasi Flutter petugas pengambilan race pack (RPC) dan integrasi dengan API Laravel MUSI RUN.

## 1. Yang disediakan backend

| Method | Endpoint              | Autentikasi  | Fungsi                                      |
| ------ | --------------------- | ------------ | ------------------------------------------- |
| `POST` | `/api/scanner/login`  | Tidak        | Login menggunakan akun admin                |
| `POST` | `/api/scanner/scan`   | Bearer token | Memvalidasi QR dan mencatat pengambilan RPC |
| `POST` | `/api/scanner/logout` | Bearer token | Mencabut token perangkat saat ini           |

Token dari login tidak kedaluwarsa otomatis (`expires_at` bernilai `null`). Token memiliki izin `rpc:scan`; simpan dengan aman dan jangan tampilkan atau tulis ke log. Batas login adalah 5 percobaan per menit per alamat IP.

## 2. Base URL

Atur base URL melalui konfigurasi/environment Flutter agar mudah diganti:

| Cara menjalankan Flutter                                | Base URL pengembangan       |
| ------------------------------------------------------- | --------------------------- |
| Ponsel fisik di Wi-Fi yang sama dengan komputer Laragon | `http://192.168.1.3:81/api` |
| Android Emulator standar                                | `http://10.0.2.2:81/api`    |
| iOS Simulator                                           | `http://127.0.0.1:81/api`   |

Alamat IP komputer dapat berubah. Periksa kembali alamat Wi-Fi komputer jika ponsel tidak dapat tersambung. Pastikan Laragon aktif dan Windows Firewall mengizinkan port 81 pada jaringan lokal.

HTTP di atas hanya untuk pengembangan lokal. Untuk rilis atau akses di luar jaringan lokal, gunakan domain/server yang dapat dijangkau melalui HTTPS dan ganti base URL. Hindari mengirim kredensial admin atau token melalui HTTP pada jaringan publik.

### HTTP lokal pada Android

Build debug Android pada aplikasi `musirun_scanner` sudah mengizinkan cleartext HTTP melalui `android/app/src/debug/AndroidManifest.xml` untuk server lokal. Konfigurasi ini tidak ikut ke build rilis; gunakan HTTPS untuk produksi.

## 3. Paket Flutter

Contoh paket yang dapat digunakan:

```shell
flutter pub add http
flutter pub add flutter_secure_storage
flutter pub add mobile_scanner
```

- `http`: request JSON ke API.
- `flutter_secure_storage`: menyimpan token di penyimpanan aman perangkat.
- `mobile_scanner`: membaca QR Code dari kamera.

Minta izin kamera melalui konfigurasi Android/iOS sesuai petunjuk paket pemindai yang dipakai.

## 4. Login dan penyimpanan token

Login hanya menerima akun dengan `role = admin`. Kirim `device_name` yang berbeda untuk tiap perangkat agar token mudah dikenali saat pengelolaan:

```http
POST /api/scanner/login
Content-Type: application/json
Accept: application/json
```

```json
{
    "email": "admin@example.com",
    "password": "password-admin",
    "device_name": "Pintu Utama"
}
```

Respons sukses (`200`):

```json
{
    "message": "Login berhasil.",
    "data": {
        "token": "1|token-rahasia",
        "token_type": "Bearer",
        "expires_at": null,
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@example.com"
        }
    }
}
```

Setelah login:

1. Simpan hanya `data.token` menggunakan `FlutterSecureStorage`, bukan `SharedPreferences` biasa.
2. Jangan simpan password secara default. Jika aplikasi menyediakan opsi eksplisit untuk mengingat login, simpan email/password hanya di secure storage terenkripsi dan sediakan cara untuk menghapusnya.
3. Jangan menulis body login, header `Authorization`, atau token ke log/analytics.
4. Untuk aplikasi MUSI RUN Scanner, token sesi lokal sengaja dihapus pada setiap cold start sehingga petugas harus login kembali. Token yang terbaca saat startup juga dicabut dari server secara best-effort.
5. Jika API mengembalikan `401`, token tidak lagi valid: hapus token lokal dan arahkan pengguna untuk login kembali.

Contoh penyimpanan:

```dart
const secureStorage = FlutterSecureStorage();

await secureStorage.write(key: 'scanner_api_token', value: token);
final token = await secureStorage.read(key: 'scanner_api_token');
```

## 5. Format QR dan proses scan

QR dari email peserta berisi teks:

```text
MUSI-RUN-RPC|M70001
```

Bagian setelah `|` adalah nomor BIB. Format nomor yang diterima backend: `M` atau `F`, diikuti jarak `7` atau `12`, kemudian empat digit nomor peserta. Kirim seluruh teks hasil baca QR apa adanya ke API.

Request scan:

```http
POST /api/scanner/scan
Authorization: Bearer <token>
Content-Type: application/json
Accept: application/json
```

```json
{
    "qr_code": "MUSI-RUN-RPC|M70001"
}
```

Hasil pertama (`200`):

```json
{
    "message": "Pengambilan race pack berhasil dicatat.",
    "data": {
        "name": "Nama Peserta",
        "phone": "081234567890",
        "email": "peserta@example.com",
        "gender": "Laki-laki",
        "nik": "1234567890123456",
        "dob": "1990-05-12",
        "jersey_size": "M",
        "kategori_jarak": "7 Kilometer",
        "rpc_status": "sudah_diambil",
        "rpc_collected_at": "2026-10-13T04:00:00+07:00",
        "already_collected": false
    }
}
```

Pengambilan yang sudah tercatat (`409`):

```json
{
    "message": "Race pack peserta ini sudah pernah diambil.",
    "data": {
        "name": "Nama Peserta",
        "phone": "081234567890",
        "email": "peserta@example.com",
        "gender": "Laki-laki",
        "nik": "1234567890123456",
        "dob": "1990-05-12",
        "jersey_size": "M",
        "kategori_jarak": "7 Kilometer",
        "rpc_status": "sudah_diambil",
        "rpc_collected_at": "2026-10-13T04:00:00+07:00",
        "already_collected": true
    }
}
```

Tampilkan hasil dengan jelas:

- `200`: indikator berhasil; tunjukkan nama, jenis kelamin, nomor HP, email, NIK, tanggal lahir, ukuran jersey, kategori, dan waktu pencatatan. Jangan tampilkan nomor BIB pada hasil scan.
- `409`: indikator peringatan/duplikat; tunjukkan nama, jenis kelamin, nomor HP, email, NIK, tanggal lahir, ukuran jersey, kategori, serta waktu pengambilan sebelumnya. Jangan tampilkan nomor BIB pada hasil scan.
- `404`: QR valid secara format, tetapi peserta tidak ditemukan atau belum disetujui.
- `422`: format QR tidak valid atau input tidak lolos validasi.
- `401`: token tidak ada/tidak valid; minta login kembali.
- `403`: token bukan token scanner yang diizinkan.
- `429`: batas percobaan login tercapai; tunggu sebelum mencoba lagi.
- Gangguan jaringan/`5xx`: tampilkan pesan gagal dan pilihan mencoba lagi. Jangan menyatakan berhasil jika server belum mengonfirmasi.

Backend mengunci data peserta saat mencatat scan, sehingga dua perangkat yang memindai peserta hampir bersamaan tetap akan menghasilkan satu pencatatan sukses dan satu respons duplikat.

### Cegah request ganda dari kamera

Pemindai dapat mendeteksi QR yang sama pada banyak frame. Di Flutter, hentikan sementara pemindaian atau gunakan flag `_isSubmitting` sebelum mengirim request. Aktifkan kembali pemindai setelah respons diterima atau setelah petugas menutup hasil scan. Jangan mengirim request scan yang sama berulang kali dalam satu callback kamera.

Alur antarmuka yang disarankan:

1. Halaman utama menampilkan status login dan tombol “Mulai Scan”.
2. Minta izin kamera, lalu tampilkan kamera dengan bingkai panduan QR.
3. Ambil `barcode.rawValue`; jika kosong, tampilkan instruksi untuk mencoba lagi.
4. Kirim satu request scan dan tampilkan loading agar QR tidak diproses berulang.
5. Tampilkan hasil sukses/duplikat/error dan tombol untuk melanjutkan scan berikutnya.
6. Sediakan tombol logout yang memanggil API, menghapus token lokal, dan kembali ke halaman login.

## 6. Logout

Saat petugas memilih logout, panggil:

```http
POST /api/scanner/logout
Authorization: Bearer <token>
Accept: application/json
```

Respons sukses (`200`):

```json
{
    "message": "Logout berhasil."
}
```

Setelah request logout, hapus token lokal dan tutup halaman scanner. Jika perangkat offline, hapus token lokal tetap dilakukan; token server belum tercabut sampai bisa dicabut dari sisi server. Jika perangkat hilang, admin perlu menghapus baris token perangkat tersebut dari tabel `personal_access_tokens`.

### Sesi dan kamera aplikasi MUSI RUN Scanner

Aplikasi meminta login kembali pada setiap cold start, tetapi tidak melakukan logout otomatis karena tidak aktif. Jika proses aplikasi dihentikan paksa, token lokal dibuang pada startup berikutnya. Logout manual mencoba mencabut token pada server.

Form login menyediakan opsi **Ingat email dan password**. Jika dipilih, kredensial disimpan di secure storage perangkat dan diisikan otomatis pada login berikutnya; token sesi tetap tidak dipulihkan. Hindari mengaktifkan opsi ini pada perangkat bersama. Jika perangkat offline saat logout, pengguna tetap keluar dari aplikasi tetapi pencabutan token server belum dapat dipastikan sampai koneksi pulih.

Kamera scanner mati secara default. Petugas menyalakannya dengan tombol **Nyalakan Kamera untuk Scan** dan dapat mematikannya kapan saja. Setelah QR terbaca dan hasil diterima, kamera tetap aktif agar petugas dapat langsung memindai peserta berikutnya. Kamera dihentikan saat aplikasi masuk ke background dan hanya dilanjutkan kembali jika sebelumnya memang sedang aktif.

## 7. Penanganan error login

- Kredensial salah atau akun bukan admin: `422`, pesan validasi berada pada `errors.email`.
- Login terlalu sering: `429`.
- Gangguan koneksi: tampilkan pesan koneksi, jangan menghapus akun atau mengubah status RPC.

Contoh bentuk respons validasi:

```json
{
    "message": "Email atau password admin tidak valid.",
    "errors": {
        "email": ["Email atau password admin tidak valid."]
    }
}
```

Jangan mencoba login otomatis terus-menerus karena endpoint dibatasi lima percobaan per menit.

## 8. Checklist sebelum digunakan

- [ ] Tabel Sanctum `personal_access_tokens` sudah tersedia pada database Laravel.
- [ ] Aplikasi dapat login dengan akun `admin`; akun biasa tidak memiliki akses.
- [ ] Token disimpan dengan secure storage dan tidak muncul di log.
- [ ] Token ditambahkan sebagai Bearer pada scan/logout.
- [ ] Scan QR valid mencatat RPC di sistem admin.
- [ ] Scan ulang menampilkan hasil duplikat tanpa menimpa waktu pengambilan pertama.
- [ ] QR peserta yang tidak disetujui tidak tercatat.
- [ ] Izin kamera dan perilaku penolakan izin diuji di Android/iOS.
- [ ] URL produksi menggunakan HTTPS; konfigurasi HTTP cleartext lokal hanya untuk pengembangan.

## 9. Referensi backend

- Route API: [routes/api.php](routes/api.php)
- Login dan logout: [ScannerAuthController.php](app/Http/Controllers/Api/ScannerAuthController.php)
- Validasi QR dan pencatatan RPC: [RpcScanController.php](app/Http/Controllers/Api/RpcScanController.php)
- Pembatasan akses token: [EnsureScannerToken.php](app/Http/Middleware/EnsureScannerToken.php)
- QR yang disertakan ke email peserta: [registrant-approved.blade.php](resources/views/emails/registrant-approved.blade.php)

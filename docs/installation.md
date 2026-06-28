# Panduan Instalasi Project — Mekar Pharmacy

Ikuti panduan berikut untuk memasang dan menjalankan project **Mekar Pharmacy** di lingkungan pengembangan lokal dari nol.

---

## 1. Persyaratan Sistem (System Requirements)

Sebelum memulai, pastikan perangkat Anda telah terpasang perangkat lunak dengan versi berikut:

* **PHP**: $\ge$ `8.3` (Pastikan ekstensi PHP seperti `pdo_mysql`, `mbstring`, `openssl`, `xml`, dan `zip` aktif).
* **Composer**: $\ge$ `2.0` (Untuk mengelola package PHP).
* **Node.js**: $\ge$ `18.0` (Disertai `npm` untuk kompilasi asset frontend).
* **MySQL**: $\ge$ `8.0` atau **MariaDB** $\ge$ `10.4`.
* **Git**: Untuk clone repository.

---

## 2. Langkah-Langkah Instalasi (Installation Steps)

### Langkah 1: Clone Repository
Buka terminal/command prompt, lalu jalankan perintah berikut:
```bash
git clone https://github.com/bobvincen/Mekar-Project.git
cd Mekar-Project
```

### Langkah 2: Install Dependensi PHP (Composer)
Unduh package php yang terdaftar pada `composer.json`:
```bash
composer install
```

### Langkah 3: Install Dependensi JavaScript (NPM)
Unduh package frontend yang dibutuhkan oleh Vite & Tailwind CSS:
```bash
npm install
```

### Langkah 4: Setup Environment File
Salin file konfigurasi environment `.env.example` menjadi `.env`:
* **Bash / Linux / macOS**:
  ```bash
  cp .env.example .env
  ```
* **Windows (PowerShell)**:
  ```powershell
  copy .env.example .env
  ```

### Langkah 5: Generate Application Key
Buat key enkripsi unik untuk keamanan aplikasi Laravel Anda:
```bash
php artisan key:generate
```

### Langkah 6: Konfigurasi Database di `.env`
Buka file `.env` yang baru dibuat menggunakan text editor Anda, lalu sesuaikan koneksi database MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mekar_project
DB_USERNAME=root
DB_PASSWORD=
```
*Catatan: Pastikan Anda sudah membuat database kosong bernama `mekar_project` di server MySQL lokal Anda.*

### Langkah 7: Migrasi Database & Seeding
Jalankan migrasi tabel database beserta data seeder bawaan (untuk role, permission, user demo, dan katalog obat awal):
```bash
php artisan migrate --seed
```
*Perintah di atas akan menjalankan `RolePermissionSeeder`, `UserSeeder`, `MarketplaceSeeder`, `PelangganSeeder`, `ResepDokterSeeder`, dan `TransaksiSeeder` secara berurutan.*

### Langkah 8: Buat Tautan Storage (Storage Link)
Aplikasi menyimpan file unggahan resep dokter serta file gambar obat ke folder `storage/app/public`. Agar berkas-berkas ini dapat diakses oleh browser, buat tautan symbolic link ke folder `public`:
```bash
php artisan storage:link
```

---

## 3. Akun Demo Bawaan (Default Demo Accounts)

Setelah proses seeding selesai, Anda dapat masuk ke dalam sistem menggunakan akun demo berikut:

| Peran (Role) | Email | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@mekar.com` | `password` | Mengelola Master Data, User, Role, Permission |
| **Kasir** | `kasir@mekar.com` | `password` | Mengelola Transaksi Kasir, Melihat Laporan |
| **Apoteker** | `apoteker@mekar.com` | `password` | Memeriksa Stok Obat, Verifikasi Resep Dokter |
| **Pelanggan** | `pelanggan@mekar.com` | `password` | Belanja Online di Marketplace & Upload Resep |

---

## 4. Menjalankan Aplikasi di Lokal (Running the Application)

Untuk menjalankan server lokal, Anda harus mengaktifkan dua server secara paralel:

1. **Jalankan Laravel Web Server**:
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di alamat: [http://127.0.0.1:8000](http://127.0.0.1:8000).

2. **Jalankan Vite Asset Bundler (Kompilasi CSS/JS)**:
   ```bash
   npm run dev
   ```
   Server ini digunakan untuk mengompilasi assets Tailwind CSS secara real-time selama proses pengembangan.

---

## 5. Konfigurasi WhatsApp Notifikasi (Fonnte API)

Aplikasi Mekar Pharmacy memiliki fitur notifikasi otomatis ke WhatsApp Admin untuk pesanan masuk dan unggahan resep dokter. Fitur ini menggunakan layanan **Fonnte API**.

### Langkah Konfigurasi:
1. Daftar atau masuk ke dashboard Fonnte di [https://fonnte.com](https://fonnte.com).
2. Tambahkan perangkat WhatsApp Anda pada menu **Devices** dan lakukan scan QR Code sampai statusnya **Connected**.
3. Salin **API Token** dari dashboard Fonnte Anda.
4. Buka file `.env` proyek Anda, lalu isi konfigurasi berikut:
   ```env
   FONNTE_TOKEN=isi_dengan_token_fonnte_anda
   FONNTE_BASE_URL=https://api.fonnte.com
   FONNTE_ADMIN_PHONE=6282240432990
   ```
5. Restart server local Laravel Anda agar konfigurasi baru pada `.env` dapat dimuat oleh aplikasi.
6. Uji koneksi integrasi WhatsApp Anda dengan menjalankan perintah Artisan:
   ```bash
   php artisan whatsapp:test
   ```

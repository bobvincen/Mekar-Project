1. Judul Proyek

# Mekar Project

2. Deskripsi Proyek

# Tujuan Aplikasi

Sistem Informasi Apotek Mekar berbasis website dibuat untuk membantu pengelolaan operasional apotek secara terintergrasi dan terkomputerisasi.

# Masalah yang Diselesaikan

Sebelum adanya sistem, apotek sering menghadapi beberapa kendala, yaitu:

# 1. Pencatatan data masih manual --> Data obat, supplier, dan pelanggan rentan hilang atau salah catat

# 2. Kesulitan memantau obat kadaluarsa --> Stok habis atau menumpuk karena tidak ada pemantauan yang terstruktur

# 3. Sulit mendeteksi obat kadaluarsa --> Obat yang mendekati masa kadaluarsa berisiko terlewat

# 4. Proses transaksi kurang efisien --> Perhitungan total pembayaran dan kembalian dilakukan secara manual

# 5. Pembuatan laporan memakan waktu --> Laporan penjualan harus direkap secara manual sehingga rentan kesalahan

3. Fitur Utama

## Features

- Autentikasi
- CRUD Data
- Checkout Online
- Laporan
- Transaksi

4. Teknologi yang Digunakan

## Tech Stack

- Laravel
- MySQL
- Tailwind CSS

5. Instalasi Singkat

### 1. Clone Repository

```bash
git clone https://github.com/bobvincen/Mekar-Project
cd Mekar-Project
```

### 2. Install Dependency Backend

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database

- Buat database dengan nama:

```
mekar_project
```

- Edit File '.env':

```
DB_DATABASE=mekar_project
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. Install Frontend

```bash
npm install
npm run dev
```

### 7. Jalankan Server

```bash
php artisan serve
```

Akses di browser

```
http://127.0.0.1:8000/
```

7. Tim Pengembang
   Nama Anggota Kelompok:

### 1. Nabil Okta Pratama

### 2. M. Habibi Ariski

### 3. Resti Febriani

### 4. Rifa Afdela

### 5. Mufti Ibrahim

---

# 📘 Mekar-Project – Aturan Kerja Repository

## 🌿 Struktur Branch

- `main` → versi stabil (JANGAN DIUBAH SEMBARANGAN)
- `develop` → tempat gabung semua fitur
- `feature/...` → tempat kerja masing-masing anggota

---

## 👥 Pembagian Branch Tim

Setiap anggota menggunakan branch masing-masing:

- `feature/auth-login`
- `feature/kategori-crud`
- `feature/obat-crud`
- `feature/transaksi-penjualan`

---

## 🔄 Workflow Tim

1. Ambil update terbaru:

```
git checkout develop
git pull origin develop
```

2. Masuk ke branch masing-masing:

```
git checkout feature/nama-fitur
```

3. Coding, lalu commit:

```
git add .
git commit -m "feat: deskripsi perubahan"
```

4. Push:

```
git push origin feature/nama-fitur
```

5. Buat Pull Request ke `develop`

---

## 📜 Aturan Commit

### Format:

```
<tipe>: <deskripsi>
```

### Jenis commit:

- `feat:` → fitur baru
- `fix:` → perbaikan bug
- `refactor:` → perbaikan struktur kode
- `docs:` → dokumentasi
- `style:` → tampilan/UI
- `chore:` → konfigurasi/setup

### Contoh:

```
feat: menambahkan fitur login
fix: memperbaiki error transaksi
refactor: merapikan controller obat
```

---

## ❌ Larangan

- Tidak boleh commit ke `main`
- Tidak boleh commit ke `develop`
- Tidak boleh commit dengan pesan tidak jelas (contoh: "update", "fix")

---

## 👑 Tugas Lead Programmer

- Review semua Pull Request
- Merge ke `develop`
- Menjaga struktur repo tetap rapi

---

## 🎯 Tujuan

- Project terstruktur dan rapi
- Mudah dikerjakan secara tim
- Mudah dipresentasikan ke dosen/client

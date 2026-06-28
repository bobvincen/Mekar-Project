# Dokumentasi Fitur — Mekar Pharmacy

Dokumen ini menjelaskan seluruh fitur dan modul yang telah diimplementasikan dalam aplikasi **Mekar Pharmacy**.

---

## 1. Autentikasi (Authentication)

### Tujuan
Membatasi akses ke dalam sistem utama apotek berdasarkan akun pengguna yang terdaftar untuk menjamin keamanan data.

### Aktor
* Admin Apotek
* Kasir / Staff
* Apoteker
* Pelanggan / Member

### Detail Implementasi
* **Laravel Breeze**: Menyediakan fondasi login, registrasi, lupa password, verifikasi email, serta manajemen profil.
* **Form Login & Register**: Dilengkapi visual error state (border input merah & background pink soft) serta pesan kesalahan dalam bahasa Indonesia.
* **Keamanan**: Password dienkripsi menggunakan algoritma hashing bawaan Laravel (`bcrypt`).

---

## 2. Dashboard Multi Role

### Tujuan
Menampilkan ringkasan data statistik sistem yang relevan sesuai dengan peran masing-masing aktor.

### Aktor & Tampilan Dashboard
1. **Admin / Kasir Dashboard**:
   * Statistik ringkasan (Total Penjualan, Total Item Obat, Kategori Obat, dan Jumlah Pelanggan Aktif).
   * Grafik visualisasi dinamis **Sales Summary** menggunakan **Chart.js** yang ditarik dari API data penjualan per bulan.
   * Tabel daftar transaksi offline kasir terbaru.
   * Alert daftar obat dengan stok kritis (stok $\le$ 20 pcs).
2. **Apoteker Dashboard**:
   * Statistik total obat terdaftar dan resep dokter terunggah.
   * Alert stok kritis (stok $\le$ 20 pcs) dan daftar obat dengan stok terendah.
   * Tabel daftar resep dokter masuk yang berstatus `pending` (menunggu verifikasi).

---

## 3. Role & Permission Management (RBAC)

### Tujuan
Mengatur hak akses pengguna secara dinamis dan aman untuk mencegah akses tidak sah ke fitur internal.

### Aktor
* Admin

### Detail Implementasi
* **Spatie Laravel Permission (v8.0)**: Mengontrol otorisasi berbasis hak akses (`permissions`) dan peran (`roles`).
* **CRUD Role**: Membuat role baru, mengedit nama role non-sistem, dan menetapkan kumpulan permission yang diizinkan secara visual menggunakan checkbox.
* **CRUD Permission**: Mendaftarkan permission baru dalam guard `web` untuk memproteksi modul rute tertentu.
* **CRUD User**: Mendaftarkan akun user baru, mengganti password, dan menetapkan satu role aktif yang tersinkronisasi otomatis dengan Spatie Role. Kolom `role` pada tabel `users` disinkronkan sebagai ENUM (`'admin'`, `'kasir'`, `'apoteker'`, `'pelanggan'`) untuk mengontrol redirect dashboard dan middleware otorisasi.
* **Middlewares**: Rute dilindungi di tingkat rute menggunakan middleware alias: `admin`, `kasir`, `pelanggan`, `admin_or_kasir`, `apoteker`, `role`, dan `permission`.

---

## 4. Manajemen Master Data (CRUD Modules)

### Aktor
* Admin

### Modul CRUD yang Tersedia
1. **Kategori Obat**:
   * Mengelompokkan jenis obat.
   * Form tambah menggunakan modal dinamis di halaman indeks yang otomatis tetap terbuka (`fixed`) jika terjadi kegagalan validasi.
2. **Supplier**:
   * Mengelola kontak penyuplai obat (Nama, Telepon, Email, Alamat, Kontak PIC, Kota, Keterangan).
   * Kolom kontak (alamat, telepon, email) bersifat `nullable` untuk mendukung alur registrasi cepat dari menu Obat.
   * Sistem pelacakan status kelengkapan data (`Lengkap` jika alamat, telepon, dan email terisi; `Belum Lengkap` jika ada yang kosong) yang ditampilkan menggunakan badge visual (hijau untuk Lengkap, oranye berkedip untuk Perlu Dilengkapi).
3. **Pelanggan**:
   * Mengelola data pelanggan reguler dan staff apotek.
4. **Obat**:
   * Mengelola katalog obat apotek (Kode Obat, Kategori, Supplier, Stok, Harga Jual, Tanggal Kadaluarsa, Deskripsi).
   * Kolom **Tanggal Kadaluarsa** bersifat *wajib diisi (required)* untuk menyesuaikan dengan constraint database `NOT NULL`.

---

## 5. Transaksi Penjualan Offline (Kasir)

### Tujuan
Memfasilitasi transaksi pembelian langsung di kasir fisik apotek secara cepat dan aman.

### Aktor
* Admin
* Kasir / Staff

### Alur Kerja & Fitur Utama
1. **Multi-Item Dinamis**: Penambahan dan penghapusan baris obat langsung di sisi client secara dinamis menggunakan JavaScript.
2. **Validasi Stok Real-time**: 
   * Client-side: Menampilkan batas stok obat dan membatasi input jumlah.
   * Server-side: Melakukan pengecekan stok di controller. Jika jumlah input melebihi stok tersedia, form dikembalikan dengan pesan error ramah pengguna (misalnya: *"Stok obat [Nama] tidak mencukupi"*).
3. **Penyimpanan Transaksi**:
   * Stok obat otomatis berkurang setelah transaksi disimpan.
   * Total belanja dan nominal kembalian dihitung secara otomatis (menampilkan warning jika uang pembayaran kurang).
4. **Restorasi Old Inputs**: Apabila validasi backend gagal (misalnya pengguna lupa mengisi jumlah bayar), seluruh baris obat beserta jumlah kuantitas yang telah diinput sebelumnya akan dipulihkan secara otomatis via script Blade dan JS.
5. **Update & Delete Stok Safety**: 
   * Jika transaksi diedit, penyesuaian stok dihitung berdasarkan selisih kuantitas baru dan lama.
   * Jika transaksi dihapus, stok obat dikembalikan (di-restore) secara otomatis.

---

## 6. Unggah & Verifikasi Resep Dokter

### Tujuan
Memungkinkan pelanggan mengunggah foto resep dokter mereka dari rumah agar dikonfirmasi dan disiapkan oleh apoteker.

### Alur Kerja
1. **Pelanggan (Unggah)**:
   * Mengisi form nama, nomor WhatsApp, catatan opsional, dan mengunggah berkas foto resep (JPEG, PNG, JPG, maks. 5MB).
   * Setelah dikirim, data disimpan di server dan pelanggan diarahkan secara otomatis ke tautan WhatsApp API Admin yang memuat detail pesanan.
2. **Admin (Daftar & Hapus)**:
   * Melihat tabel resep dokter masuk dan memiliki otoritas menghapus catatan resep dokter.
3. **Apoteker (Verifikasi)**:
   * Membuka detail foto resep dokter secara utuh.
   * Melakukan verifikasi dengan memilih tindakan (Setujui / Tolak) dan memberikan catatan verifikasi apoteker (misalnya aturan minum obat atau alasan penolakan).

---

## 7. Pesanan Online (Marketplace & Checkout)

### Tujuan
Menyediakan portal e-commerce sederhana bagi pelanggan untuk memesan obat secara online.

### Alur Kerja
1. **Katalog Produk (Public)**: Pengunjung dapat melihat daftar obat, detail harga, stok, deskripsi, dan menyaring berdasarkan kategori.
2. **Shopping Cart**: Menambahkan obat ke keranjang belanja (disimpan dalam session) serta mengubah kuantitas atau menghapus item.
3. **Checkout Form**:
   * Pelanggan mengisi nama penerima, nomor WhatsApp, metode pengambilan (Ambil di Apotek / Kirim ke Alamat), koordinat peta (Latitude, Longitude), jarak, dan ongkos kirim otomatis.
   * Setelah checkout disubmit, sistem menyimpan transaksi dengan status **"Menunggu Konfirmasi"**.
   * Keranjang belanja dikosongkan dan pelanggan diarahkan ke WhatsApp Admin dengan rincian struk lengkap untuk konfirmasi manual.
4. **Otoritas Admin (AdminTransaksiOnlineController)**:
   * Admin mengelola pesanan online masuk di menu `/transaksi-online`.
   * Admin dapat mengubah status pesanan (`Menunggu Konfirmasi`, `Diproses`, `Dikirim`, `Selesai`, `Dibatalkan`).
   * **Stok Terpotong Otomatis**: Pengurangan stok obat baru terjadi ketika pesanan online diubah statusnya menjadi **"Selesai"**. Jika status diubah dari **"Selesai"** menjadi **"Dibatalkan"**, stok obat akan dikembalikan otomatis.

---

## 8. Laporan Penjualan & Ekspor Laporan (Excel & PDF)

### Tujuan
Menyajikan rangkuman performa omzet penjualan apotek secara keseluruhan dan memfasilitasi kebutuhan laporan fisik serta analisis data dinamis.

### Fitur Utama
* **Filter Rentang Tanggal**: Menyaring data transaksi penjualan berdasarkan periode tanggal tertentu.
* **Widget Ringkasan Dinamis**: Menghitung secara real-time **Total Transaksi**, **Total Pendapatan (Omzet)**, dan **Rata-rata Pendapatan per Transaksi** sesuai filter tanggal yang dipilih.
* **Ekspor Excel (.xlsx)**: Mengunduh data laporan penjualan berformat Microsoft Excel yang diatur secara profesional (auto-width kolom, bold styling header/footer, format mata uang Rupiah).
* **Ekspor PDF**: Mengunduh berkas laporan dalam format cetak PDF (A4 Landscape) lengkap dengan kop apotek, tabel transaksi terperinci, dan rekapitulasi total pendapatan.
* **Keamanan Rute**: Modul laporan ini diproteksi ketat dan hanya dapat diakses oleh pengguna dengan role `admin` atau `kasir`.

---

## 9. Sistem Notifikasi (Fonnte API) & Validasi Form

### Detail Implementasi
* **Notifikasi WhatsApp Backend (Fonnte API)**: Notifikasi dikirimkan secara otomatis dari backend (server-side) saat pesanan baru dibuat (checkout) atau resep dokter diunggah.
  * Menggunakan `FonnteService` dengan Laravel HTTP Client (form multipart POST request).
  * Toleransi Kegagalan (Fault Tolerance): Jika Fonnte API offline atau terjadi timeout, transaksi tetap tersimpan dengan sukses dan pesan kegagalan dicatat secara aman tanpa memutus alur pengguna (graceful fallback).
  * Keamanan Konfigurasi: Token dan parameter API dibaca secara aman dari file environment `.env` (`FONNTE_TOKEN`, `FONNTE_BASE_URL`, `FONNTE_ADMIN_PHONE`).
  * Fallback Client-side: Tautan manual ke `https://wa.me/` tetap disediakan bagi pelanggan untuk mengirim pesan secara manual jika diinginkan.
* **Fitur Uji & Diagnostik WhatsApp**:
  * Command Artisan `php artisan whatsapp:test` untuk menguji pengiriman pesan uji dari baris perintah.
  * Halaman Diagnostik Khusus Admin di `/admin/whatsapp-diagnostic` untuk melihat detail pembacaan konfigurasi token, status koneksi API, log respons terakhir, dan tombol uji kirim pesan instan.
* **Flash Alert**: Menggunakan session flash data Laravel untuk menampilkan alert sukses/gagal di bagian atas layout view setelah operasi CRUD.
* **Validasi Form**:
  * Seluruh form di dalam aplikasi telah diaudit dari white page atau DB exception.
  * Menampilkan pesan kesalahan berbahasa Indonesia yang jelas tepat di bawah input field.
  * Menyorot border input dengan warna merah (`border-red-500`) dan background merah muda (`bg-red-50`) untuk kemudahan navigasi mata pengguna saat terjadi error input.
  * Mempertahankan data masukan lama (`old()`) agar pengguna tidak perlu mengisi ulang seluruh form dari awal.

---

## 10. Manajemen Gambar Obat & Import Batch ZIP

### Aktor
* Admin

### Detail Implementasi
* **Gambar Obat Opsional**: File gambar obat dapat diunggah melalui form tambah atau edit obat. Gambar bersifat opsional (`nullable`), disimpan di `storage/app/public/obat/` menggunakan nama file unik, dan direferensikan di kolom `image_path` pada tabel `obats`.
* **Pratinjau Client-Side**: JavaScript secara real-time menampilkan pratinjau gambar yang dipilih oleh pengguna sebelum form dikirimkan.
* **Manajemen Hapus/Ganti Gambar**: Pada form edit obat, pengguna dapat melihat gambar saat ini dan memilih untuk menggantinya dengan berkas baru atau menghapusnya secara permanen (menghapus berkas dari disk dan mereset nilai kolom database menjadi `NULL`).
* **Import Batch dengan ZIP Gambar & Interactive Supplier Verification**:
  * Pengguna dapat mengunggah file Excel bersamaan dengan file ZIP gambar obat.
  * **Template Terperinci**: Template Excel mendukung kolom data kontak supplier opsional (`nama_kontak`, `telepon_supplier`, `email_supplier`, `kota`, `alamat_supplier`, `keterangan_supplier`).
  * **Halaman Preview Import Interaktif**: Menampilkan data impor sebelum disimpan permanen ke database, dibagi menjadi dua panel:
    * **Panel 1 (Preview Data Obat)**: Menampilkan detail obat valid yang akan diimpor.
    * **Panel 2 (Data Supplier)**: Mengidentifikasi supplier unik secara case-insensitive dari data Excel, mencocokkan statusnya, dan menampilkan kartu formulir untuk diisi:
      * `✅ Supplier Ditemukan`: Data kontak sudah lengkap (ditampilkan read-only).
      * `⚠ Supplier Baru`: Data belum ada di database, memunculkan form input detail kontak secara opsional.
      * `⚠ Data Supplier Belum Lengkap`: Data supplier terdaftar tetapi kontaknya belum lengkap, menampilkan form kontak dengan border warning pada kolom kosong.
  * **Validasi Fleksibel**: Hanya nama supplier yang wajib diisi. Input email & telepon divalidasi formatnya jika diisi oleh pengguna.
  * **Keamanan Transaksi & Anti-Duplikasi**: Proses impor dijalankan di dalam blok `DB::beginTransaction()` untuk mencegah kegagalan data parsial. Supplier yang dirujuk berulang dalam satu Excel hanya akan dibuat sekali.
  * Seluruh berkas temporer ZIP diekstraksi dan dibersihkan secara otomatis setelah proses impor selesai.

---

## 11. Fitur Show/Hide Password

### Aktor
* Admin Apotek, Kasir / Staff, Apoteker, Pelanggan / Member

### Detail Implementasi
* **Toggling Visibilitas**: Tombol berikon mata (Eye / Eye Slash) ditambahkan di sisi kanan setiap field input password dan konfirmasi password. Klik ikon ini merubah atribut input `type="password"` menjadi `type="text"` (menampilkan teks password) dan sebaliknya.
* **JavaScript Ringan Global**: Script vanilla JS didelegasikan pada root `document` di layouts utama (`app.blade.php` dan `guest.blade.php`), secara otomatis mengendalikan perilaku seluruh tombol toggler berkelas `toggle-password` secara dinamis tanpa mengganggu validasi atau loading.
* **Aksesibilitas**: Tombol dilengkapi atribut `aria-label` yang berganti dinamis antara `"Tampilkan Password"` dan `"Sembunyikan Password"`.
* **Desain Responsif**: Ikon terintegrasi di dalam input dengan padding yang telah disesuaikan agar teks password tidak tumpang tindih dengan ikon.

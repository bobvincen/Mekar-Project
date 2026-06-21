# Changelog

Semua perubahan penting pada project **Mekar Pharmacy** akan didokumentasikan di file ini.

---

## [v1.0.0] - 2026-06-19

### Added
* **Sistem RBAC (Role-Based Access Control)**:
  * Integrasi package `spatie/laravel-permission` versi `^8.0` untuk manajemen peran dinamis.
  * CRUD Manajemen User, CRUD Manajemen Role, dan CRUD Manajemen Permission untuk Admin.
  * Pembatasan hak akses berbasis middleware alias pada level rute/URL (`admin`, `kasir`, `pelanggan`, `admin_or_kasir`, `apoteker`).
* **Fitur & Dashboard Apoteker**:
  * Dashboard Apoteker yang memuat ringkasan resep baru, daftar obat stok rendah, dan tabel resep pending.
  * Halaman Ketersediaan Obat khusus untuk Apoteker dengan fitur filter stok kritis ($\le$ 20 pcs).
  * Modul verifikasi resep dokter (Setujui / Tolak disertai kolom catatan instruksi/alasan penolakan).
* **Fitur Marketplace & Pesanan Online**:
  * Katalog obat publik dengan pencarian, detail deskripsi, dan filter kategori.
  * Modul keranjang belanja (shopping cart) berbasis session.
  * Form checkout dengan input alamat pengiriman, koordinat peta (Latitude/Longitude), jarak, dan estimasi ongkir otomatis.
  * Integrasi pengalihan otomatis ke WhatsApp API Admin memuat detail invoice pemesanan obat.
  * Panel kelola pesanan online (`AdminTransaksiOnlineController`) untuk memproses, mengirim, menyelesaikan, atau membatalkan pesanan.
* **Aesthetika & Chart Dinamis**:
  * Visualisasi data penjualan per bulan berupa grafik garis dinamis menggunakan **Chart.js** pada dashboard Admin.
  * Penandaan input wajib dengan tanda bintang merah (`*`) pada form.
  * Penambahan modal tambah kategori obat yang tetap terbuka (`fixed`) saat terjadi error validasi.

### Changed
* **Overhaul Validasi Form**:
  * Penerjemahan seluruh pesan kesalahan input validasi ke dalam bahasa Indonesia di seluruh controller.
  * Penerapan border merah (`border-red-500`) dan background soft pink (`bg-red-50`) di setiap input field yang mengalami error.
  * Pemulihan data masukan lama (`old()`) pada seluruh form agar tidak perlu mengetik ulang jika terjadi kegagalan kirim.
  * Pemulihan dinamis baris obat di form Transaksi Kasir menggunakan data `old('obat_id')`.
  * Mengubah validasi `tanggal_kadaluarsa` pada Obat dari `'nullable|date'` menjadi `'required|date'` karena constraint database bersifat `NOT NULL`.

### Fixed
* **Pencegahan Stok Negatif**:
  * Penambahan validasi stok obat di backend `TransaksiController` saat simpan dan edit transaksi kasir.
  * Perhitungan stok offset (kuantitas baru dibandingkan kuantitas transaksi lama) saat edit transaksi untuk menghindari false-positives stok tidak cukup.
  * Penambahan pengurangan stok obat otomatis hanya jika status pesanan online diubah menjadi **"Selesai"**, serta pengembalian stok jika dibatalkan.
* **Visual Bug Sidebar**:
  * Perbaikan bug menu "Transaksi" ikut aktif menyala saat halaman "Pesanan Online" dibuka (mengubah rute checking menggunakan `request()->routeIs('transaksi.*')` secara spesifik).
* **IDE & Import Warnings**:
  * Perbaikan undefined class `Rules\Password` di `UserController.php` dengan mengimpor namespace yang sesuai.

---

## [v0.1.0] - 2026-05-15

### Added
- Setup repository GitHub.
- Setup Laravel Project.
- Konfigurasi database MySQL.
- Pembuatan tabel users.
- Pembuatan tabel kategoris.
- Pembuatan tabel suppliers.
- Pembuatan tabel obats.
- Pembuatan tabel pelanggans.
- Pembuatan tabel transaksis.
- Pembuatan tabel detail_transaksis.

### Changed
- Penyesuaian struktur database sesuai kebutuhan sistem apotek.

### Fixed
- Perbaikan relasi foreign key pada tabel transaksis.
- Perbaikan struktur tabel users.

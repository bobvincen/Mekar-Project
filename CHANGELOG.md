# Changelog

Semua perubahan penting pada project **Mekar Pharmacy** akan didokumentasikan di file ini.

---

## [v1.2.0] - 2026-06-28

### Added
* **Fitur Konsultasi Apoteker**:
  * Integrasi layanan konsultasi langsung via WhatsApp dengan apoteker.
  * Penambahan section khusus di homepage dan floating WhatsApp button.
  * Sistem pencatatan log (`konsultasi_log`) untuk merekam metrik interaksi (sumber, timestamp, IP).
  * Widget statistik harian dan bulanan konsultasi pada dashboard admin.
* **Notifikasi Obat Kadaluarsa**:
  * Sistem pelacakan otomatis untuk obat yang masa kadaluarsanya tersisa kurang dari 30 hari.
  * Menampilkan peringatan obat secara langsung di panel dashboard admin.
* **Navbar Logo Branding & UI Improvements**:
  * Menambahkan logo resmi Mekar Pharmacy pada navigation bar untuk memperkuat branding.
  * Fitur ulasan (review) web untuk meningkatkan interaksi pengguna.
  * Fungsionalitas scroll-spy pada navbar menggunakan Intersection Observer untuk perpindahan active state dinamis ("Beranda" & "Konsultasi Apoteker").

### Changed
* **Sistem Harga & Checkout Marketplace**:
  * Menghapus logika diskon dan voucher lama (legacy) guna menyederhanakan dan menstabilkan perhitungan harga (Subtotal + Ongkir = Total).
  * Memastikan state reaktivitas AlpineJS selalu tersinkronisasi secara real-time dengan OpenRouteService API saat checkout.
* **Tampilan Halaman Admin & Web Utama**:
  * Mengubah dan memodernisasi gaya UI menggunakan Tailwind CSS untuk mencapai hierarki visual premium.
  * Menyempurnakan grafik ringkasan penjualan pada dashboard admin.

### Fixed
* **Spatie Permission Error**:
  * Menyelesaikan isu `Trait "Spatie\Permission\Traits\HasRoles" not found` akibat konflik dependensi versi.
* **Konflik Manajemen Role**:
  * Memperbaiki sistem role management dan potensi konflik pada kode.
* **Navbar Active State & Routing**:
  * Memperbaiki kendala tampilan Navbar agar selalu reaktif mengikuti scroll pengguna tanpa sekadar bergantung pada URL routes.

---

## [v1.1.0] - 2026-06-21

### Added
* **Fitur Gambar Obat**:
  * Menambahkan kolom `image_path` (nullable string) pada tabel `obats` melalui migrasi database terpisah.
  * Menambahkan accessor `image_url` pada model `Obat` untuk mengambil path publik asset gambar atau menampilkan default placeholder.
  * Form Tambah Obat: input upload file gambar dengan pratinjau instan di sisi client menggunakan JavaScript.
  * Form Edit Obat: menampilkan gambar terunggah saat ini, opsi mengganti gambar dengan berkas baru, dan opsi menghapus gambar secara permanen dari server dan database.
  * Halaman Indeks Obat: kolom gambar dengan visualisasi thumbnail gambar obat, atau badge bertuliskan "Tidak Ada Gambar" jika gambar kosong.
  * Fitur Import Batch dengan ZIP Gambar: mendukung pengunggahan file ZIP berisi kumpulan gambar obat bersamaan dengan file Excel. Sistem secara otomatis mengekstrak ZIP ke direktori temporer, mencocokkan nama file di kolom `gambar` Excel secara case-insensitive, merelokasi gambar yang cocok dengan nama unik, dan membersihkan berkas temporer secara aman.
* **Placeholder Image Premium**:
  * Menyediakan gambar fallback default `public/images/no-image.png` dengan desain modern dan estetika premium apotek.
* **Fitur Show/Hide Password**:
  * Menambahkan tombol toggle visibilitas password (ikon mata Eye / Eye Slash SVG) di dalam input field password di seluruh form sistem (Login, Register, Tambah User, Edit User, Reset Password, Confirm Password, Update Password Profile, Delete Account Modal).
  * Mengimplementasikan event listener JavaScript ringan global via event delegation pada layouts utama (app.blade.php dan guest.blade.php) untuk fleksibilitas dan performa maksimal.
  * Melengkapi tombol dengan atribut aria-label yang berganti dinamis demi aksesibilitas yang baik.

### Changed
* **Pencarian Real-Time**:
  * Menyesuaikan indeks kolom JavaScript pada fitur pencarian real-time di tabel indeks obat dari `nth-child(2)` ke `nth-child(3)` akibat penambahan kolom gambar baru di sebelah kiri kolom nama obat.

### Fixed
* **Penyelesaian SQL Warning Data Truncated 'role'**:
  * Menambahkan migrasi database baru `modify_role_in_users_table` untuk memperluas cakupan ENUM kolom `users.role` agar menyertakan nilai `'apoteker'` (menjadi `['admin', 'kasir', 'apoteker', 'pelanggan']`). Ini menghentikan warning SQL 1265 ketika melakukan operasi CRUD User dengan role apoteker.

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

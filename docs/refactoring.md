# Dokumentasi Refactoring Mekar Project

Dokumen ini berisi catatan mengenai proses *refactoring* dan optimalisasi kode (code cleanup, pemisahan blade, perbaikan logic) yang telah dilakukan pada Mekar Project.

---

## 1. Penyederhanaan Logika Perhitungan Harga & Checkout (Cart)

### Sebelum
**Masalah:** 
Sistem keranjang belanja (cart) dan checkout di marketplace menggunakan logika diskon dan voucher warisan (legacy) yang kompleks dan rentan terhadap inkonsistensi perhitungan antara state Frontend dan Backend.

### Perubahan
Menghapus seluruh logika diskon/voucher legacy dari proses checkout. Menggantinya dengan perhitungan matematis statis dan sederhana: `Subtotal + Ongkir = Total`. Perhitungan ongkir diintegrasikan langsung dengan OpenRouteService API secara real-time melalui AlpineJS.

### Alasan
Mencegah bug perbedaan total belanja, menyederhanakan kode state (menghapus variabel dan watcher yang tidak perlu), serta memastikan kestabilan aplikasi saat pengguna melakukan checkout.

### Dampak
Kode proses checkout jauh lebih modular dan *predictable* (mudah ditebak arah datanya). Cart load lebih ringan dan potensi error saat proses transaksi online berkurang drastis.

---

## 2. Pemisahan Komponen Blade & Modernisasi UI (UI Overhaul)

### Sebelum
**Masalah:**
Tampilan *User Interface* (UI) sebelumnya kaku, dan beberapa elemen antarmuka (navbar, tabel, form) di-hardcode di banyak file tanpa adanya penggunaan reusable components yang rapi, sehingga menyulitkan proses maintenance tampilan.

### Perubahan
Merapikan file `.blade.php` dengan mengekstraksi bagian berulang menjadi komponen-komponen terpisah (contoh: pemisahan hero section, flash sales, dan footer di homepage). Menerapkan styling Tailwind CSS global dengan konsep *container cards*, layout dengan *hover-responsive shadows*, dan *glassmorphism*.

### Alasan
Untuk mempermudah maintenance (satu kali ubah, berubah di seluruh web) dan membawa nuansa visual yang premium, profesional, serta seragam (*startup-ready e-commerce experience*).

### Dampak
Ukuran tiap file blade utama menjadi jauh lebih ringkas. Penambahan fitur frontend di masa depan akan lebih cepat dengan *reusable components*. Desain konsisten dan estetik.

---

## 3. Cleanup Route & Perbaikan Manajemen Role (RBAC)

### Sebelum
**Masalah:**
Terjadi error `Trait "Spatie\Permission\Traits\HasRoles" not found` akibat konflik dependency, SQL warning terkait input data ENUM role apoteker, dan rute navigasi yang terkadang tembus atau membingungkan secara akses (active states rancu).

### Perubahan
Melakukan *cleanup* menyeluruh pada `routes/web.php` dengan mengelompokkan ulang (grouping) *middleware* Spatie Permission (menggunakan alias standar `admin`, `kasir`, `apoteker`, dan `pelanggan`). Melakukan migrasi untuk memperbaiki tipe data Enum agar sinkron dengan sistem rute.

### Alasan
Menghilangkan konflik library (Spatie & Excel), mencegah celah keamanan, dan menstandarisasi bagaimana rute dilindungi tanpa perlu membuat custom logic berlapis-lapis di Controller.

### Dampak
Sistem navigasi, menu sidebar, dan hak akses sekarang terisolasi dengan rapi. Rute sangat mudah dibaca (*clean code*), dan penambahan role/akses baru hanya perlu memodifikasi alias middleware.

---

## 4. Pencegahan Bug & Optimalisasi Validasi (Stok Obat & Form)

### Sebelum
**Masalah:**
Sering terjadi *false-positives* kegagalan edit transaksi atau validasi yang ter-reset ketika ada error, dan stok bisa menjadi negatif jika tidak tertangani baik saat proses pesanan online. Controller `TransaksiController` harus menghitung ulang dengan baris yang panjang.

### Perubahan
Menyeragamkan penerjemahan validasi form, memperbaiki logika offset kuantitas pada saat edit transaksi agar stok dikembalikan sementara sebelum dikurangi lagi. Menerapkan pengurangan stok secara sekuensial **hanya jika** pesanan online telah diubah statusnya menjadi "Selesai".

### Alasan
Menjamin integritas data inventaris di database serta memperbaiki alur pengalaman pengguna (UX) ketika mereka lupa atau salah mengisi input di form.

### Dampak
Validasi lebih *strict*, pengguna selalu mendapatkan sisa data input (via method `old()`) jika terjadi error, dan kebocoran jumlah stok inventaris obat dapat dihentikan (terjamin aman).

---

## 5. Modernisasi Modul Laporan & Integrasi Fitur Export (Excel & PDF)

### Sebelum
**Masalah:**
Halaman Laporan Transaksi sebelumnya hanya menampilkan ringkasan data statis tanpa kemampuan cetak atau ekspor. Hal ini membatasi fungsi administratif kasir dan admin dalam melakukan analisis penjualan di luar aplikasi.

### Perubahan
Membuat `LaporanController` terpusat untuk memproses query transaksi berdasarkan rentang tanggal. Mengintegrasikan ekspor laporan dalam dua format utama:
1. **Excel (.xlsx)**: Menggunakan library Laravel Excel via `LaporanExport` lengkap dengan auto-width kolom, bold styling pada header/footer, dan format rupiah.
2. **PDF**: Menggunakan template layout berformat A4 Landscape siap cetak lengkap dengan data detail dan rekapitulasi total pendapatan.
Mengamankan rute laporan menggunakan middleware `role:admin|kasir`.

### Alasan
Untuk memfasilitasi kebutuhan pelaporan fisik dan analisis data dinamis menggunakan satu sumber data (*single source of truth*) yang konsisten dengan tabel di aplikasi.

### Dampak
Admin dan Kasir dapat mengunduh laporan berformat Excel atau PDF dengan cepat. Indikator loading interaktif di tombol ekspor mencegah submit ganda.

---

## 6. Penyempurnaan Relasi & Validasi Alur Supplier (Kolom Status & Nullability)

### Sebelum
**Masalah:**
Ketika Admin menambahkan obat dengan supplier baru yang belum terdaftar di database, sistem langsung membuat record supplier secara otomatis dengan data dummy/placeholder (alamat dan nomor telepon fiktif). Hal ini mengotori tabel `suppliers` dengan data tidak valid.

### Perubahan
* Mengubah kolom `alamat`, `telepon`, dan `email` di tabel `suppliers` menjadi `nullable`.
* Menambahkan kolom `status` pada tabel `suppliers` (default: `'Belum Lengkap'`).
* Memperbarui `ObatController` agar pencarian supplier baru dilakukan secara *case-insensitive* & *trimmed*, serta menyimpannya dengan nama saja (kolom detail lainnya null) dengan status `'Belum Lengkap'`.
* Menambahkan badge status dinamis (Lengkap vs Perlu Dilengkapi) pada view `supplier/index.blade.php`.
* Memperbarui `SupplierController@update` agar status otomatis naik tingkat menjadi `'Lengkap'` ketika data kontak utama berhasil dilengkapi oleh Admin.

### Alasan
Mencegah data sampah (placeholder) masuk ke database dan memastikan integrasi data supplier yang valid melalui alur persetujuan admin yang rapi.

### Dampak
Tabel supplier bersih dari data dummy. Admin dapat dengan mudah mengidentifikasi supplier mana yang informasinya perlu dilengkapi langsung dari halaman data supplier berkat adanya badge indikator visual.

---

## 7. Peningkatan Alur Impor Excel dengan Interactive Supplier Verification

### Sebelum
**Masalah:**
Pengguna diwajibkan untuk mengisi seluruh data kontak supplier pada lembar kerja Excel obat saat melakukan impor massal. Jika data supplier tidak ada di database, sistem langsung membuat data dengan alamat/telepon default/dummy. Tidak ada tahap peninjauan terintegrasi untuk melengkapi data supplier sebelum data obat disimpan.

### Perubahan
* **Ekspansi Template**: Memperbarui `ObatTemplateExport` untuk mendukung kolom data kontak supplier secara opsional (`nama_kontak`, `telepon_supplier`, `email_supplier`, `kota`, `alamat_supplier`, `keterangan_supplier`).
* **Interactive Preview**: Mendesain ulang `preview.blade.php` menjadi split-panel layout:
  * **Panel 1**: Preview data obat valid.
  * **Panel 2**: Modul verifikasi supplier dengan 3 jenis badge:
    * `✅ Supplier Ditemukan` (Lengkap - read only).
    * `⚠ Supplier Baru` (Form input lengkap).
    * `⚠ Data Supplier Belum Lengkap` (Form input dengan border warning pada field yang kosong).
* **Validasi Client-Side & Server-Side**: Menambahkan JavaScript validator untuk format email & telepon sebelum pengiriman form, serta server-side validator dalam sebuah block `DB::beginTransaction()` transaksi database.
* **Konsistensi Duplikasi**: Mengelompokkan nama supplier sejenis secara case-insensitive agar record baru hanya dibuat sekali meskipun dirujuk oleh beberapa obat berbeda dalam lembar Excel.

### Alasan
Memberikan fleksibilitas pengunggahan Excel dan membantu pengguna melengkapi detail kontak supplier secara cepat pada satu halaman tunggal sebelum benar-benar disimpan ke database.

### Dampak
Proses impor menjadi sangat aman dan interaktif. Data supplier dan data obat tersimpan dengan relasi Eloquent yang bersih dan status kelengkapan data yang akurat.


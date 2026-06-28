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

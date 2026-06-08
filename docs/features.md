# Feature Documentation

## Login

### Tujuan
Membatasi akses sistem hanya untuk admin yang terdaftar.

### Aktor
Admin

### Alur

1. Admin memasukkan email dan password.
2. Sistem melakukan validasi.
3. Jika valid, admin masuk ke dashboard.

---

## Dashboard

### Tujuan
Menampilkan ringkasan informasi sistem.

### Aktor
Admin

### Alur

1. Admin login.
2. Sistem menampilkan dashboard.
3. Admin melihat statistik sistem.

---

## Manajemen Kategori

### Tujuan
Mengelola kategori obat.

### Aktor
Admin

### Alur

Tambah → Ubah → Hapus → Lihat Data Kategori

---

## Manajemen Supplier

### Tujuan
Mengelola data supplier obat.

### Aktor
Admin

### Alur

Tambah → Ubah → Hapus → Lihat Data Supplier

---

## Manajemen Obat

### Tujuan
Mengelola data obat.

### Aktor
Admin

### Alur

Tambah → Ubah → Hapus → Lihat Data Obat

---

## Manajemen Pelanggan

### Tujuan
Mengelola data pelanggan.

### Aktor
Admin

### Alur

Tambah → Ubah → Hapus → Lihat Data Pelanggan

---

## Transaksi Penjualan

### Tujuan
Melakukan transaksi penjualan obat.

### Aktor
Admin

### Alur

1. Pilih pelanggan.
2. Pilih obat.
3. Input jumlah.
4. Sistem menghitung total.
5. Input pembayaran.
6. Sistem menghitung kembalian.
7. Simpan transaksi.

---

## Laporan Penjualan

### Tujuan
Menampilkan data transaksi yang telah dilakukan.

### Aktor
Admin

### Alur

1. Pilih periode.
2. Sistem mengambil data transaksi.
3. Sistem menampilkan laporan.

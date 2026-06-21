# Analisis Dependency / Package Laravel

## Mekar Project – Sistem Apotek

---

# 1. Laravel Breeze

| 5W+1H     | Penjelasan                                                                                                            |
| --------- | --------------------------------------------------------------------------------------------------------------------- |
| **What**  | `laravel/breeze`                                                                                                      |
| **Why**   | Digunakan untuk membuat sistem autentikasi seperti login, register, logout, dan session user secara cepat dan ringan. |
| **Who**   | Admin, Kasir, dan Owner untuk mengakses sistem sesuai akun masing-masing.                                             |
| **When**  | Digunakan saat pengguna melakukan login atau logout ke dalam sistem apotek.                                           |
| **Where** | Diimplementasikan pada modul autentikasi dan route login/register Laravel.                                            |
| **How**   | Diinstal menggunakan Composer dan dijalankan melalui perintah Artisan Laravel.                                        |

### Referensi

* Laravel Breeze Documentation: https://laravel.com/docs/starter-kits

---

# 2. Spatie Laravel Permission

| 5W+1H     | Penjelasan                                                                                         |
| --------- | -------------------------------------------------------------------------------------------------- |
| **What**  | `spatie/laravel-permission`                                                                        |
| **Why**   | Digunakan untuk mengatur role dan hak akses pengguna seperti admin, kasir, dan owner.              |
| **Who**   | Admin sebagai pengelola hak akses user dalam sistem.                                               |
| **When**  | Digunakan saat sistem menentukan izin akses setiap pengguna terhadap fitur tertentu.               |
| **Where** | Diimplementasikan pada modul user management dan middleware route Laravel.                         |
| **How**   | Diinstal melalui Composer lalu dikonfigurasi menggunakan role, permission, dan middleware Laravel. |

### Referensi

* Spatie Laravel Permission Documentation: https://spatie.be/docs/laravel-permission
* GitHub Repository: https://github.com/spatie/laravel-permission

---

# 3. Barryvdh DomPDF

| 5W+1H     | Penjelasan                                                                                  |
| --------- | ------------------------------------------------------------------------------------------- |
| **What**  | `barryvdh/laravel-dompdf`                                                                   |
| **Why**   | Digunakan untuk membuat dan mencetak laporan atau struk transaksi dalam format PDF.         |
| **Who**   | Kasir dan Owner untuk mencetak struk transaksi serta laporan penjualan.                     |
| **When**  | Digunakan setelah transaksi selesai atau saat laporan ingin dicetak.                        |
| **Where** | Diimplementasikan pada modul transaksi dan laporan penjualan.                               |
| **How**   | Diinstal menggunakan Composer lalu dipanggil melalui controller Laravel untuk generate PDF. |

### Referensi

* Laravel DomPDF GitHub: https://github.com/barryvdh/laravel-dompdf
* DomPDF Official Website: https://dompdf.github.io/

---

# 4. Laravel Excel

| 5W+1H     | Penjelasan                                                                              |
| --------- | --------------------------------------------------------------------------------------- |
| **What**  | `maatwebsite/excel`                                                                     |
| **Why**   | Digunakan untuk export dan import data dalam format Excel.                              |
| **Who**   | Admin dan Owner untuk mengelola data obat dan laporan penjualan.                        |
| **When**  | Digunakan saat export laporan atau import data obat dari file Excel.                    |
| **Where** | Diimplementasikan pada modul laporan dan manajemen data obat.                           |
| **How**   | Diinstal menggunakan Composer dan dijalankan melalui class export/import Laravel Excel. |

### Referensi

* Laravel Excel Documentation: https://docs.laravel-excel.com/
* GitHub Repository: https://github.com/SpartnerNL/Laravel-Excel

---

# 5. Tailwind CSS

| 5W+1H     | Penjelasan                                                                                                        |
| --------- | ----------------------------------------------------------------------------------------------------------------- |
| **What**  | `Tailwind CSS`                                                                                                    |
| **Why**   | Digunakan untuk membuat tampilan antarmuka sistem yang modern, responsif, dan fleksibel dengan utility-first CSS. |
| **Who**   | Developer dalam proses pembuatan frontend sistem apotek.                                                          |
| **When**  | Digunakan selama pengembangan halaman dashboard, transaksi, laporan, dan manajemen data.                          |
| **Where** | Diimplementasikan pada seluruh tampilan antarmuka website Laravel menggunakan file Blade.                         |
| **How**   | Diinstal menggunakan NPM/Vite dan digunakan melalui class utility Tailwind pada komponen frontend Laravel.        |

### Referensi

* Tailwind CSS Documentation: https://tailwindcss.com/docs
* Tailwind CSS Website: https://tailwindcss.com/

---

# 6. SweetAlert2

| 5W+1H     | Penjelasan                                                                        |
| --------- | --------------------------------------------------------------------------------- |
| **What**  | `sweetalert2`                                                                     |
| **Why**   | Digunakan untuk menampilkan popup notifikasi yang lebih interaktif dan modern.    |
| **Who**   | Semua pengguna sistem saat melakukan aksi tertentu.                               |
| **When**  | Digunakan saat berhasil menyimpan data, menghapus data, atau konfirmasi tindakan. |
| **Where** | Diimplementasikan pada halaman CRUD dan transaksi.                                |
| **How**   | Diinstal menggunakan NPM atau CDN lalu dipanggil menggunakan JavaScript.          |

### Referensi

* SweetAlert2 Documentation: https://sweetalert2.github.io/
* GitHub Repository: https://github.com/sweetalert2/sweetalert2

---

# 7. DataTables

| 5W+1H     | Penjelasan                                                                                                            |
| --------- | --------------------------------------------------------------------------------------------------------------------- |
| **What**  | `DataTables`                                                                                                          |
| **Why**   | Digunakan untuk membuat tabel data menjadi lebih interaktif dengan fitur pencarian, pagination, dan sorting otomatis. |
| **Who**   | Admin, Kasir, dan Owner saat melihat data sistem.                                                                     |
| **When**  | Digunakan saat menampilkan data obat, supplier, transaksi, dan user.                                                  |
| **Where** | Diimplementasikan pada halaman tabel data di sistem apotek.                                                           |
| **How**   | Ditambahkan menggunakan CDN/NPM lalu diinisialisasi menggunakan JavaScript pada tabel HTML.                           |

### Referensi

* DataTables Documentation: https://datatables.net/manual/
* DataTables Website: https://datatables.net/

---

# 8. Fonnte API

| 5W+1H     | Penjelasan                                                                                                 |
| --------- | ---------------------------------------------------------------------------------------------------------- |
| **What**  | `Fonnte WhatsApp API`                                                                                      |
| **Why**   | Digunakan untuk mengirim notifikasi WhatsApp otomatis seperti struk transaksi dan pemberitahuan stok obat. |
| **Who**   | Kasir, Admin, Owner, dan Pelanggan sistem apotek.                                                          |
| **When**  | Digunakan setelah transaksi berhasil atau ketika stok obat hampir habis.                                   |
| **Where** | Diimplementasikan pada modul transaksi dan monitoring stok obat.                                           |
| **How**   | Diintegrasikan menggunakan HTTP Request Laravel dengan token API Fonnte.                                   |

### Referensi

* Fonnte Official Website: https://fonnte.com/
* Fonnte Documentation: https://docs.fonnte.com/

---

# Stack Teknologi Mekar Project

```text
Laravel + Blade + Tailwind CSS + MySQL
```

## Dependency Utama yang Digunakan

```text
Laravel Breeze
Spatie Laravel Permission
Barryvdh DomPDF
Laravel Excel
Tailwind CSS
SweetAlert2
DataTables
Fonnte API
```

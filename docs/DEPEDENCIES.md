# Dokumentasi Dependency Mekar Project

Dokumen ini menjelaskan dependency yang digunakan dalam pengembangan **Mekar Project**, meliputi fungsi masing-masing dependency, alasan penggunaan versi, risiko, cara instalasi, serta dampaknya terhadap proyek.

---

# Daftar Dependency

| Package / API                 | Fungsi                                                                                                                                                                 | Alasan Versi                                                                                                                       | Risiko                                                                                                                                 |
| ----------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| **Laravel Framework (13.x)**  | Framework utama untuk membangun aplikasi web Mekar Project menggunakan arsitektur MVC.                                                                                 | Menggunakan Laravel 13 karena merupakan versi terbaru yang stabil, memiliki performa lebih baik, dan mendukung fitur-fitur modern. | Perubahan pada major version dapat menyebabkan beberapa package belum kompatibel.                                                      |
| **Laravel Breeze**            | Menyediakan sistem autentikasi dasar seperti Login, Register, Forgot Password, Profile, dan Logout. Menjadi dasar sistem autentikasi sebelum ditambahkan OTP WhatsApp. | Versi terbaru yang kompatibel dengan Laravel 13 dan mudah dikembangkan.                                                            | Update versi dapat mengubah struktur autentikasi sehingga membutuhkan penyesuaian kode.                                                |
| **Spatie Laravel Permission** | Mengelola Role dan Permission pengguna seperti Admin, Apoteker, Kasir, dan Pelanggan sehingga setiap pengguna memiliki hak akses yang berbeda.                         | Versi 8.x mendukung Laravel 13 dan memiliki dokumentasi yang lengkap.                                                              | Perubahan versi dapat memengaruhi middleware maupun struktur database.                                                                 |
| **Laravel DomPDF**            | Menghasilkan laporan dalam format PDF seperti laporan penjualan, laporan stok, maupun dokumen yang dapat dicetak.                                                      | Versi 3.x stabil dan kompatibel dengan Laravel terbaru.                                                                            | Update versi dapat memengaruhi tampilan hasil PDF atau kompatibilitas package.                                                         |
| **Laravel Excel**             | Melakukan ekspor dan impor data seperti data obat, supplier, transaksi, serta laporan dalam format Microsoft Excel.                                                    | Versi 3.x merupakan versi stabil yang paling banyak digunakan pada Laravel.                                                        | Perubahan API pada versi terbaru dapat memerlukan penyesuaian kode.                                                                    |
| **Fonte WhatsApp API**        | Mengirim pesan WhatsApp secara otomatis seperti konfirmasi pesanan, konsultasi apoteker, upload foto resep dokter, serta notifikasi kepada admin.                      | Menggunakan REST API resmi Fonte yang mudah diintegrasikan dengan Laravel menggunakan HTTP Client.                                 | Bergantung pada koneksi internet, API Token, dan layanan Fonte. Jika API mengalami gangguan maka fitur WhatsApp tidak dapat digunakan. |
| **Pest PHP**                  | Melakukan automated testing terhadap fitur autentikasi, middleware, dashboard, serta fitur-fitur utama aplikasi.                                                       | Sintaks lebih sederhana dibanding PHPUnit dan telah mendukung Laravel terbaru.                                                     | Digunakan hanya pada proses development sehingga tidak berdampak pada aplikasi produksi.                                               |
| **Tailwind CSS**              | Framework CSS yang digunakan untuk membangun antarmuka marketplace dan dashboard admin agar modern, responsif, dan konsisten.                                          | Mendukung Laravel 13 dan Vite serta memiliki performa yang baik.                                                                   | Update major version dapat menyebabkan perubahan utility class.                                                                        |
| **Alpine.js**                 | Menambahkan interaktivitas ringan seperti modal, popup review, dropdown, sidebar, countdown OTP, upload resep, dan komponen dinamis lainnya.                           | Ringan, mudah dipadukan dengan Blade, dan tidak memerlukan framework JavaScript yang besar.                                        | Perubahan sintaks pada versi baru dapat memerlukan penyesuaian kode.                                                                   |
| **Chart.js**                  | Menampilkan grafik statistik penjualan, transaksi, serta laporan pada dashboard administrator.                                                                         | Library populer yang ringan, mudah digunakan, dan kompatibel dengan Laravel.                                                       | Update major version dapat mengubah konfigurasi pembuatan grafik.                                                                      |

---

# Cara Instalasi Dependency

| Package / API             | Perintah Instalasi                                                                                                                                                                                  |
| ------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Laravel Framework         | `composer create-project laravel/laravel mekar-project`                                                                                                                                             |
| Laravel Breeze            | `composer require laravel/breeze --dev`                                                                                                                                                             |
| Spatie Laravel Permission | `composer require spatie/laravel-permission`                                                                                                                                                        |
| Laravel DomPDF            | `composer require barryvdh/laravel-dompdf`                                                                                                                                                          |
| Laravel Excel             | `composer require maatwebsite/excel`                                                                                                                                                                |
| Fonte WhatsApp API        | Tidak memerlukan instalasi Composer. Cukup mendaftar pada layanan Fonte, memperoleh API Token, menyimpannya pada file `.env`, kemudian mengakses API menggunakan `Illuminate\Support\Facades\Http`. |
| Pest PHP                  | `composer require pestphp/pest --dev pestphp/pest-plugin-laravel --dev`                                                                                                                             |
| Tailwind CSS              | `npm install tailwindcss @tailwindcss/vite @tailwindcss/forms`                                                                                                                                      |
| Alpine.js                 | `npm install alpinejs`                                                                                                                                                                              |
| Chart.js                  | `npm install chart.js`                                                                                                                                                                              |

---

# Dampak Dependency terhadap Mekar Project

## Dampak Positif

* Menyediakan sistem autentikasi pengguna menggunakan Laravel Breeze.
* Menambahkan sistem Role dan Permission sehingga hak akses pengguna dapat dikelola dengan baik.
* Menambahkan fitur ekspor dan impor data dalam format Microsoft Excel.
* Menambahkan fitur pencetakan laporan dalam format PDF.
* Menambahkan layanan komunikasi otomatis melalui WhatsApp menggunakan Fonte API.
* Mendukung fitur konsultasi apoteker melalui WhatsApp.
* Mendukung pengiriman foto resep dokter dari pelanggan kepada admin.
* Menampilkan dashboard yang lebih informatif menggunakan grafik Chart.js.
* Membuat tampilan website lebih modern, responsif, dan konsisten menggunakan Tailwind CSS.
* Menambahkan interaksi dinamis seperti popup, modal, upload resep, review pelanggan, dropdown, dan sidebar menggunakan Alpine.js.
* Mempermudah proses testing aplikasi menggunakan Pest PHP.

## Dampak terhadap Proyek

* Menambah ukuran folder **vendor** dan **node_modules**.
* Menambah jumlah dependency yang harus dipelihara selama proses pengembangan.
* Mempercepat pengembangan karena memanfaatkan package yang telah teruji dan terdokumentasi dengan baik.
* Mempermudah pengembangan fitur baru tanpa harus membangun semuanya dari awal.
* Memerlukan pembaruan berkala untuk menjaga keamanan, performa, dan kompatibilitas dengan Laravel versi terbaru.
* Beberapa fitur bergantung pada layanan pihak ketiga (Fonte WhatsApp API), sehingga memerlukan koneksi internet yang stabil dan API Token yang valid.
* Update major version pada dependency tertentu berpotensi menyebabkan incompatibility sehingga perlu dilakukan pengujian sebelum proses upgrade.

# GitHub Actions (CI/CD)

GitHub Actions digunakan pada project ini untuk menerapkan integrasi berkelanjutan (Continuous Integration/CI) dan pengujian otomatis. Dengan GitHub Actions, setiap perubahan kode yang didorong ke repositori (via push atau pull request) akan diuji secara otomatis untuk memastikan tidak ada fitur yang rusak (*regression*) sebelum kode digabungkan ke cabang utama.

---

## Laravel CI

### Tujuan Workflow
Workflow **Laravel CI** adalah satu-satunya workflow utama pada project ini yang melakukan otomatisasi lengkap mulai dari persiapan lingkungan aplikasi, instalasi dependensi, migrasi database, kompilasi aset frontend, hingga pengujian kode serta pembuatan laporan code coverage.

### Kapan Workflow Dijalankan
Workflow dijalankan secara otomatis pada event berikut:
*   **Push** ke branch `main`, `master`, atau `develop`.
*   **Pull Request** ke branch `main`, `master`, atau `develop`.

### Langkah-langkah Lengkap yang Dilakukan
1.  **Checkout Code:** Mengambil kode sumber terbaru dari repositori ke runner GitHub Actions.
2.  **Setup PHP:** Mengonfigurasi lingkungan PHP versi 8.5 beserta driver code coverage `pcov` dan ekstensi yang dibutuhkan seperti `dom`, `curl`, `libxml`, `mbstring`, `zip`, `pdo`, `sqlite`, `pdo_sqlite`, `bcmath`.
3.  **Cache Composer:** Melacak dan menyimpan cache dependensi PHP agar proses build berikutnya lebih cepat.
4.  **Install Composer Dependencies:** Mengunduh dan menginstal semua paket backend Laravel.
5.  **Copy Environment File:** Menyalin file `.env.example` menjadi `.env`.
6.  **Generate Application Key:** Membuat kunci enkripsi aplikasi (`APP_KEY`).
7.  **Cache Node & Install NPM:** Menyimpan cache dependensi frontend dan menginstal paket Node.js, dilanjutkan dengan kompilasi aset menggunakan Vite (`npm run build`).
8.  **Create SQLite Database:** Membuat file database sqlite sementara (`database/database.sqlite`).
9.  **Run Migrations:** Menjalankan migrasi database untuk menguji keabsahan skema migrasi.
10. **Run Tests with Coverage:** Mengeksekusi rangkaian pengujian menggunakan Pest PHP sekaligus menghasilkan laporan cakupan kode (Code Coverage) dengan parameter:
    ```bash
    ./vendor/bin/pest \
      --coverage \
      --coverage-clover=clover.xml \
      --coverage-html=html-coverage

    cp clover.xml coverage.xml
    ```
11. **Upload Coverage Artifacts:** Menyimpan hasil coverage (HTML coverage folder, clover.xml, dan coverage.xml) sebagai artifact GitHub Actions bernama `coverage-report`.

### Cara Melihat Hasil Workflow
1.  Buka repositori project Anda di GitHub.
2.  Klik tab **Actions**.
3.  Pilih run workflow terbaru dari daftar sebelah kiri yang berjudul **Laravel CI**.
4.  Anda dapat mengklik pekerjaan (*jobs*) `laravel-ci` untuk melihat log detail dari masing-masing langkah.

### Contoh Kondisi Berhasil
Apabila seluruh rangkaian test berhasil tanpa ada error, langkah **Run Tests with Coverage** akan menampilkan tanda centang hijau (`✔`) di samping semua nama test, dan status workflow keseluruhan akan berwarna hijau dengan status **Success**.

### Contoh Kondisi Gagal
Apabila terdapat minimal satu test yang gagal atau ada error sintaksis pada program, Pest akan mengembalikan exit code non-zero yang menyebabkan langkah **Run Tests with Coverage** gagal (silang merah `✖`). Status workflow keseluruhan akan ditandai sebagai **Failure**.

---

## Code Coverage

### Tujuan Code Coverage
Code Coverage digunakan untuk mengukur seberapa banyak persentase kode program aplikasi yang telah dijalankan oleh automated tests. Hal ini membantu tim pengembang mengetahui area kode mana saja yang belum diuji secara memadai.

### Cara Membaca Persentase Coverage
Persentase coverage akan dicetak langsung pada log eksekusi workflow di GitHub Actions di bawah langkah **Run Tests with Coverage**. Output akan berupa tabel yang memuat informasi persentase cakupan baris kode (Lines/Statements) untuk masing-masing kelas/file.

> [!NOTE]
> Secara default, workflow menggunakan driver `pcov` yang memproses Statement/Line Coverage dengan sangat cepat. Driver ini tidak mendukung Branch/Path coverage secara penuh karena keterbatasan teknis. Jika memerlukan Branch Coverage, driver harus diubah ke `xdebug` dan menambahkan flag `--path-coverage` pada Pest, namun ini akan memperlambat CI secara signifikan.

### Lokasi File Coverage yang Dihasilkan
File coverage yang dihasilkan meliputi:
*   `coverage.xml` (Format Clover XML)
*   `clover.xml` (Format Clover XML)
*   `html-coverage/` (Folder berisi laporan coverage interaktif dalam format HTML yang dapat dibuka di browser)

### Cara Mengunduh Artifact Coverage dari GitHub Actions
1.  Buka tab **Actions** di repositori GitHub Anda.
2.  Pilih workflow run **Laravel CI** yang telah selesai sukses.
3.  Scroll ke bagian bawah halaman ringkasan (*Summary*).
4.  Pada bagian **Artifacts**, klik nama file **coverage-report** untuk mengunduhnya dalam format ZIP.
5.  Ekstrak file ZIP tersebut dan buka file `html-coverage/index.html` pada browser lokal Anda untuk melihat visualisasi cakupan kode secara detail.

---

## Struktur Folder

Berikut adalah struktur folder terkait GitHub Actions pada project:

```text
.github/
└── workflows/
    └── laravel-ci.yml   # Workflow tunggal untuk integrasi berkelanjutan (CI), testing, dan code coverage
```

*   **laravel-ci.yml**: Bertanggung jawab penuh untuk menjalankan seluruh alur build aplikasi, migrasi database, pengujian otomatis, pembuatan statistik code coverage, hingga pengunggahan laporan coverage sebagai artifact.

---

## Cara Pengujian

1.  **Push ke Repository:**
    Lakukan perubahan kode secara lokal, commit perubahan tersebut, lalu dorong ke repositori remote menggunakan perintah:
    ```bash
    git add .
    git commit -m "feat: menambahkan fitur baru"
    git push origin <nama-branch>
    ```
    GitHub akan mendeteksi push tersebut dan langsung memulai workflow **Laravel CI**.

2.  **Membuat Pull Request:**
    Ketika Anda membuat Pull Request (PR) ke branch `main`, `master`, atau `develop`, status checks dari **Laravel CI** akan muncul di bagian bawah halaman PR. PR tidak disarankan (atau dapat diblokir) untuk digabungkan jika status checks menunjukkan kegagalan.

3.  **Melihat Hasil Workflow:**
    Buka tab **Actions** di GitHub untuk memantau status secara real-time. Setelah workflow selesai dengan sukses, artifact laporan coverage dapat langsung diunduh dari halaman tersebut.

---

## Troubleshooting

### Composer Install Gagal
*   **Penyebab:** Konflik versi dependensi atau ekstensi PHP yang kurang di runner.
*   **Solusi:** Pastikan file `composer.json` dan `composer.lock` Anda sinkron secara lokal sebelum push. Jika diperlukan ekstensi PHP tambahan, tambahkan nama ekstensi tersebut pada parameter `extensions` di bagian setup-php pada file workflow.

### Migration Gagal
*   **Penyebab:** Adanya kesalahan sintaksis pada migration baru, foreign key constraint yang salah urutan, atau ketidakcocokan tipe data pada SQLite.
*   **Solusi:** SQLite in-memory tidak mendukung beberapa operasi modifikasi tabel bawaan MySQL (misalnya mengganti nama kolom tanpa package pendukung lama). Pastikan migration Anda kompatibel dengan SQLite atau gunakan `Schema::hasTable` / `Schema::hasColumn` jika diperlukan modifikasi dinamis.

### Pest Test Gagal
*   **Penyebab:** Kode program yang diubah memicu bug, atau ada perbedaan zona waktu / konfigurasi env antara lokal dan CI.
*   **Solusi:** Periksa detail log error pada langkah **Run Tests with Coverage** di GitHub Actions. Pastikan Anda telah mensimulasikan env testing lokal dengan menjalankan `php artisan test` secara lokal terlebih dahulu sebelum commit.

### Coverage Tidak Muncul
*   **Penyebab:** Driver coverage (`pcov` atau `xdebug`) tidak terpasang dengan benar di setup PHP runner, atau Pest gagal mengidentifikasi folder target.
*   **Solusi:** Periksa konfigurasi `coverage: pcov` pada `.github/workflows/laravel-ci.yml`. Pastikan file `phpunit.xml` menyertakan tag `<source><include><directory>app</directory></include></source>` agar Pest tahu bagian mana yang harus dihitung persentase coverage-nya.

### Workflow Gagal Dijalankan
*   **Penyebab:** Kesalahan indentasi (*indentation*) atau typo parameter pada file YAML workflow. Masalah umum lainnya adalah penggunaan karakter titik dua pada nilai database SQLite in-memory (`DB_DATABASE: :memory:`), yang menyebabkan parser YAML salah mengartikannya sebagai key-value mapping tambahan.
*   **Solusi:** Validasi file YAML menggunakan YAML Validator online atau periksa pesan kesalahan parsial yang ditampilkan langsung oleh GitHub pada tab **Actions**. Jika Anda menggunakan `:memory:`, pastikan untuk membungkusnya dengan tanda kutip ganda (`":memory:"`) atau kutip tunggal (`':memory:'`).

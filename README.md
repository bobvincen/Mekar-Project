# 📘 Mekar-Project – Aturan Kerja Repository

## 🌿 Struktur Branch

* `main` → versi stabil (JANGAN DIUBAH SEMBARANGAN)
* `develop` → tempat gabung semua fitur
* `feature/...` → tempat kerja masing-masing anggota

---

## 👥 Pembagian Branch Tim

Setiap anggota menggunakan branch masing-masing:

* `feature/auth-login`
* `feature/kategori-crud`
* `feature/obat-crud`
* `feature/transaksi-penjualan`

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

* `feat:` → fitur baru
* `fix:` → perbaikan bug
* `refactor:` → perbaikan struktur kode
* `docs:` → dokumentasi
* `style:` → tampilan/UI
* `chore:` → konfigurasi/setup

### Contoh:

```
feat: menambahkan fitur login
fix: memperbaiki error transaksi
refactor: merapikan controller obat
```

---

## ❌ Larangan

* Tidak boleh commit ke `main`
* Tidak boleh commit ke `develop`
* Tidak boleh commit dengan pesan tidak jelas (contoh: "update", "fix")

---

## 👑 Tugas Lead Programmer

* Review semua Pull Request
* Merge ke `develop`
* Menjaga struktur repo tetap rapi

---

## 🎯 Tujuan

* Project terstruktur dan rapi
* Mudah dikerjakan secara tim
* Mudah dipresentasikan ke dosen/client

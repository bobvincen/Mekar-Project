# Installation Guide

## Persyaratan Sistem

- PHP 8.2+
- Composer
- MySQL
- Node.js
- Git

---

## Clone Repository

```bash
git clone https://github.com/bobvincen/Mekar-Project.git
```

Masuk ke folder project:

```bash
cd Mekar-Project
```

---

## Install Dependency

```bash
composer install
```

```bash
npm install
```

---

## Setup Environment

```bash
cp .env.example .env
```

Generate key:

```bash
php artisan key:generate
```

---

## Setup Database

Buat database:

```sql
CREATE DATABASE mekar_project;
```

Atur konfigurasi database pada file .env

```env
DB_DATABASE=mekar_project
DB_USERNAME=root
DB_PASSWORD=
```

---

## Migrasi Database

```bash
php artisan migrate
```

---

## Menjalankan Aplikasi

```bash
php artisan serve
```

Buka browser:

http://127.0.0.1:8000

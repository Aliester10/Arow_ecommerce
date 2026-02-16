<p align="center">
  <img src="ayobelanjalogo.png" alt="AyoBelanja Logo" width="250">
</p>

<h1 align="center">AyoBelanja — E-Commerce Platform</h1>

<p align="center">
  <strong>Platform e-commerce modern berbasis Laravel untuk pengalaman belanja online yang mudah dan menyenangkan.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/TailwindCSS-4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS 4">
  <img src="https://img.shields.io/badge/Vite-7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite 7">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License MIT">
</p>

---

## 📖 Tentang Proyek

**AyoBelanja** adalah platform e-commerce full-stack yang dibangun dengan **Laravel 12**. Aplikasi ini menyediakan pengalaman belanja online yang lengkap — mulai dari katalog produk, keranjang belanja, checkout dengan berbagai metode pembayaran, hingga panel admin untuk mengelola seluruh toko.

Proyek ini dikembangkan sebagai solusi e-commerce yang dapat dikustomisasi dan mudah di-deploy, cocok untuk kebutuhan bisnis online skala kecil hingga menengah.

---

## ✨ Fitur Utama

### 🛒 Fitur Pelanggan (Customer)
| Fitur | Deskripsi |
|-------|-----------|
| 🔐 **Autentikasi** | Register & Login dengan sistem role (Admin / User) |
| 📦 **Katalog Produk** | Daftar produk dengan kategori, sub-kategori, brand, dan pencarian |
| 🔗 **SEO-Friendly URL** | URL produk menggunakan slug (contoh: `/products/iphone-15-pro`) |
| 🛒 **Keranjang Belanja** | Tambah, ubah jumlah, dan hapus item dari keranjang |
| ❤️ **Wishlist** | Simpan produk favorit untuk dibeli nanti |
| ⭐ **Ulasan & Rating** | Pelanggan dapat memberikan ulasan dan rating pada produk |
| 💳 **Checkout** | Proses checkout dengan pengisian data pengiriman |
| 📱 **Pembayaran QRIS** | Dukungan pembayaran via QRIS |
| 📄 **Quotation / Penawaran** | Generate & download quotation dalam format Excel |
| 📋 **Riwayat Pesanan** | Lihat status dan detail pesanan yang telah dibuat |
| 🌐 **Multi-Bahasa** | Dukungan Bahasa Indonesia 🇮🇩 dan English 🇬🇧 |

### 🛠️ Fitur Admin Panel
| Fitur | Deskripsi |
|-------|-----------|
| 📊 **Dashboard** | Overview statistik toko |
| 📦 **Manajemen Produk** | CRUD produk dengan gambar, spesifikasi, dan harga |
| 🏷️ **Manajemen Brand** | Kelola brand/merek produk dengan logo |
| 🖼️ **Manajemen Banner** | Kelola banner promosi untuk halaman utama |
| 🎨 **Pengaturan Tampilan** | Kustomisasi header & footer website |
| 🔗 **Footer Links** | Kelola link pada bagian footer |
| ⚙️ **Pengaturan Global** | Konfigurasi informasi perusahaan dan toko |

---

## 🏗️ Tech Stack

| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| **PHP** | ^8.2 | Server-side scripting |
| **Laravel** | 12 | PHP Framework |
| **MySQL** | 5.7+ | Database relasional |
| **TailwindCSS** | 4.0 | Utility-first CSS Framework |
| **Vite** | 7.0 | Frontend build tool |
| **Alpine.js** | 3.x | Lightweight JS framework |
| **Composer** | 2.x | PHP package manager |
| **Node.js** | 18+ | JavaScript runtime |
| **NPM** | 9+ | Node package manager |

---

## 📁 Struktur Proyek

```
aro_ecommerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Semua controller (Auth, Product, Admin, dll)
│   │   └── Middleware/         # Middleware (admin, auth, dll)
│   └── Models/                 # 17 Eloquent Models
│       ├── User.php            # Model pengguna
│       ├── Produk.php          # Model produk
│       ├── Kategori.php        # Model kategori
│       ├── Subkategori.php     # Model sub-kategori
│       ├── SubSubkategori.php  # Model sub-sub-kategori
│       ├── Brand.php           # Model brand/merek
│       ├── Cart.php            # Model keranjang
│       ├── CartDetail.php      # Model detail keranjang
│       ├── Order.php           # Model pesanan
│       ├── OrderItem.php       # Model item pesanan
│       ├── Payment.php         # Model pembayaran
│       ├── Quotation.php       # Model quotation
│       ├── Wishlist.php        # Model wishlist
│       ├── Ulasan.php          # Model ulasan/review
│       ├── Banner.php          # Model banner
│       ├── Perusahaan.php      # Model info perusahaan
│       └── FooterLink.php      # Model link footer
├── database/
│   ├── migrations/             # 33 file migrasi database
│   └── seeders/                # Seeder untuk data awal
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php      # Seeder akun default
│       ├── MasterDataSeeder.php # Seeder kategori, brand, dll
│       └── ProductSeeder.php   # Seeder produk contoh
├── resources/
│   └── views/                  # Blade templates
│       ├── admin/              # Halaman admin panel
│       ├── auth/               # Halaman login & register
│       ├── cart/               # Halaman keranjang belanja
│       ├── checkout/           # Halaman checkout & pembayaran
│       ├── orders/             # Halaman riwayat pesanan
│       ├── products/           # Halaman katalog & detail produk
│       ├── wishlist/           # Halaman wishlist
│       ├── layouts/            # Layout utama (app.blade.php)
│       ├── components/         # Komponen reusable
│       └── partials/           # Partial views
├── routes/
│   └── web.php                 # Definisi semua route
├── public/                     # File publik (gambar, favicon, dll)
├── config/                     # File konfigurasi Laravel
├── lang/                       # File terjemahan (id, en)
├── .env.example                # Template konfigurasi environment
├── composer.json               # Dependensi PHP
├── package.json                # Dependensi Node.js
├── tailwind.config.js          # Konfigurasi TailwindCSS
├── vite.config.js              # Konfigurasi Vite
└── ayobelanjalogo.png          # Logo AyoBelanja
```

---

## 🚀 Instalasi & Setup

### Prasyarat (Prerequisites)

Pastikan perangkat Anda telah terinstal:

- **PHP** >= 8.2 (dengan ekstensi: `mbstring`, `xml`, `ctype`, `json`, `bcmath`, `pdo_mysql`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM** >= 9.x
- **MySQL** >= 5.7 atau **MariaDB** >= 10.3
- **Git**

### Langkah Instalasi

#### 1️⃣ Clone Repository

```bash
git clone https://github.com/username/aro_ecommerce.git
cd aro_ecommerce
```

#### 2️⃣ Install Dependensi PHP

```bash
composer install
```

#### 3️⃣ Install Dependensi Node.js

```bash
npm install
```

#### 4️⃣ Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME=AyoBelanja
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ayobelanja_db
DB_USERNAME=root
DB_PASSWORD=
```

> **📝 Catatan:** Pastikan Anda sudah membuat database `ayobelanja_db` (atau nama lain yang Anda tentukan) di MySQL sebelum melanjutkan.

#### 5️⃣ Generate Application Key

```bash
php artisan key:generate
```

#### 6️⃣ Jalankan Migrasi Database

```bash
php artisan migrate
```

#### 7️⃣ Jalankan Seeder (Data Awal)

```bash
php artisan db:seed
```

Seeder akan mengisi data awal berikut:
- 👤 **Akun Admin & Customer** (lihat bagian [Akun Default](#-akun-default))
- 📦 **Data Master** (Kategori, Sub-kategori, Brand)
- 🛍️ **Produk Contoh**

#### 8️⃣ Buat Storage Link

```bash
php artisan storage:link
```

#### 9️⃣ Build Asset Frontend

```bash
npm run build
```

#### 🔟 Jalankan Server

Buka **2 terminal** secara bersamaan:

**Terminal 1 — Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 — Vite Dev Server (untuk development):**
```bash
npm run dev
```

> Atau gunakan satu command untuk menjalankan keduanya secara bersamaan:
> ```bash
> composer dev
> ```

🎉 **Aplikasi siap diakses di:** [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

### 🪟 Setup Cepat (Windows)

Untuk pengguna Windows, tersedia script `run_website.bat` yang otomatis melakukan semua langkah di atas:

```bash
# Klik dua kali file run_website.bat
# atau jalankan dari command prompt:
run_website.bat
```

---

## 🔑 Akun Default

Setelah menjalankan seeder (`php artisan db:seed`), tersedia akun berikut untuk pengujian:

| Role | Nama | Email | Password |
|------|------|-------|----------|
| 🔴 **Admin** | Admin Arow | `admin@arow.com` | `password` |
| 🔵 **Customer** | John Doe | `customer@example.com` | `password` |
| 🔵 **Customer** | Jane Smith | `jane@example.com` | `password` |

> ⚠️ **PENTING:** Segera ubah password default setelah deployment ke production!

**Akses Admin Panel:** [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## 📸 Screenshot

> Silakan tambahkan screenshot aplikasi di sini untuk memberikan gambaran visual kepada pengguna.

<!-- 
Cara menambahkan screenshot:
![Halaman Utama](screenshots/homepage.png)
![Admin Dashboard](screenshots/admin-dashboard.png)
-->

---

## ⚙️ Perintah Artisan Berguna

| Perintah | Keterangan |
|----------|------------|
| `php artisan serve` | Jalankan development server |
| `php artisan migrate` | Jalankan migrasi database |
| `php artisan migrate:fresh --seed` | Reset database & isi data awal |
| `php artisan db:seed` | Isi database dengan data awal |
| `php artisan cache:clear` | Bersihkan cache aplikasi |
| `php artisan config:clear` | Bersihkan cache konfigurasi |
| `php artisan route:list` | Lihat daftar semua route |
| `php artisan storage:link` | Buat symbolic link storage |
| `npm run dev` | Jalankan Vite dev server |
| `npm run build` | Build asset untuk production |
| `composer dev` | Jalankan Laravel + Vite bersamaan |

---

## 🔧 Troubleshooting

### ❌ Error: "SQLSTATE[HY000] [1049] Unknown database"
Pastikan database sudah dibuat di MySQL:
```sql
CREATE DATABASE ayobelanja_db;
```

### ❌ Error: "The Mix manifest does not exist" atau "Vite manifest not found"
Jalankan build asset terlebih dahulu:
```bash
npm run build
```

### ❌ Error: "No application encryption key has been specified"
Generate application key:
```bash
php artisan key:generate
```

### ❌ Gambar produk tidak muncul
Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

### ❌ Error: "Permission denied" pada folder storage
Berikan permission pada folder storage dan bootstrap/cache:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 🌍 Multi-Bahasa

Aplikasi mendukung 2 bahasa:
- 🇮🇩 **Bahasa Indonesia** (default)
- 🇬🇧 **English**

Pengguna dapat mengganti bahasa melalui tombol bahasa yang tersedia di navbar. File terjemahan terletak di folder `lang/`.

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Berikut langkah-langkahnya:

1. **Fork** repository ini
2. **Buat branch** fitur baru (`git checkout -b fitur/fitur-baru`)
3. **Commit** perubahan (`git commit -m 'Menambahkan fitur baru'`)
4. **Push** ke branch (`git push origin fitur/fitur-baru`)
5. Buat **Pull Request**

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

## 📞 Kontak

Untuk pertanyaan atau support, silakan hubungi melalui:
- 📧 Email: admin@arow.com
- 🌐 Website: [AyoBelanja](http://127.0.0.1:8000)

---

<p align="center">
  <img src="ayobelanjalogo.png" alt="AyoBelanja" width="120">
  <br>
  <sub>Dibuat dengan ❤️ menggunakan Laravel 12</sub>
</p>

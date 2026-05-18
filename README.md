# 🚀 RawatKasih 
Deskripsi singkat tentang project ini.

---

## 📋 Daftar Isi

- [Teknologi](#teknologi)
- [Push Project ke GitHub](#push)
- [Panduan Clone & Setup](#clone)
- [Setup Database](#setup-database)
- [Menjalankan Project](#menjalankan-project)

---

<h2 id="teknologi">🛠 Teknologi</h2>

- PHP >= 8.5.4
- Laravel >= 13.x
- MySQL
- Composer
- Node.js & NPM

---

<h2 id="push">📤 Push Project ke GitHub</h2>

Langkah-langkah untuk pertama kali push project Laravel ke GitHub.

### 1. Pastikan `.gitignore` sudah benar

Laravel sudah menyertakan `.gitignore` secara default. Pastikan file-file berikut **tidak** ikut di-push:

```
/vendor
/node_modules
.env
/storage/*.key
```

### 2. Inisialisasi Git dan push ke GitHub

```bash
# Masuk ke folder project
cd RawatKasih

# Inisialisasi git (jika belum)
git init

# Tambahkan semua file
git add .

# Commit pertama
git commit -m "Initial commit"

# Hubungkan ke repository GitHub (ganti URL sesuai repo kamu)
git remote add origin https://github.com/Benjojr/RawatKasih.git

# Push ke branch main
git branch -M main
git push -u origin main
```

### 3. Push update berikutnya

```bash
git add .
git commit -m "Pesan commit"
git push
```

---

<h2 id="clone">📥 Panduan Clone & Setup</h2>

Ikuti langkah-langkah berikut setelah melakukan clone repository.

### 1. Clone Repository

```bash
git clone https://github.com/Benjojr/RawatKasih.git
cd RawatKasih
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Node

> ⚠️ **Pengguna WSL (Windows Subsystem for Linux):** Pastikan `node` dan `npm` terpasang di dalam WSL, **bukan** dari Windows. Cek dengan perintah berikut:
> ```bash
> which node  # harus: /home/username/.nvm/...
> which npm   # harus: /home/username/.nvm/...
> ```
> Jika salah satunya mengarah ke `/mnt/c/...`, install Node.js via nvm di WSL terlebih dahulu:
> ```bash
> curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash
> # Tutup dan buka terminal baru, lalu:
> nvm install --lts
> nvm use --lts
> ```

```bash
npm install
npm run build
```

### 4. Salin file `.env`

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

<h2 id="setup-database">🗄️ Setup Database</h2>

### 1. Buat Database Baru

Buat database baru di MySQL:

```sql
CREATE DATABASE rawatkasih;
```

Atau melalui phpMyAdmin / DBeaver / tools lainnya.

### 2. Konfigurasi `.env`

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rawatkasih
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Jalankan Migration

```bash
# Hanya migration
php artisan migrate

# Migration + Seeder (jika ada data awal)
php artisan migrate --seed
```

## ▶️ Menjalankan Project

```bash
php artisan serve
```

Akses project di browser: [http://localhost:8000](http://localhost:8000)

---

## 📁 Struktur MVC

```
app/
├── Http/
│   └── Controllers/   # Controller
├── Models/            # Model
resources/
└── views/             # View (Blade Templates)
routes/
└── web.php            # Route utama
database/
├── migrations/        # Struktur tabel
└── seeders/           # Data awal
```

---

## 📝 Lisensi

Project ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
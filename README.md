# 🚀 RawatKasih 
Deskripsi singkat tentang project ini.

---

## 📋 Daftar Isi

- [Teknologi](#teknologi)
- [Clone & Setup](#clone)
- [Setup Database](#setup-database)
- [Run Project](#run)
- [Struktur MVC](#structure)

---

<h2 id="teknologi">🛠 Teknologi</h2>

- PHP >= 8.5.4
- Laravel >= 13.x
- MySQL
- Composer
- Node.js & NPM

---

<h2 id="clone">Clone & Setup</h2>

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

<h2 id="run">▶️ Menjalankan Project</h2>

```bash
php artisan serve
```

Akses project di browser: [http://localhost:8000](http://localhost:8000)

---

<h2 id="structure">📁 Struktur MVC</h2>

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
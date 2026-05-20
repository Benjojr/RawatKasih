# 🏥 RawatKasih

Aplikasi **Caregiver-Assistant** berbasis web untuk membantu pengelolaan panti wreda secara digital. Menghubungkan tiga pihak utama — **Pramurukti**, **Keluarga**, dan **Admin Panti** — dalam satu platform terintegrasi.

> Juara 1 GEMASTIK 2025 — Tim InnoVate, Institut Teknologi Sepuluh Nopember

---

## 📋 Daftar Isi

- [Fitur](#-fitur)
- [Teknologi](#-teknologi)
- [Peran Pengguna](#-peran-pengguna)
- [Panduan Clone & Setup](#-panduan-clone--setup)
- [Setup Database](#-setup-database)
- [Menjalankan Project](#-menjalankan-project)
- [Struktur Project](#-struktur-project)
- [Perintah Berguna](#-perintah-berguna)

---

## ✨ Fitur

### Admin
- Dashboard ringkasan operasional panti
- Manajemen penghuni, kamar, pramurukti, dan tugas
- Atur jadwal shift pramurukti
- Review & kelola pengajuan kunjungan keluarga
- Chat dengan semua pengguna

### Pramurukti
- Dashboard tugas harian + countdown shift
- Input monitoring harian (tanda vital, mood, catatan)
- Daftar & profil detail pasien
- Chat dengan keluarga dan admin

### Keluarga
- Dashboard status lansia secara real-time
- Grafik tren kesehatan (gula darah, detak jantung, suhu)
- Ajukan & kelola jadwal kunjungan
- Chat dengan pramurukti dan admin

### Semua Peran
- Notifikasi otomatis saat ada kejadian penting
- Pengaturan profil & ubah password

---

## 🛠 Teknologi

- PHP >= 8.5.4
- Laravel >= 13.x
- MySQL
- Tailwind CSS v4
- Vite 8
- Chart.js
- Composer
- Node.js & NPM (via nvm)

---

## 👥 Peran Pengguna

| Peran | Akses |
|---|---|
| `admin` | Kelola semua data operasional panti |
| `pramurukti` | Input tugas harian & monitoring pasien |
| `keluarga` | Pantau kondisi lansia & ajukan kunjungan |

---

## 📥 Panduan Clone & Setup

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

## 🗄️ Setup Database

### 1. Buat Database Baru

```sql
CREATE DATABASE rawatkasih;
```

### 2. Konfigurasi `.env`

Buka file `.env` dan sesuaikan:

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
php artisan migrate
```

---

## ▶️ Menjalankan Project

Jalankan dua perintah berikut di terminal terpisah:

```bash
# Terminal 1 — Backend
php artisan serve

# Terminal 2 — Frontend (development)
npm run dev
```

Akses di browser: [http://localhost:8000](http://localhost:8000)

### Akun Pertama

Daftar akun baru melalui halaman `/register`. Pilih peran saat registrasi:
- **Admin** — untuk mengelola operasional panti
- **Pramurukti** — untuk input tugas harian
- **Keluarga** — untuk memantau kondisi lansia

> Setelah daftar sebagai **Pramurukti**, admin perlu mendaftarkannya di menu **Pramurukti** agar muncul di sistem.

---

## 📁 Struktur Project

```
app/
├── Helpers/
│   └── NotifikasiHelper.php      # Helper kirim notifikasi
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                # Controller khusus admin
│   │   ├── Keluarga/             # Controller khusus keluarga
│   │   ├── Pramurukti/           # Controller khusus pramurukti
│   │   ├── AuthController.php
│   │   ├── ChatController.php
│   │   ├── DashboardController.php
│   │   ├── NotifikasiController.php
│   │   └── ProfilController.php
│   └── Middleware/
│       └── CekPeran.php          # Middleware role-based access
├── Models/                       # Eloquent models
resources/
├── css/
│   └── app.css                   # Tailwind CSS
├── js/
│   └── app.js
└── views/
    ├── admin/                    # View halaman admin
    ├── auth/                     # Login & register
    ├── chat/                     # Halaman chat
    ├── dashboard/                # Dashboard per peran
    ├── keluarga/                 # View halaman keluarga
    ├── layouts/                  # Layout per peran
    ├── notifikasi/               # Halaman notifikasi
    ├── profil/                   # Pengaturan profil
    └── pramurukti/               # View halaman pramurukti
routes/
└── web.php                       # Semua route aplikasi
database/
└── migrations/                   # Struktur tabel database
```

---

## ⚙️ Perintah Berguna

```bash
# Bersihkan cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Lihat semua route
php artisan route:list

# Reset database
php artisan migrate:fresh
```

---

## 📝 Lisensi

Project ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
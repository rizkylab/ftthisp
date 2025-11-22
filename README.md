# FTTH Management System

## 📖 Overview
Sistem manajemen jaringan **Fiber‑to‑the‑Home (FTTH)** modern berbasis Laravel 12. Aplikasi ini memungkinkan pengelolaan OLT, ODP, fiber cable, pelanggan, serta area geografis (contoh: data dummy wilayah **Bengkulu**). Dilengkapi dengan otentikasi berbasis peran (admin & teknisi) dan UI premium yang responsif.

## 🎯 Fitur Utama
- **Multi‑Role Authentication**
  - **Admin**: Akses penuh, mengelola pengguna, jaringan, laporan, dan pengaturan sistem.
  - **Technician**: Mengelola OLT, ODP, fiber cable, serta data pelanggan.
- **Manajemen Jaringan FTTH**
  - CRUD OLT, ODP, FiberCable, Customer, Area.
  - Visualisasi koordinat (lat/lng) untuk setiap elemen jaringan.
- **Seeder Dummy Data**
  - Data acak untuk OLT, ODP, kabel, pelanggan, dan area **Bengkulu**.
- **UI Modern & Premium**
  - Desain gelap, animasi halus, tipografi Google Fonts, dan komponen reusable.
- **Laporan & Audit**
  - Ringkasan jaringan, status OLT/ODP, dan laporan pelanggan.

## 🛠️ Teknologi Stack
- **Backend**: Laravel 12, PHP 8.3, MySQL/PostgreSQL
- **Frontend**: Blade, Vanilla CSS (custom design system), JavaScript
- **Database**: Eloquent ORM, migrations & seeders
- **Testing**: PHPUnit (unit & feature)
- **Version Control**: Git + GitHub

## 📋 Prasyarat
- PHP >= 8.3
- Composer
- Database (MySQL/PostgreSQL)
- Node.js & npm (optional untuk asset compilation)

## 🚀 Instalasi
```bash
# Clone repository
git clone https://github.com/rizkylab/ftthisp.git
cd ftthisp

# Install PHP dependencies
composer install

# Copy env file & set database credentials
cp .env.example .env
# edit .env accordingly

# Generate app key
php artisan key:generate

# Run migrations & seeders (includes dummy Bengkulu area)
php artisan migrate
php artisan db:seed

# Compile assets (optional)
npm install && npm run dev

# Start development server
php artisan serve
```
Akses aplikasi di `http://127.0.0.1:8000`.

## 👤 Kredensial Default
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | `password` |
| Technician | tech@example.com | `password` |

## 📁 Struktur Project
```
app/
  Models/          # Eloquent models (Olt, Odp, FiberCable, Customer, Area, User, Role)
  Http/Controllers/ # Controller CRUD
database/
  migrations/      # Schema definitions
  seeders/         # Dummy data (AreaSeeder adds Bengkulu)
resources/
  views/           # Blade templates (dashboard, CRUD UI)
public/
  css/ js/         # Compiled assets
```

## ✅ Fitur yang Sudah Diimplementasi
- **Phase 1**: Project setup & dasar Laravel
- **Phase 2**: Skema database lengkap (OLT, ODP, Kabel, Pelanggan, Area)
- **Phase 3**: Otentikasi & otorisasi per peran
- **Phase 4**: CRUD UI premium untuk semua entitas
- **Phase 5**: Seeder dummy data termasuk wilayah **Bengkulu**

## 🔧 Konfigurasi
- **System Settings**: `config/app.php` & `.env` untuk mode debug, timezone, dll.
- **Office Location**: Koordinat default untuk area Bengkulu dapat diubah di `database/seeders/AreaSeeder.php`.

## 📱 Penggunaan
- **Admin**: Dashboard lengkap, manajemen pengguna, laporan jaringan.
- **Technician**: Tambah/ubah OLT, ODP, kabel, dan pelanggan.
- **Customer** (read‑only): Lihat detail layanan melalui endpoint API (opsional).

## 🎨 Kustomisasi
- **Dark Mode**: Otomatis mengikuti preferensi sistem.
- **Logo Perusahaan**: Ganti file `public/logo.png`.
- **Tema Warna**: Edit variabel CSS di `resources/css/app.css`.

## 📊 Laporan
- Ringkasan jaringan (jumlah OLT, ODP, kabel aktif).
- Status port OLT & kapasitas ODP.
- Daftar pelanggan per ODP.
- Export PDF/Excel (future enhancement).

## 🔐 Keamanan
- Password hashing dengan `Hash::make`.
- Middleware `auth` & `role` untuk proteksi route.
- Validasi request input pada semua endpoint.

## 🐛 Troubleshooting
- **Database connection error**: Pastikan kredensial di `.env` sudah benar & DB server berjalan.
- **Assets not loading**: Jalankan `npm install && npm run dev` atau `php artisan view:clear`.
- **Permission denied**: Pastikan folder `storage` & `bootstrap/cache` memiliki hak akses write (`chmod -R 775`).

## 📄 License
MIT License – lihat file `LICENSE` untuk detail.

## 👨‍💻 Developer
**Rizky Lab** – <https://github.com/rizkylab>

## 🙏 Credits
- Laravel community
- Font Awesome & Google Fonts (Inter)
- Icon assets from Lucide

---
*Terima kasih telah menggunakan FTTH Management System!*

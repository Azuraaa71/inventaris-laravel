# Sistem Inventaris Barang (Laravel 11)

Aplikasi manajemen inventaris sederhana berbasis web untuk mengelola data kategori dan produk.

## Fitur Utama
* **Manajemen Kategori**: Tambah, lihat, dan hapus kategori barang.
* **Manajemen Produk**: Tambah, lihat, edit, dan hapus data produk (CRUD).
* **Relasi Data**: Setiap produk terhubung langsung dengan kategori terkait.

## Teknologi
* Framework: Laravel 11
* Database: SQLite
* Styling: Bootstrap 5

## Cara Menjalankan Proyek
1. Clone repositori:
   git clone <URL_REPOSITORY_GITHUB>
   cd inventaris-laravel
2. Install dependensi:
   composer install
3. Konfigurasi `.env` dan migrasi database:
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate
4. Jalankan server:
   php artisan serve
# InvenTrack — Sistem Inventaris Barang

Antarmuka inventaris berbasis Laravel dan Bootstrap 5.3 dengan layout responsif, dashboard ringkasan, pencarian, filter stok, pagination, formulir validasi, kategori, serta konfirmasi penghapusan.

## Fitur
- Dashboard statistik: jumlah jenis barang, kategori, total unit stok, dan barang dengan stok menipis.
- CRUD barang (tambah, lihat, edit, hapus).
- Kelola kategori barang.
- Pencarian berdasarkan nama, kode, dan kategori.
- Filter stok menipis (1–5 unit) dan stok habis.
- Tampilan responsif untuk desktop, tablet, dan ponsel.
- Master layout Blade terpusat dengan `@extends`, `@section`, `@yield`, dan notifikasi `@if`.
- Bootstrap 5.3, Bootstrap Icons, tabel hover, badge status, modal konfirmasi, serta pagination.

## Cara menjalankan
Pastikan PHP, Composer, dan database MySQL/MariaDB tersedia.

1. Ekstrak ZIP lalu buka folder `inventaris-bootstrap` di terminal.
2. Pasang dependensi:
   ```bash
   composer install
   ```
3. Buat file konfigurasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Di Windows Command Prompt, salin `.env.example` menjadi `.env` secara manual jika perintah `cp` tidak tersedia.
4. Atur koneksi database di `.env`, misalnya `DB_DATABASE=inventaris`, `DB_USERNAME=root`, dan `DB_PASSWORD=` sesuai konfigurasi lokal.
5. Buat database bernama `inventaris` di MySQL/MariaDB.
6. Jalankan migrasi:
   ```bash
   php artisan migrate
   ```
7. Jalankan server:
   ```bash
   php artisan serve
   ```
8. Buka alamat yang ditampilkan oleh Artisan, biasanya `http://127.0.0.1:8000`.

Bootstrap dan Bootstrap Icons dimuat melalui CDN, jadi browser memerlukan koneksi internet untuk menampilkan styling dan ikon dengan lengkap.

## Catatan
- ZIP tidak menyertakan folder `vendor`, `node_modules`, file `.env` pribadi, atau metadata Git. Jalankan `composer install` setelah ekstraksi.
- Struktur tabel dan relasi mengikuti migrasi yang sudah ada pada proyek.

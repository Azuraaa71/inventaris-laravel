# Sistem Inventaris Gudang (Laravel)

Aplikasi inventaris berbasis Laravel untuk mengelola produk, kategori, pengguna, serta transaksi stok barang masuk dan keluar.

## Fitur

- Manajemen produk: tambah, lihat, edit, dan arsipkan produk.
- Manajemen kategori: tambah, lihat, dan hapus kategori yang belum digunakan.
- Transaksi stok: pencatatan barang masuk dan keluar dengan validasi agar stok tidak negatif.
- Riwayat mutasi: menyimpan jenis transaksi, jumlah, stok sebelum/sesudah, waktu, petugas, dan keterangan.
- Ringkasan stok: total stok akhir serta total barang masuk/keluar pada bulan berjalan.
- Autentikasi: login, logout, regenerasi session, dan pembatasan percobaan login.
- Role pengguna: admin mengelola master data dan akun; user dapat melihat inventaris serta mencatat transaksi stok.
- Audit saldo awal: stok produk lama dicatat sebagai transaksi saldo awal saat migrasi.

## Teknologi

- PHP 8.4.1+
- Laravel 13
- SQLite (default)
- Bootstrap 5

## Instalasi

1. Clone repository dan masuk ke folder proyek:
   git clone https://github.com/Azuraaa71/inventaris-laravel.git
   cd inventaris-laravel

2. Pasang dependensi dan siapkan file environment:
   composer install
   cp .env.example .env
   php artisan key:generate

3. Isi ADMIN_EMAIL dan ADMIN_PASSWORD pada file .env. Password admin harus kuat dan minimal 12 karakter.

4. Buat database SQLite dan jalankan migrasi beserta seeder:
   touch database/database.sqlite
   php artisan migrate --seed

5. Jalankan aplikasi:
   php artisan serve

Buka http://127.0.0.1:8000 dan login menggunakan email serta password admin yang ditentukan pada .env.

## Aturan akses

| Fitur | Admin | User |
|---|---:|---:|
| Melihat produk dan kategori | Ya | Ya |
| Mencatat barang masuk/keluar | Ya | Ya |
| Menambah, mengubah, dan mengarsipkan produk | Ya | Tidak |
| Mengelola kategori | Ya | Tidak |
| Membuat dan menghapus akun | Ya | Tidak |

Produk baru dimulai dengan stok 0. Semua perubahan stok wajib dilakukan melalui menu Mutasi Stok agar riwayat transaksi tetap konsisten. Produk hanya dapat diarsipkan ketika stoknya sudah nol.

## Pengujian

Jalankan pengujian otomatis dengan perintah:

php artisan test

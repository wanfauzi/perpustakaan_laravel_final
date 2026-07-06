# Sistem Manajemen Perpustakaan

Aplikasi web untuk mengelola data buku, anggota, peminjaman, pengembalian, denda, pencarian, dashboard, dan laporan transaksi. Proyek ini dibuat dengan Laravel sebagai persiapan UAS dan contoh penerapan pola MVC.

## Fitur Utama

- Autentikasi: register, login, logout, dan proteksi route dengan middleware `auth`.
- CRUD buku beserta pencarian, filter kategori, validasi, bulk delete, dan export Excel.
- CRUD anggota beserta validasi email, telepon Indonesia, tanggal lahir, dan export Excel.
- Pengelolaan kategori buku yang dinamis.
- Transaksi peminjaman dengan kode otomatis, jatuh tempo tujuh hari, dan pengurangan stok.
- Pengembalian buku dengan status otomatis, penambahan stok, dan denda Rp5.000 per hari.
- Dashboard statistik, dua visualisasi Chart.js, transaksi terbaru, buku populer, dan anggota aktif.
- Global Search untuk buku, anggota, dan transaksi dengan keyword highlighting.
- Laporan transaksi berdasarkan tanggal, status, dan anggota.
- Tampilan print-friendly dan export laporan PDF.
- Automated test untuk autentikasi serta beberapa validasi dan alur penting.

## Teknologi

- PHP 8.3+
- Laravel 13
- MySQL 8 atau MariaDB
- Blade
- Bootstrap 5 dan Bootstrap Icons
- Chart.js
- Laravel Breeze
- Laravel DomPDF
- Laravel Excel
- Vite, Tailwind CSS, dan Alpine.js
- PHPUnit 12

## Konsep yang Diterapkan

- MVC untuk memisahkan model, tampilan, dan alur request.
- Eloquent ORM dan relationship `hasMany`/`belongsTo`.
- Form Request untuk memisahkan validasi dari controller.
- Migration, foreign key, dan seeder.
- Middleware untuk melindungi halaman internal.
- Eager loading dengan `with()`, `load()`, dan `withCount()`.
- Database transaction untuk menjaga konsistensi transaksi dan stok.
- CSRF protection, password hashing, validation, dan mass-assignment protection.

## Struktur Data Utama

- `users`: akun pengguna aplikasi.
- `buku`: informasi buku dan stok.
- `kategori`: master kategori dinamis.
- `anggota`: informasi anggota perpustakaan.
- `transaksis`: peminjaman, pengembalian, jatuh tempo, status, dan denda.

Relasi utama:

```text
kategori  1 ---- * buku
anggota   1 ---- * transaksis
buku      1 ---- * transaksis
```

## Persyaratan Sistem

Pastikan perangkat sudah memiliki:

- PHP 8.3 atau lebih baru
- Composer
- MySQL/MariaDB
- Node.js dan npm
- Laragon, XAMPP, atau web server setara

## Instalasi dengan Laragon dan MySQL

1. Clone repository dan masuk ke folder proyek.

```bash
git clone https://github.com/USERNAME/perpustakaan.git
cd perpustakaan
```

2. Install dependency PHP dan JavaScript.

```bash
composer install
npm install
```

3. Buat file environment dan application key.

Windows PowerShell:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

4. Buat database kosong, misalnya `perpustakaan_laravel`, lalu sesuaikan `.env`.

```env
APP_NAME="Perpustakaan"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://perpustakaan.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_laravel
DB_USERNAME=root
DB_PASSWORD=
```

5. Jalankan migration dan sample data.

```bash
php artisan migrate --seed
```

6. Hubungkan folder penyimpanan dan build asset.

```bash
php artisan storage:link
npm run build
```

7. Jalankan aplikasi.

Dengan Laragon, buka:

```text
http://perpustakaan.test
```

Atau gunakan server Laravel:

```bash
php artisan serve
```

Kemudian buka `http://127.0.0.1:8000`.

## Akun Pengguna

Seeder proyek tidak membuat akun admin bawaan. Buka halaman `/register` untuk membuat akun pertama, kemudian login menggunakan akun tersebut.

Jangan menaruh password asli atau kredensial produksi di README maupun repository.

## Menjalankan Development Server

Untuk menjalankan server Laravel, queue, log, dan Vite secara bersamaan:

```bash
composer run dev
```

Atau jalankan Vite secara terpisah:

```bash
npm run dev
```

## Menjalankan Test

```bash
php artisan test
```

Test tertentu dapat dijalankan dengan:

```bash
php artisan test --filter=BookUpdateTest
```

## Aturan Bisnis Penting

- Hanya anggota berstatus aktif yang dapat meminjam.
- Hanya buku dengan stok lebih dari nol yang dapat dipinjam.
- Tanggal jatuh tempo ditentukan tujuh hari setelah tanggal pinjam.
- Stok berkurang satu ketika buku dipinjam.
- Stok bertambah satu ketika buku dikembalikan.
- Denda keterlambatan adalah Rp5.000 per hari.
- Transaksi yang sudah dikembalikan tidak dapat dikembalikan untuk kedua kalinya.
- Anggota harus berusia minimal lima tahun.

## Panduan Demo Singkat

1. Register atau login.
2. Tampilkan dashboard.
3. Tambahkan dan cari buku.
4. Tambahkan anggota aktif.
5. Buat peminjaman dan periksa stok berkurang.
6. Kembalikan buku dan periksa stok serta denda.
7. Gunakan Global Search.
8. Filter laporan lalu buka print preview atau export PDF.
9. Logout dan akses kembali route yang dilindungi.

## Keamanan Repository

File `.env`, dependency, log, cache, dan hasil build sudah diabaikan melalui `.gitignore`.

Sebelum publish ke GitHub:

- Pastikan `.env` tidak ikut ter-commit.
- Jangan commit password, API key, atau data pribadi asli.
- Tinjau file backup `.sql` sebelum memasukkannya ke repository.
- Gunakan data dummy untuk screenshot dan demo publik.
- Pada production, gunakan `APP_DEBUG=false`.

## Perintah Berguna

```bash
php artisan route:list
php artisan migrate:status
php artisan optimize:clear
php artisan view:cache
php artisan test
npm run build
```

## Pengembang

Isi bagian berikut sebelum UAS:

- Nama: `NAMA MAHASISWA`
- NIM: `NIM MAHASISWA`
- Mata kuliah: `NAMA MATA KULIAH`
- Institusi: `NAMA INSTITUSI`

---

Dibuat sebagai proyek Sistem Manajemen Perpustakaan berbasis Laravel.
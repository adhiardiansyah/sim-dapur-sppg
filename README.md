# SIM Dapur SPPG

**Sistem Informasi Manajemen Produksi dan Distribusi Dapur SPPG Program Makan Bergizi Gratis Berbasis Web**

Aplikasi ini dibangun sebagai proyek **Capstone Project (STSI4440)** — Program Studi Sistem Informasi, Fakultas Sains dan Teknologi, Universitas Terbuka. Sistem membantu operasional harian Satuan Pelayanan Pemenuhan Gizi (SPPG), yaitu unit dapur pelaksana program Makan Bergizi Gratis (MBG): mulai dari data penerima manfaat, perencanaan menu berbasis referensi gizi, kalkulasi kebutuhan bahan baku otomatis, pengendalian stok, pencatatan produksi, distribusi ke sekolah, hingga pelaporan.

## Kelompok C

| No | Nama | NIM |
|----|------|-----|
| 1 | Giwan Purnama | 051111538 |
| 2 | Manarul Hidayat | 051652509 |
| 3 | Ikhsan Nurcahya Futony | 053250279 |
| 4 | Adhi Ardiansyah | 054151705 |
| 5 | Tegar Laksono Putro | 049831041 |

Tutor: Dr. Ir. Dwi Prasetyo, S.Kom, M.Si.

## Fitur Utama

- **Autentikasi multi-peran** dengan pembatasan akses per menu (middleware `role`).
- **Data master**: pengguna, sekolah/lokasi sasaran, penerima manfaat (siswa, ibu hamil, ibu menyusui, balita), bahan baku beserta kandungan gizi (referensi AKG), dan supplier.
- **Menu & komposisi**: resep bahan per porsi untuk setiap menu.
- **Perencanaan menu harian** dengan **kalkulasi kebutuhan bahan baku otomatis** (jumlah per porsi × total porsi) dan deteksi cukup/kurang terhadap stok.
- **Stok masuk**: pencatatan penerimaan bahan dari supplier, stok bertambah otomatis.
- **Produksi**: realisasi produksi memotong stok otomatis sesuai komposisi; produksi ditolak bila stok tidak cukup; notifikasi stok di bawah minimum.
- **Distribusi**: penjadwalan pengiriman per sekolah (Kepala SPPG) dan pemutakhiran status *dijadwalkan → dikirim → diterima* beserta jam (Petugas Distribusi).
- **Laporan**: produksi, distribusi, stok bahan baku, dan realisasi anggaran (total pengadaan & biaya per porsi), siap cetak.

## Peran Pengguna

| Peran | Hak akses utama |
|-------|-----------------|
| Kepala SPPG (admin) | Kelola pengguna, sekolah & penerima, jadwal distribusi, lihat semua laporan |
| Ahli Gizi | Kelola bahan baku, menu & komposisi, perencanaan menu harian |
| Kepala Dapur | Kelola supplier, catat stok masuk, catat produksi |
| Petugas Distribusi | Perbarui status pengiriman & penerimaan sekolah |

## Teknologi

- [Laravel 13](https://laravel.com) (PHP 8.3)
- MySQL / MariaDB
- [Bootstrap 5.3](https://getbootstrap.com) + Bootstrap Icons (via CDN)
- Pola arsitektur MVC (routing, Eloquent ORM, Blade, middleware peran)

## Persyaratan

- PHP >= 8.2 dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `ctype`, `tokenizer`, `xml`, `fileinfo`
- Composer
- MySQL 8 / MariaDB 10.4+

## Instalasi

```bash
# 1. Masuk ke folder proyek
cd sistem-sppg

# 2. Pasang dependensi
composer install

# 3. Siapkan file lingkungan
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database pada .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=sistem_sppg
#    DB_USERNAME=<user>
#    DB_PASSWORD=<kata sandi>

# 5. Buat skema database + data awal (akun contoh, menu, bahan, resep)
php artisan migrate --seed

# 6. Jalankan server pengembangan
php artisan serve
```

Buka <http://127.0.0.1:8000> pada peramban.

## Akun Uji

Kata sandi seluruh akun: **`password`**

| Email | Peran |
|-------|-------|
| kepala@sppg.test | Kepala SPPG (administrator) |
| ahli@sppg.test | Ahli Gizi |
| dapur@sppg.test | Kepala Dapur |
| petugas@sppg.test | Petugas Distribusi |

## Alur Kerja Harian

1. **Ahli Gizi** menyusun perencanaan menu harian dan jumlah porsi → sistem menghitung kebutuhan bahan otomatis.
2. **Kepala Dapur** mencatat penerimaan bahan dari supplier → stok bertambah.
3. **Kepala Dapur** mencatat realisasi produksi → stok berkurang otomatis; muncul peringatan bila stok di bawah minimum.
4. **Kepala SPPG** menjadwalkan distribusi per sekolah; **Petugas** memperbarui status hingga diterima.
5. **Semua peran** memantau dashboard dan mencetak laporan operasional.

## Struktur Penting

```
app/Http/Controllers/     Controller per modul (UserController, MenuController, ProduksiController, ...)
app/Http/Middleware/      EnsureRole (pembatasan akses per peran)
app/Models/               11 model Eloquent + relasi
database/migrations/      Skema basis data (11 tabel aplikasi)
database/seeders/         Data awal (akun, sekolah, bahan, menu, jadwal contoh)
resources/views/          Antarmuka Blade + Bootstrap (layout, auth, modul, laporan)
routes/web.php            Definisi rute dan pembatasan peran
```

## Catatan

- Data bawaan (seeder) bersifat contoh untuk keperluan demonstrasi dan pengujian.
- Proyek ini merupakan karya akademik untuk mata kuliah STSI4440 Capstone Project Universitas Terbuka dan tidak digunakan untuk tujuan komersial.

## Deployment Gratis (Render + Neon)

Aplikasi dapat dideploy gratis menggunakan **Render** (aplikasi web, Docker) dan **Neon** (basis data PostgreSQL):

1. Buat akun di [neon.tech](https://neon.tech) (login via GitHub), buat proyek, lalu salin *connection string* PostgreSQL.
2. Buat akun di [render.com](https://render.com) (login via GitHub), lalu **New → Web Service** dan hubungkan repositori ini (runtime Docker terdeteksi otomatis).
3. Isi *Environment Variables*:

   | Kunci | Nilai |
   |-------|-------|
   | `APP_KEY` | kunci hasil `php artisan key:generate --show` |
   | `APP_ENV` | `production` |
   | `APP_DEBUG` | `false` |
   | `DB_CONNECTION` | `pgsql` |
   | `DB_URL` | *connection string* Neon (`postgresql://...`) |
   | `DB_SSLMODE` | `require` |
   | `SESSION_DRIVER` | `database` |
   | `CACHE_STORE` | `database` |

4. Aktifkan *Health Check Path* `/up`, lalu deploy. Migrasi dan data awal (akun uji, contoh data) berjalan otomatis saat aplikasi pertama kali dijalankan.

Catatan: pada layanan gratis Render, aplikasi "tidur" setelah ±15 menit tanpa akses (akses pertama berikutnya lebih lambat ±30–60 detik).

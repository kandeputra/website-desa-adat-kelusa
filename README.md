# Website Desa Adat Kelusa

Website resmi Desa Adat Kelusa, Kecamatan Payangan, Kabupaten Gianyar, Bali. Dibangun dengan **Laravel 11 + MySQL**, dilengkapi panel admin dengan dua peran: **Super Admin** dan **Admin**.

Tampilan bernuansa api dan prada: hitam eboni, emas prada, cahaya bara, di atas warna batu paras, bata, dan hijau daun. Ornamen tumpal, motif patra, gapura candi bentar, serta tanggal pawukon dihitung otomatis.

---

## Fitur

**Situs publik**
- Beranda: sambutan Bendesa, berita utama, pengumuman, produk hukum, agenda, rerahinan terdekat, objek wisata, galeri, dan FAQ
- Tentang Desa: sejarah dan linimasa, visi misi, demografi per banjar, struktur prajuru, banjar adat, prestasi
- Lembaga Adat: halaman untuk setiap lembaga (LPD, BUPDA, Pecalang, Sabha Desa, Kertha Desa, dan lainnya)
- Keagamaan: Pura Hyang Api, kalender rerahinan pawukon (otomatis), budaya dan tradisi
- Pariwisata: objek wisata dan panduan berkunjung dengan peta
- Laporan: keuangan per tahun, perencanaan, dan pembangunan
- Informasi: berita, pengumuman, agenda, produk hukum (unduh PDF), perpustakaan digital, galeri foto dan video YouTube, pencarian
- Layanan: **pengaduan krama dengan kode tiket**. Krama bisa mengecek status dan tanggapan prajuru memakai kode tersebut.

**Panel admin** (`/admin`)

| Modul | Admin | Super Admin |
|---|:-:|:-:|
| Berita, Pengumuman, Budaya & Tradisi | ✓ | ✓ |
| Agenda, Galeri, Objek Wisata, FAQ, Perpustakaan, Prestasi | ✓ | ✓ |
| Pengaduan Krama (menanggapi & mengubah status) | ✓ | ✓ |
| Prajuru, Banjar & Demografi, Lembaga Adat | – | ✓ |
| Produk Hukum, Laporan Keuangan, Perencanaan & Pembangunan | – | ✓ |
| Pengguna (buat, ubah peran, nonaktifkan akun) | – | ✓ |
| Pengaturan Situs (identitas, sambutan, sejarah, visi misi, kontak, media sosial, foto beranda) | – | ✓ |

Fitur lain di panel admin:
- Penyunting teks dengan tombol format dan pratinjau
- Unggah gambar dan PDF
- Draf dan jadwal terbit
- Berita utama
- Pencarian dan filter
- Dasbor ringkasan, termasuk jumlah pengaduan baru

Pengamanan:
- Super Admin tidak bisa menurunkan perannya sendiri atau menghapus Super Admin terakhir.
- Akun yang dinonaktifkan langsung keluar dari panel.
- Batas jumlah percobaan login dan pengiriman pengaduan.
- Halaman admin tidak diindeks mesin pencari.

---

## Kebutuhan server

- PHP **8.2** atau lebih baru, dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `gd`
- MySQL 5.7+ atau MariaDB 10.3+
- Composer (atau gunakan paket ZIP siap unggah yang sudah berisi folder `vendor`)

---

## Instalasi di komputer (lokal)

```bash
git clone https://github.com/kandeputra/website-desa-adat-kelusa.git
cd website-desa-adat-kelusa
composer install
cp .env.example .env
php artisan key:generate
# buat database MySQL "desa_adat_kelusa", lalu sesuaikan DB_* di .env
php artisan migrate --seed
php artisan serve
```

Buka `http://127.0.0.1:8000`. Panel admin ada di `http://127.0.0.1:8000/admin`.

---

## Pemasangan di hosting cPanel

1. **Buat database:** di cPanel, buka *MySQL Databases*, buat database dan user, lalu beri user itu semua hak (*ALL PRIVILEGES*).
2. **Unggah berkas:** unggah semua isi proyek ke folder di luar `public_html`, misalnya `/home/akunanda/kelusa`.
   - Jika hosting punya **Terminal/SSH**, jalankan `composer install --no-dev --optimize-autoloader` di folder itu.
   - Jika tidak ada SSH, gunakan **paket ZIP siap unggah**, yang sudah berisi folder `vendor`.
3. **Arahkan domain** ke folder `public`. Pilih salah satu cara:
   - **Cara A (disarankan):** di cPanel, buka *Domains*, lalu ubah *Document Root* domain menjadi `/home/akunanda/kelusa/public`.
   - **Cara B:** jika document root tidak bisa diubah, unggah seluruh proyek ke dalam `public_html`. Berkas `.htaccess` di root proyek akan meneruskan semua permintaan ke folder `public/` secara otomatis.
4. **Atur `.env`:** salin `.env.example` menjadi `.env`, lalu isi:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://desaadatkelusa.or.id
   DB_DATABASE=nama_database
   DB_USERNAME=user_database
   DB_PASSWORD=sandi_database
   SUPERADMIN_EMAIL=email-anda@contoh.id
   SUPERADMIN_PASSWORD=sandi-kuat-anda
   ```
5. **Jalankan perintah awal** di Terminal cPanel:
   ```bash
   php artisan key:generate
   php artisan migrate --seed --force
   php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```
   Tanpa Terminal: impor `database/kelusa.sql` lewat phpMyAdmin, lalu isi `APP_KEY` di `.env` dengan kunci yang dibuat dari komputer lokal (`php artisan key:generate --show`).
6. Pastikan folder `storage/`, `bootstrap/cache/`, dan `public/uploads/` bisa ditulisi (izin 755 atau 775).

---

## Akun awal

Seeder membuat dua akun:

| Peran | Email | Kata sandi |
|---|---|---|
| Super Admin | `SUPERADMIN_EMAIL` di `.env` (bawaan: superadmin@desaadatkelusa.or.id) | `SUPERADMIN_PASSWORD` di `.env` |
| Admin | admin@desaadatkelusa.or.id | AdminKelusa!2026 |

> **Penting:** segera ganti kata sandi kedua akun melalui menu **Profil & kata sandi** setelah masuk pertama kali. Akun Admin contoh bisa dinonaktifkan atau dihapus dari menu **Pengguna**.

Konten awal sudah terisi: sejarah, 12 lembaga adat, Pura Hyang Api, 3 artikel tradisi, FAQ, dan rujukan jurnal. Berita, pengumuman, dan agenda awal hanya contoh; ganti dari panel admin.

---

## Struktur penting

```
app/Http/Controllers/SiteController.php      halaman publik
app/Http/Controllers/Admin/                  panel admin (login, dasbor, modul, pengguna, pengaturan)
app/Http/Middleware/Peran.php                pembatasan Super Admin
app/Support/Pawukon.php                      kalender pawukon Bali (wuku, saptawara, pancawara, rerahinan)
config/admin.php                             daftar modul admin, field formulir, dan hak akses per peran
database/seeders/DatabaseSeeder.php          isi awal situs
resources/views/situs/                       tampilan publik
resources/views/admin/                       tampilan panel admin
public/css/situs.css, public/css/admin.css   gaya tampilan
public/uploads/                              berkas yang diunggah admin
```

Untuk **menambah modul admin baru**: buat migrasi dan model, lalu tambahkan satu entri di `config/admin.php`. Formulir, daftar, pencarian, unggahan, dan hak aksesnya akan dibuat otomatis.

---

## Cadangan

Cadangkan secara berkala:
- database, lewat *phpMyAdmin → Export* atau fitur *Backup* cPanel;
- folder `public/uploads/`.

---

Om Shanti Shanti Shanti Om

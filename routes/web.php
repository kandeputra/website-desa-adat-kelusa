<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\SiteController as S;
use Illuminate\Support\Facades\Route;

/* ================= Situs publik ================= */
Route::get('/', [S::class, 'home'])->name('home');

Route::prefix('tentang')->group(function () {
    Route::get('sejarah', [S::class, 'sejarah'])->name('sejarah');
    Route::get('visi-misi', [S::class, 'visiMisi'])->name('visi-misi');
    Route::get('demografi', [S::class, 'demografi'])->name('demografi');
    Route::get('prajuru', [S::class, 'prajuru'])->name('prajuru');
    Route::get('banjar', [S::class, 'banjar'])->name('banjar');
    Route::get('prestasi', [S::class, 'prestasi'])->name('prestasi');
});

Route::get('lembaga', [S::class, 'lembagaIndex'])->name('lembaga.index');
Route::get('lembaga/{lembaga}', [S::class, 'lembagaShow'])->name('lembaga.show');

Route::get('pura', [S::class, 'pura'])->name('pura');
Route::get('kalender', [S::class, 'kalender'])->name('kalender');
Route::get('budaya', [S::class, 'artikelIndex'])->name('artikel.index');
Route::get('budaya/{post}', [S::class, 'artikelShow'])->name('artikel.show');

Route::get('wisata', [S::class, 'wisataIndex'])->name('wisata.index');
Route::get('wisata/{wisata}', [S::class, 'wisataShow'])->name('wisata.show');
Route::get('berkunjung', [S::class, 'berkunjung'])->name('berkunjung');

Route::get('laporan/keuangan', [S::class, 'laporanKeuangan'])->name('laporan.keuangan');
Route::get('laporan/perencanaan', [S::class, 'laporanPerencanaan'])->name('laporan.perencanaan');
Route::get('laporan/pembangunan', [S::class, 'laporanPembangunan'])->name('laporan.pembangunan');

Route::get('berita', [S::class, 'beritaIndex'])->name('berita.index');
Route::get('berita/{post}', [S::class, 'beritaShow'])->name('berita.show');
Route::get('pengumuman', [S::class, 'pengumumanIndex'])->name('pengumuman.index');
Route::get('pengumuman/{post}', [S::class, 'pengumumanShow'])->name('pengumuman.show');
Route::get('agenda', [S::class, 'agenda'])->name('agenda');
Route::get('produk-hukum', [S::class, 'produkHukum'])->name('produk-hukum');
Route::get('perpustakaan', [S::class, 'perpustakaan'])->name('perpustakaan');
Route::get('galeri/foto', [S::class, 'galeriFoto'])->name('galeri.foto');
Route::get('galeri/video', [S::class, 'galeriVideo'])->name('galeri.video');
Route::get('cari', [S::class, 'cari'])->name('cari');

Route::get('faq', [S::class, 'faq'])->name('faq');
Route::get('kontak', [S::class, 'kontak'])->name('kontak');
Route::get('pengaduan', [S::class, 'pengaduanCreate'])->name('pengaduan.create');
Route::post('pengaduan', [S::class, 'pengaduanStore'])->middleware('throttle:5,10')->name('pengaduan.store');

/* ================= Panel admin ================= */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('masuk', [Admin\AuthController::class, 'form'])->name('login');
        Route::post('masuk', [Admin\AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.post');
    });

    Route::middleware(['auth', 'aktif'])->group(function () {
        Route::post('keluar', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('profil', [Admin\ProfilController::class, 'edit'])->name('profil');
        Route::put('profil', [Admin\ProfilController::class, 'update'])->name('profil.update');

        // Hanya Super Admin
        Route::middleware('peran:super_admin')->group(function () {
            Route::resource('pengguna', Admin\UserController::class)->except('show')->parameters(['pengguna' => 'user']);
            Route::get('pengaturan', [Admin\SettingController::class, 'edit'])->name('pengaturan');
            Route::put('pengaturan', [Admin\SettingController::class, 'update'])->name('pengaturan.update');
        });

        // Modul konten: hak akses per modul diatur di config/admin.php
        Route::get('{modul}', [Admin\ResourceController::class, 'index'])->name('r.index');
        Route::get('{modul}/tambah', [Admin\ResourceController::class, 'create'])->name('r.create');
        Route::post('{modul}', [Admin\ResourceController::class, 'store'])->name('r.store');
        Route::get('{modul}/{id}/ubah', [Admin\ResourceController::class, 'edit'])->whereNumber('id')->name('r.edit');
        Route::put('{modul}/{id}', [Admin\ResourceController::class, 'update'])->whereNumber('id')->name('r.update');
        Route::delete('{modul}/{id}', [Admin\ResourceController::class, 'destroy'])->whereNumber('id')->name('r.destroy');
    });
});

<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\JadwalMenuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\MenuKomposisiController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(auth()->check() ? 'dashboard' : 'login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:kepala_sppg')->group(function () {
        Route::resource('users', UserController::class)->parameters(['users' => 'user']);
        Route::resource('sekolah', SekolahController::class)->parameters(['sekolah' => 'sekolah']);
        Route::resource('penerima', PenerimaController::class)->parameters(['penerima' => 'penerima']);
    });


    Route::middleware('role:ahli_gizi')->group(function () {
        Route::resource('bahan', BahanBakuController::class)->parameters(['bahan' => 'bahan']);
        Route::resource('menu', MenuController::class)->parameters(['menu' => 'menu']);
        Route::post('menu/{menu}/komposisi', [MenuKomposisiController::class, 'store'])->name('menu.komposisi.store');
        Route::delete('menu/{menu}/komposisi/{komposisi}', [MenuKomposisiController::class, 'destroy'])->name('menu.komposisi.destroy');
        Route::resource('jadwal', JadwalMenuController::class)->parameters(['jadwal' => 'jadwal']);
        Route::get('jadwal/{jadwal}/kebutuhan', [JadwalMenuController::class, 'kebutuhan'])->name('jadwal.kebutuhan');
    });

    Route::middleware('role:kepala_dapur')->group(function () {
        Route::resource('supplier', SupplierController::class)->parameters(['supplier' => 'supplier']);
        Route::resource('stok-masuk', StokMasukController::class)
            ->parameters(['stok-masuk' => 'stokMasuk'])
            ->only(['index', 'create', 'store', 'destroy']);
        Route::resource('produksi', ProduksiController::class)
            ->parameters(['produksi' => 'produksi'])
            ->only(['index', 'create', 'store']);
        Route::post('produksi/{produksi}/selesai', [ProduksiController::class, 'selesai'])->name('produksi.selesai');
    });

    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('distribusi', [DistribusiController::class, 'index'])->name('distribusi.index');
    Route::middleware('role:kepala_sppg')->group(function () {
        Route::get('distribusi/buat', [DistribusiController::class, 'create'])->name('distribusi.create');
        Route::post('distribusi', [DistribusiController::class, 'store'])->name('distribusi.store');
        Route::delete('distribusi/{distribusi}', [DistribusiController::class, 'destroy'])
            ->name('distribusi.destroy')->middleware('role:kepala_sppg');
    });
    Route::middleware('role:petugas')->group(function () {
        Route::post('distribusi/{distribusi}/kirim', [DistribusiController::class, 'kirim'])->name('distribusi.kirim');
        Route::post('distribusi/{distribusi}/terima', [DistribusiController::class, 'terima'])->name('distribusi.terima');
    });
});

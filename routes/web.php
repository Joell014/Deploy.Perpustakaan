<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Halaman publik (Modul 1-4)
Route::get('/', fn () => view('home'))->name('home');

// Semua halaman di bawah ini wajib login
Route::middleware('auth')->group(function () {

    Route::middleware('can:kelola-buku')->group(function () {
        Route::get('/kelola/buku', [BukuController::class, 'kelola'])->name('buku.kelola');
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{id_buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{id_buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id_buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });


    // Router dashboard: arahkan sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))
        ->middleware('permission:akses dashboard admin')
        ->name('admin.dashboard');

    Route::get('/petugas/dashboard', fn () => view('petugas.dashboard'))
        ->middleware('permission:akses dashboard petugas')
        ->name('petugas.dashboard');

    // Profil: hanya milik sendiri (ProfileController memakai $request->user())
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah profil sendiri')->name('profile.destroy');

    // Kelola buku (Admin + Petugas). HARUS sebelum /buku/{id_buku}
    Route::middleware('can:kelola-buku')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{id_buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{id_buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id_buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });

    Route::get('/kelola/buku', [BukuController::class, 'kelola'])->name('buku.kelola');

    // Kelola pengguna dan role (Admin saja)
    Route::middleware('permission:kelola data pengguna')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')->name('users.role');
    });

    // Peminjaman dan pengembalian (Admin + Petugas)
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->middleware('permission:kelola peminjaman')->name('peminjaman.index');

    // Laporan (Admin + Petugas)
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')->name('laporan.index');

    // Riwayat milik sendiri (semua role)
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')->name('riwayat.index');

    Route::get('/riwayat/{anggota}', [PeminjamanController::class, 'lihatRiwayat'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')->name('riwayat.show');
    
    Route::post('/buku/{id_buku}/ajukan', [PeminjamanController::class, 'ajukan'])
        ->middleware('permission:mengajukan peminjaman buku')->name('peminjaman.ajukan');
    
    Route::post('/peminjaman/{peminjaman}/setujui', [PeminjamanController::class, 'setujui'])
        ->middleware('permission:memproses persetujuan peminjaman')->name('peminjaman.setujui');
    
    Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->middleware('permission:mencatat pengembalian buku')->name('peminjaman.kembalikan');


        
    // A4 RENTAN
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    // A2: pencarian buku (versi aman, query dengan binding)
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');
});

// Daftar dan detail buku: perlu login + permission
Route::middleware(['auth', 'permission:lihat daftar buku'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id_buku}', [BukuController::class, 'show'])->name('buku.show');
});

// SEMENTARA: hapus setelah screenshot
Route::get('/demo/error', function () {
    throw new RuntimeException('contoh nomer 5 yang app debug ');
});
require __DIR__.'/auth.php';
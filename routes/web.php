<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

// Grup Rute untuk Pengunjung (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'loginProcess'])->name('auth');
});

// Grup Rute untuk Pengguna yang Sudah Login
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Khusus Admin (Manajemen User)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Menggunakan resource otomatis membuat admin.users.index, admin.users.create, dll.
        Route::resource('users', UserController::class);
    });

    // Akses untuk Admin dan Kasir
    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('/produk', ProdukController::class);
        Route::resource('/penjualan', PenjualanController::class);
        Route::resource('/itempenjualan', ItemPenjualanController::class);
          Route::get('/tentang', function () {
            return view('tentang');
          })->name('tentang');
    });
    
});

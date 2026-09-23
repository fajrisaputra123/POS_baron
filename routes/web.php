<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;


// Route Halaman Utama (Redirect ke Login / Dashboard)
Route::get('/', function () {
    return redirect()->route('login');
});

// Route yang hanya bisa diakses ketika user BELUM login 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
});

// Route yang hanya bisa diakses ketika user SUDAH login 
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route Halaman Tentang
    Route::get('/tentang', function () {
        return view('tentang');
    })->name('tentang');

    Route::get('/laporan/data', [LaporanController::class, 'data'])
    ->name('laporan.data')
    ->middleware('auth');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route khusus Manajemen User (Admin & Kasir)
    Route::middleware('role:admin,kasir')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Route Transaksi & Master Data
    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('/produk', ProdukController::class);
        
        // --- ROUTE TAMBAHAN UNTUK PENJUALAN ---
        Route::get('/penjualan/{id}/cetak', [PenjualanController::class, 'cetakStruk'])->name('penjualan.cetak');
        Route::post('/penjualan/{penjualan}/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
        Route::get('/laporan-penjualan', [PenjualanController::class, 'laporan'])->name('laporan.penjualan');

        // --- ROUTE LAPORAN PENJUALAN ---
        Route::get('/laporan-penjualan', [PenjualanController::class, 'laporan'])->name('laporan.penjualan');
        Route::get('/laporan-penjualan/export', [PenjualanController::class, 'exportLaporan'])->name('laporan.penjualan.export');
        Route::get('/laporan-penjualan/cetak', [PenjualanController::class, 'cetakLaporan'])->name('laporan.penjualan.cetak');
        
        Route::resource('/penjualan', PenjualanController::class);
        Route::resource('/item-penjualan', ItemPenjualanController::class);
        Route::resource('jenis', JenisController::class)->parameters([
            'jenis' => 'jenis'
        ]);
    });
});
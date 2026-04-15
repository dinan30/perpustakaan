<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

// Grup Route yang memerlukan Login
Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * ROUTE UTAMA DASHBOARD (The Redirector)
     */
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'super_admin' || $user->role === 'operator') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('siswa.dashboard');
    })->name('dashboard');

    /**
     * ROUTE KHUSUS ADMIN & PETUGAS
     */
    Route::middleware(['role:admin,super_admin,operator'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [PerpustakaanController::class, 'adminDashboard'])
            ->name('admin.dashboard');

        Route::resource('users', UserController::class);
        Route::resource('buku', BukuController::class);
        Route::resource('transaksi', TransaksiController::class);
        Route::post('/transaksi/{id}/kembali', [TransaksiController::class, 'kembali'])->name('transaksi.kembali');
        Route::put('/transaksi/{id}/setujui', [TransaksiController::class, 'setujui'])->name('transaksi.setujui');
        Route::put('/transaksi/{id}/tolak', [TransaksiController::class, 'tolak'])->name('transaksi.tolak');
    });

    /**
     * ROUTE KHUSUS SISWA
     */
    /**
     * ROUTE KHUSUS SISWA
     */
    Route::middleware(['role:siswa'])->prefix('siswa')->group(function () {
        Route::get('/dashboard', [PerpustakaanController::class, 'siswaDashboard'])->name('siswa.dashboard');
        Route::get('/peminjaman', [PerpustakaanController::class, 'peminjaman'])->name('siswa.peminjaman');
        Route::post('/peminjaman/store', [PerpustakaanController::class, 'store_peminjaman'])->name('siswa.pinjam');
        Route::put('/kembali/{id}', [PerpustakaanController::class, 'kembalikanBuku'])->name('siswa.kembali');

        // TAMBAHKAN BARIS INI:
        Route::get('/riwayat', [PerpustakaanController::class, 'riwayatPeminjaman'])->name('siswa.riwayat');
    });
});

/**
 * ROUTE PROFILE (Bawaan Laravel Breeze)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
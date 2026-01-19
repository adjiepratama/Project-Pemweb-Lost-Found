<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminController;

// 1. HALAMAN UTAMA (Supaya localhost:8000 tidak 404)
// ... imports ...

// 1. HALAMAN DEPAN (ROOT)
// Kembalikan ke logika awal: Selalu arahkan ke Login
Route::get('/', function () {
    return redirect()->route('login');
});
// ... sisa route lainnya tetap sama ...

// 2. ROUTE TAMU (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// 3. ROUTE ADMIN (Grouped & Named)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Menu Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/kelola-barang', [AdminController::class, 'kelolaBarang'])->name('kelola.barang');
    Route::get('/laporan-temuan', [AdminController::class, 'laporanTemuan'])->name('laporan.temuan');
    Route::get('/verifikasi-klaim', [AdminController::class, 'verifikasiKlaim'])->name('verifikasi.klaim');

    // CRUD Barang
    Route::post('/barang/store', [AdminController::class, 'storeBarang'])->name('barang.store');
    Route::put('/barang/{id}', [AdminController::class, 'updateBarang'])->name('barang.update');
    Route::delete('/barang/{id}', [AdminController::class, 'destroyBarang'])->name('barang.destroy');

    // Action Khusus (Review & Verifikasi)
    Route::put('/item-status/{id}', [AdminController::class, 'updateItemStatus'])->name('item.update');
    Route::put('/klaim/{id}', [AdminController::class, 'updateClaimStatus'])->name('claim.update');

    // Profile Routes
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [AdminController::class, 'updatePassword'])->name('password.update');
});

// 4. ROUTE USER (Mahasiswa)
Route::middleware(['auth', 'role:user'])->group(function () {
    
    // Dashboard & Search
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/user/dashboard/image-search', [UserDashboardController::class, 'searchImage'])->name('user.image.search');
    Route::get('/user/dashboard/image-search', function() { return redirect()->route('user.dashboard'); });

    // Klaim Barang
    Route::post('/claim/store', [ClaimController::class, 'store'])->name('claim.store');
    Route::delete('/user/claim/{id}', [UserDashboardController::class, 'destroyClaim'])->name('user.claim.destroy');

    // Lapor Barang
    Route::get('/user/lapor-barang', [UserDashboardController::class, 'showLapor'])->name('user.lapor');
    Route::post('/user/lapor-barang', [UserDashboardController::class, 'storeLapor'])->name('user.lapor.store');
    Route::put('/user/lapor/{id}', [UserDashboardController::class, 'update'])->name('user.lapor.update');
    Route::delete('/user/lapor/{id}', [UserDashboardController::class, 'destroy'])->name('user.lapor.destroy');

    // Riwayat & Profile
    Route::get('/user/riwayat', [UserDashboardController::class, 'history'])->name('user.history');
    Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile', [UserProfileController::class, 'updateProfile'])->name('user.profile.update'); 
    Route::put('/user/password', [UserProfileController::class, 'updatePassword'])->name('user.password.update');

    // Notifikasi
    Route::get('/mark-as-read', function () {
        if(auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return redirect()->back();
    })->name('markAsRead');
});

// 5. LOGOUT
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
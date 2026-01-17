<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ClaimController;
 use App\Http\Controllers\UserProfileController;
 use App\Http\Controllers\AdminController;

// ==========================================
// ROUTE TAMU (GUEST) - Login/Register
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ==========================================
// ROUTE ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Aksi Update Status
    Route::put('/item/{id}/update', [AdminController::class, 'updateItemStatus'])->name('admin.item.update');
    Route::put('/claim/{id}/update', [AdminController::class, 'updateClaimStatus'])->name('admin.claim.update');

});

// ==========================================
// ROUTE USER (Mahasiswa)
// ==========================================
Route::middleware(['auth', 'role:user'])->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // 2. Proses Klaim Barang (Pop-up)
    Route::post('/claim/store', [ClaimController::class, 'store'])->name('claim.store');

    // 3. Search Gambar (Logic Upload)
    Route::post('/user/dashboard/image-search', [UserDashboardController::class, 'searchImage'])->name('user.image.search');

    // 4. Search Gambar (Safety Redirect - Biar ga error kalau di-refresh)
    Route::get('/user/dashboard/image-search', function() {
        return redirect()->route('user.dashboard');
    });

    // ==========================================
    // FITUR LAPOR BARANG
    // ==========================================
    
    // Menampilkan Halaman Form Lapor
    Route::get('/user/lapor-barang', [UserDashboardController::class, 'showLapor'])->name('user.lapor');

    // Memproses Data Laporan ke Database
    Route::post('/user/lapor-barang', [UserDashboardController::class, 'storeLapor'])->name('user.lapor.store');

    // ==========================================
    // FITUR RIWAYAT (YANG BIKIN ERROR TADI)
    // ==========================================
   // ... route history yang sudah ada ...
    Route::get('/user/riwayat', [UserDashboardController::class, 'history'])->name('user.history');

    // --- TAMBAHAN BARU (CRUD) ---
    Route::put('/user/lapor/{id}', [UserDashboardController::class, 'update'])->name('user.lapor.update');
    Route::delete('/user/lapor/{id}', [UserDashboardController::class, 'destroy'])->name('user.lapor.destroy');

    // TAMBAHKAN INI: Route untuk Batalkan Klaim
    Route::delete('/user/claim/{id}', [UserDashboardController::class, 'destroyClaim'])->name('user.claim.destroy');


    // --- ROUTE PROFILE ---
// Route Profile
Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
// PENTING: Route ini harus ada lagi untuk proses upload foto
Route::put('/user/profile', [UserProfileController::class, 'updateProfile'])->name('user.profile.update'); 
// Route Ganti Password
Route::put('/user/password', [UserProfileController::class, 'updatePassword'])->name('user.password.update');

// --- ROUTE NOTIFICATION ---
Route::get('/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');

});




// ==========================================
// LOGOUT
// ==========================================
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
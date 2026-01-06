<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

// Route Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Route Admin (Hanya bisa diakses role admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "<h1>Halo Admin!</h1> <a href='/logout'>Logout</a>";
    });
});

// Route User (Hanya bisa diakses role user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return "<h1>Halo User!</h1> <a href='/logout'>Logout</a>";
    });
});

// Route User (Hanya bisa diakses role user)
Route::middleware(['auth', 'role:user'])->group(function () {
    
    // Panggil Controller, bukan function() biasa lagi
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

});



// Logout
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');



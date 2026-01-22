<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporController; 

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/kelola-barang', [AdminController::class, 'kelolaBarang'])->name('kelola.barang');
    Route::get('/laporan-temuan', [AdminController::class, 'laporanTemuan'])->name('laporan.temuan');
    Route::get('/verifikasi-klaim', [AdminController::class, 'verifikasiKlaim'])->name('verifikasi.klaim');

    Route::post('/barang/store', [AdminController::class, 'storeBarang'])->name('barang.store');
    Route::put('/barang/{id}', [AdminController::class, 'updateBarang'])->name('barang.update');
    Route::delete('/barang/{id}', [AdminController::class, 'destroyBarang'])->name('barang.destroy');

    Route::put('/item-status/{id}', [AdminController::class, 'updateItemStatus'])->name('item.update');
    Route::put('/klaim/{id}', [AdminController::class, 'updateClaimStatus'])->name('claim.update');


    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [AdminController::class, 'updatePassword'])->name('password.update');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/user/dashboard/image-search', [UserDashboardController::class, 'searchImage'])->name('user.image.search');
    Route::get('/user/dashboard/image-search', function() { return redirect()->route('user.dashboard'); });

    Route::post('/claim/store', [ClaimController::class, 'store'])->name('claim.store');
    Route::delete('/user/claim/{id}', [UserDashboardController::class, 'destroyClaim'])->name('user.claim.destroy');

    Route::get('/user/lapor-barang', [LaporController::class, 'create'])->name('user.lapor');
    Route::post('/user/lapor-barang', [LaporController::class, 'store'])->name('user.lapor.store');
    Route::put('/user/lapor/{id}', [LaporController::class, 'update'])->name('user.lapor.update');
    Route::delete('/user/lapor/{id}', [LaporController::class, 'destroy'])->name('user.lapor.destroy');

    Route::get('/user/riwayat', [UserDashboardController::class, 'history'])->name('user.history');
    Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile', [UserProfileController::class, 'updateProfile'])->name('user.profile.update'); 
    Route::put('/user/password', [UserProfileController::class, 'updatePassword'])->name('user.password.update');

    Route::get('/mark-as-read', [UserDashboardController::class, 'markAsRead'])->name('markAsRead');
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/fix-hashes', function () {
    $items = \App\Models\Item::whereNull('image_hash')->get();
    
    $count = 0;
    foreach ($items as $item) {
        $path = null;
        if (file_exists(storage_path('app/public/' . $item->image))) {
            $path = storage_path('app/public/' . $item->image);
        } elseif (file_exists(public_path($item->image))) {
            $path = public_path($item->image);
        }

        if ($path) {
            $type = exif_imagetype($path);
            $img = null;
            switch ($type) {
                case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($path); break;
                case IMAGETYPE_PNG:  $img = imagecreatefrompng($path); break;
                case IMAGETYPE_WEBP: $img = imagecreatefromwebp($path); break;
            }

            if ($img) {
                $resized = imagecreatetruecolor(8, 8);
                imagecopyresampled($resized, $img, 0, 0, 0, 0, 8, 8, imagesx($img), imagesy($img));
                imagefilter($resized, IMG_FILTER_GRAYSCALE);
                $totalColor = 0; $pixels = [];
                for ($y = 0; $y < 8; $y++) {
                    for ($x = 0; $x < 8; $x++) {
                        $rgb = imagecolorat($resized, $x, $y);
                        $gray = $rgb & 0xFF; $pixels[] = $gray; $totalColor += $gray;
                    }
                }
                $average = $totalColor / 64;
                $hash = '';
                foreach ($pixels as $pixel) { $hash .= ($pixel >= $average) ? '1' : '0'; }
                
                imagedestroy($img);
                imagedestroy($resized);

                $item->update(['image_hash' => $hash]);
                $count++;
            }
        }
    }
    
    return "Selesai! Berhasil meng-update hash untuk $count barang lama.";
});
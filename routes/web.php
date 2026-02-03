<?php

use App\Http\Controllers\Admin\AspirasiController as AdminAspirasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Siswa\AspirasiController as SiswaAspirasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->check()) {
        return auth()->user()->role == 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('siswa.dashboard');
    }
    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup route untuk siswa
Route::middleware(['auth', 'verified', 'is_siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');

    Route::resource('aspirasi', SiswaAspirasiController::class);
});

// Grup route untuk admin
Route::middleware(['auth', 'verified', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk statistik
    Route::get('/statistik', [DashboardController::class, 'statistik'])->name('statistik.index');

    // Route untuk ekspor data
    Route::get('/export', [DashboardController::class, 'exportData'])->name('export.data');

    // Route untuk aspirasi admin
    Route::get('/aspirasi', [AdminAspirasiController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{aspirasi}', [AdminAspirasiController::class, 'show'])->name('aspirasi.show');
    Route::put('/aspirasi/{aspirasi}/status', [AdminAspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');
    Route::post('/aspirasi/{aspirasi}/progress', [AdminAspirasiController::class, 'addProgress'])->name('aspirasi.addProgress');
    Route::post('/aspirasi/{aspirasi}/feedback', [AdminAspirasiController::class, 'addFeedback'])->name('aspirasi.addFeedback');
});

// Route untuk profile (dari Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

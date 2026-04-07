<?php

use App\Http\Controllers\aspirasiController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {
    Route::get('/', function () { return redirect('/login'); });
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'authenticate']);
});


Route::post('/logout', [loginController::class, 'logout'])->middleware('auth');

Route::get('/dashboard-redirect', function () {
    if (Auth::user()->role === 'admin') {
        return redirect('/admin');
    }
    return redirect('/aspirasi');
})->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [adminController::class, 'index'])->name('admin.index');
    Route::post('/admin/update/{id}', [adminController::class, 'update'])->name('admin.update');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/p-siswa/create', [aspirasiController::class, 'create'])->name('aspirasi.create'); // Form Pengaduan
    Route::get('/aspirasi', [aspirasiController::class, 'index'])->name('aspirasi.status');      // Daftar Status
    Route::post('/aspirasi', [aspirasiController::class, 'store']); // Simpan Pengaduan
});

Route::get('/logout-force', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});
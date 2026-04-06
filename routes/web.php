<?php
use App\Http\Controllers\aspirasiController;
use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Auth;

// Rute Login
Route::get('/login', [loginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [loginController::class, 'authenticate']);
Route::post('/logout', [loginController::class, 'logout']);

// Rute Admin
Route::middleware('auth')->group(function () {
    Route::get('/admin', [adminController::class, 'index'])->name('admin.index');
    Route::post('/admin/aspirasi/update/{id}', [adminController::class, 'updateStatus'])->name('admin.update');
});

// Rute Pengaduan Siswa
Route::get('/aspirasi', [aspirasiController::class, 'index']);
Route::post('/aspirasi', [aspirasiController::class, 'store']);
Route::post('/aspirasi/{id}',[aspirasiController::class, 'update']);

// Rute untuk halaman membuat laporan siswa
Route::get('/p-siswa/create', function () {
    return view('p-siswa');
});

// untuk logout paksa (testing atau jika sesi bermasalah)
Route::get('/logout-force', function () {
    Auth::logout();
    return redirect('/login');
});



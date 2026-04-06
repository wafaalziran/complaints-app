<?php
use App\Http\Controllers\aspirasiController;
use Illuminate\Support\Facades\Route;

Route::get('/aspirasi', [aspirasiController::class, 'index']);
Route::post('/aspirasi', [aspirasiController::class, 'store']);
Route::post('/aspirasi/{id}',[aspirasiController::class, 'update']);

Route::get('/p-siswa', function () {
    return view('p-siswa');
});

Route::get('/p-admin', function () {
    return view('p-admin');
});


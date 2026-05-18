<?php

use App\Http\Controllers\AuthController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware(['auth', 'cek.peran:admin'])->group(function () {
    Route::get('/dashboard/admin', fn () => 'Dashboard Admin')->name('dashboard.admin');
});

Route::middleware(['auth', 'cek.peran:pramurukti'])->group(function () {
    Route::get('/dashboard/pramurukti', fn () => 'Dashboard Pramurukti')->name('dashboard.pramurukti');
});

Route::middleware(['auth', 'cek.peran:keluarga'])->group(function () {
    Route::get('/dashboard/keluarga', fn () => 'Dashboard Keluarga')->name('dashboard.keluarga');
});

<?php

use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\PenghuniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PramuruktiController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware(['auth', 'cek.peran:pramurukti'])->group(function () {
    Route::get('/dashboard/pramurukti', [DashboardController::class, 'pramurukti'])->name('dashboard.pramurukti');
});

Route::middleware(['auth', 'cek.peran:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::resource('admin/penghuni', PenghuniController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names([
            'index' => 'admin.penghuni.index',
            'store' => 'admin.penghuni.store',
            'update' => 'admin.penghuni.update',
            'destroy' => 'admin.penghuni.destroy',
        ]);
    Route::resource('admin/kamar', KamarController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names([
            'index' => 'admin.kamar.index',
            'store' => 'admin.kamar.store',
            'update' => 'admin.kamar.update',
            'destroy' => 'admin.kamar.destroy',
        ]);
    Route::resource('admin/pramurukti', PramuruktiController::class)
        ->only(['index', 'store', 'destroy'])
        ->names([
            'index' => 'admin.pramurukti.index',
            'store' => 'admin.pramurukti.store',
            'destroy' => 'admin.pramurukti.destroy',
        ]);
});

Route::middleware(['auth', 'cek.peran:keluarga'])->group(function () {
    Route::get('/dashboard/keluarga', [DashboardController::class, 'keluarga'])->name('dashboard.keluarga');
});

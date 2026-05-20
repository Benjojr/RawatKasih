<?php

use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\PenghuniController;
use App\Http\Controllers\Admin\PramuruktiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pramurukti\PasienController;
use App\Http\Controllers\Pramurukti\TugasHarianController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\TugasController;
use App\Http\Controllers\Keluarga\KunjunganController;
use App\Http\Controllers\Keluarga\KesehatanController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ChatController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/belum-dibaca', [NotifikasiController::class, 'belumDibaca'])->name('notifikasi.belumDibaca');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{pengguna}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{pengguna}', [ChatController::class, 'store'])->name('chat.store');
});

// Dashboard
Route::middleware(['auth', 'cek.peran:pramurukti'])->group(function () {
    Route::get('/dashboard/pramurukti', [DashboardController::class, 'pramurukti'])->name('dashboard.pramurukti');

    Route::resource('pramurukti/tugas', TugasHarianController::class)
        ->only(['index', 'store', 'destroy'])
        ->names([
            'index' => 'pramurukti.tugas.index',
            'store' => 'pramurukti.tugas.store',
            'destroy' => 'pramurukti.tugas.destroy',
        ]);

    Route::patch('pramurukti/tugas/{tugasHarian}/status', [TugasHarianController::class, 'updateStatus'])
        ->name('pramurukti.tugas.updateStatus');

    Route::get('pramurukti/pasien', [PasienController::class, 'index'])->name('pramurukti.pasien.index');
    Route::get('pramurukti/pasien/{penghuni}', [PasienController::class, 'show'])->name('pramurukti.pasien.show');
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
    Route::resource('admin/tugas', TugasController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names([
            'index' => 'admin.tugas.index',
            'store' => 'admin.tugas.store',
            'update' => 'admin.tugas.update',
            'destroy' => 'admin.tugas.destroy',
        ]);

    Route::get('admin/shift', [ShiftController::class, 'index'])->name('admin.shift.index');
    Route::post('admin/shift/jenis', [ShiftController::class, 'storeShift'])->name('admin.shift.storeShift');
    Route::post('admin/shift/jadwal', [ShiftController::class, 'storeJadwal'])->name('admin.shift.storeJadwal');
    Route::delete('admin/shift/jadwal/{shiftPramurukti}', [ShiftController::class, 'destroyJadwal'])->name('admin.shift.destroyJadwal');
    Route::delete('admin/shift/jenis/{shift}', [ShiftController::class, 'destroyShift'])->name('admin.shift.destroyShift');

    Route::get('admin/kunjungan', [AdminKunjunganController::class, 'index'])->name('admin.kunjungan.index');
    Route::patch('admin/kunjungan/{kunjungan}/status', [AdminKunjunganController::class, 'updateStatus'])->name('admin.kunjungan.updateStatus');
});

Route::middleware(['auth', 'cek.peran:keluarga'])->group(function () {
    Route::get('/dashboard/keluarga', [DashboardController::class, 'keluarga'])->name('dashboard.keluarga');

    Route::get('keluarga/kunjungan', [KunjunganController::class, 'index'])->name('keluarga.kunjungan.index');
    Route::post('keluarga/kunjungan', [KunjunganController::class, 'store'])->name('keluarga.kunjungan.store');
    Route::delete('keluarga/kunjungan/{kunjungan}', [KunjunganController::class, 'destroy'])->name('keluarga.kunjungan.destroy');
    Route::get('keluarga/kesehatan', [KesehatanController::class, 'index'])->name('keluarga.kesehatan.index');
});

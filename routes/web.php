<?php

use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PenghuniController;
use App\Http\Controllers\Admin\PramuruktiController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\TugasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Keluarga\KesehatanController;
use App\Http\Controllers\Keluarga\KunjunganController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Pramurukti\PasienController;
use App\Http\Controllers\Pramurukti\TugasHarianController;
use App\Http\Controllers\ProfilController;

// Welcome
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->peran) {
            'admin' => redirect()->route('dashboard.admin'),
            'pramurukti' => redirect()->route('dashboard.pramurukti'),
            'keluarga' => redirect()->route('dashboard.keluarga'),
        };
    }

    return view('welcome');
})->name('home');

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

    Route::get('pramurukti/tugas', [TugasHarianController::class, 'index'])->name('pramurukti.tugas.index');
    Route::post('pramurukti/tugas', [TugasHarianController::class, 'store'])->name('pramurukti.tugas.store');
    Route::delete('pramurukti/tugas/{tugasHarian}', [TugasHarianController::class, 'destroy'])->name('pramurukti.tugas.destroy');

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

    Route::get('admin/shift', [ShiftController::class, 'index'])->name('admin.shift.index');
    Route::post('admin/shift/jenis', [ShiftController::class, 'storeShift'])->name('admin.shift.storeShift');
    Route::post('admin/shift/jadwal', [ShiftController::class, 'storeJadwal'])->name('admin.shift.storeJadwal');
    Route::delete('admin/shift/jadwal/{shiftPramurukti}', [ShiftController::class, 'destroyJadwal'])->name('admin.shift.destroyJadwal');
    Route::delete('admin/shift/jenis/{shift}', [ShiftController::class, 'destroyShift'])->name('admin.shift.destroyShift');

    Route::get('admin/kunjungan', [AdminKunjunganController::class, 'index'])->name('admin.kunjungan.index');
    Route::patch('admin/kunjungan/{kunjungan}/status', [AdminKunjunganController::class, 'updateStatus'])->name('admin.kunjungan.updateStatus');

    Route::get('admin/pengguna', [PenggunaController::class, 'index'])->name('admin.pengguna.index');
    Route::patch('admin/pengguna/{pengguna}/peran', [PenggunaController::class, 'updatePeran'])->name('admin.pengguna.updatePeran');
    Route::delete('admin/pengguna/{pengguna}', [PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');
    Route::patch('admin/pengguna/{pengguna}/blacklist', [PenggunaController::class, 'blacklist'])->name('admin.pengguna.blacklist');

    Route::post('admin/penghuni/{penghuni}/keluarga', [PenghuniController::class, 'assignKeluarga'])->name('admin.penghuni.assignKeluarga');
    Route::delete('admin/penghuni/{penghuni}/keluarga/{keluarga}', [PenghuniController::class, 'removeKeluarga'])->name('admin.penghuni.removeKeluarga');
    Route::get('admin/penghuni/{penghuni}', [PenghuniController::class, 'show'])->name('admin.penghuni.show');

    Route::get('admin/tugas', [TugasController::class, 'index'])->name('admin.tugas.index');
    Route::post('admin/tugas', [TugasController::class, 'store'])->name('admin.tugas.store');
    Route::put('admin/tugas/{tugas}', [TugasController::class, 'update'])->name('admin.tugas.update');
    Route::delete('admin/tugas/{tugas}', [TugasController::class, 'destroy'])->name('admin.tugas.destroy');
});

Route::middleware(['auth', 'cek.peran:keluarga'])->group(function () {
    Route::get('/dashboard/keluarga', [DashboardController::class, 'keluarga'])->name('dashboard.keluarga');

    Route::get('keluarga/kunjungan', [KunjunganController::class, 'index'])->name('keluarga.kunjungan.index');
    Route::post('keluarga/kunjungan', [KunjunganController::class, 'store'])->name('keluarga.kunjungan.store');
    Route::delete('keluarga/kunjungan/{kunjungan}', [KunjunganController::class, 'destroy'])->name('keluarga.kunjungan.destroy');
    Route::get('keluarga/kesehatan', [KesehatanController::class, 'index'])->name('keluarga.kesehatan.index');
});

Route::post('/chat/{pengguna}/typing', [ChatController::class, 'typing'])->name('chat.typing');
Route::get('/chat/{pengguna}/cek-typing', [ChatController::class, 'cekTyping'])->name('chat.cekTyping');
Route::get('/chat/{pengguna}/pesan-baru', [ChatController::class, 'pesanBaru'])->name('chat.pesanBaru');

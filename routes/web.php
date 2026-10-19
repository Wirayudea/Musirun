<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('index');
});

Route::get('/desain', function () {
    return view('desain');
})->name('desain');

Route::get('/registrasi', function () {
    return view('registrasi');
});



// Route untuk menyimpan pendaftaran
Route::post('/registrasi', [RegistrationController::class, 'store'])->name('registrasi.store');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/daftar-peserta', [AdminController::class, 'participants'])->name('admin.daftar_peserta');
    Route::get('/peserta', [AdminController::class, 'participants'])->name('admin.peserta');
    Route::get('/peserta-diterima', [AdminController::class, 'accepted'])->name('admin.peserta_diterima');
    Route::get('/registrant/{registrant}', [AdminController::class, 'show'])->name('admin.registrant.show');
    Route::get('/registrant/{registrant}/edit', [AdminController::class, 'edit'])->name('admin.registrant.edit');
    Route::put('/registrant/{registrant}', [AdminController::class, 'update'])->name('admin.registrant.update');
    Route::patch('/registrant/{registrant}/status', [AdminController::class, 'updateStatus'])->name('admin.registrant.status');
    Route::patch('/registrant/{registrant}/rpc-status', [AdminController::class, 'updateRpcStatus'])->name('admin.registrant.rpc_status');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/export/peserta-diterima/{distance}', [AdminController::class, 'exportAccepted'])->where('distance', '7|12')->name('admin.export.accepted');

    // Admin auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Public shortcut route to admin daftar peserta
Route::get('/daftar-peserta', [AdminController::class, 'participants'])->name('daftar_peserta');

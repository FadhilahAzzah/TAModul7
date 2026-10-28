<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('laporans.create'));

// ===== PUBLIK: warga mengirim laporan tanpa login =====
Route::resource('laporans', LaporanController::class)->only(['create', 'store']);

// ===== Authentication petugas =====
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== TERPROTEKSI: petugas mengelola laporan (index, show, edit, update, destroy) =====
Route::middleware('auth')->group(function () {
    Route::resource('laporans', LaporanController::class)->except(['create', 'store']);
});

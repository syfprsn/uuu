<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showregisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'login'])->name('register.new.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/user', [PeminjamanController::class, 'index'])->name('user.pinjambuku');

    Route::get('/admins', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');

    // ROUTE CRUD UNTUK BUKU
    Route::get('/adminss', [BukuController::class, 'index'])->name('admin.buku'); // Menampilkan daftar buku
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create'); // Form tambah buku
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store'); // Simpan buku baru

    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit'); // Form edit buku
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update'); // Update data buku

    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy'); // Hapus buku

    // ROUTE CRUD UNTUK PEMINJAMAN
    // ROUTE CRUD UNTUK PEMINJAMAN BUKU
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index'); // Menampilkan daftar peminjaman
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create'); // Form tambah peminjaman
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store'); // Simpan peminjaman baru

    // Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit'); // Form edit peminjaman
    // Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update'); // Update data peminjaman

    // Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy'); // Hapus peminjaman
});

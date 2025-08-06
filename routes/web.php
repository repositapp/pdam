<?php

use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasanganController;
use App\Http\Controllers\PemutusanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;





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

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/authentication', [AuthController::class, 'authenticate'])->name('authentication');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registrasi', [AuthController::class, 'registrasi'])->name('registrasi');
Route::post('/registrasi', [AuthController::class, 'register'])->name('registrasi.post');

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('success', 'Logout paksa berhasil.');
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/{slug}', [MenuController::class, 'show'])->name('menu.show');

Route::prefix('panel')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Master Data
    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('pelanggan', PelangganController::class)->except(['show']);
    // Pemasangan
    Route::resource('pemasangan', PemasanganController::class);
    // Route tambahan untuk mengupdate status (jika tidak menggunakan form PUT biasa)
    Route::get('/pemasangan/get-nomor-urut', [PemasanganController::class, 'getNomorUrut'])->name('pemasangan.get-nomor-urut');
    // Pemutusan
    Route::resource('pemutusan', PemutusanController::class);
    // Tagihan
    Route::resource('tagihan', TagihanController::class);
    Route::get('tagihan/{tagihan}/cetak', [TagihanController::class, 'cetak'])->name('tagihan.cetak');
    // Pengaduan
    Route::resource('pengaduan', PengaduanController::class);
    Route::put('pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');
    // Laporan
    Route::get('laporan/pemasangan', [LaporanController::class, 'pemasanganIndex'])->name('laporan.pemasangan.index');
    Route::post('laporan/pemasangan/cetak-pdf', [LaporanController::class, 'cetakPemasanganPdf'])->name('laporan.pemasangan.cetak-pdf');
    Route::post('laporan/pemasangan/cetak-excel', [LaporanController::class, 'cetakPemasanganExcel'])->name('laporan.pemasangan.cetak-excel');

    Route::get('laporan/pemutusan', [LaporanController::class, 'pemutusanIndex'])->name('laporan.pemutusan.index');
    Route::post('laporan/pemutusan/cetak-pdf', [LaporanController::class, 'cetakPemutusanPdf'])->name('laporan.pemutusan.cetak-pdf');
    Route::post('laporan/pemutusan/cetak-excel', [LaporanController::class, 'cetakPemutusanExcel'])->name('laporan.pemutusan.cetak-excel');
    // Pengumuman
    Route::resource('pengumuman', PengumumanController::class)->except(['show']);
    // Modul
    Route::resource('halaman', HalamanController::class)->except(['show']);
    Route::resource('menu', MenuController::class)->except(['show']);
    Route::get('/menu/load-targets', [MenuController::class, 'loadTargets'])->name('menu.target');
    // Settings
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('aplikasi', AplikasiController::class)->except(['show', 'create', 'store', 'destroy', 'edit']);
});

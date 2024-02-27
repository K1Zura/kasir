<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('login');
Route::middleware(['middleware' => 'auth'])->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/produk', [ProdukController::class, 'produk']);
    Route::delete('/deleteProduk/{id}', [ProdukController::class, 'delete']);

    Route::get('/penjualan', [PenjualanController::class, 'penjualan'])->name('penjualan');
    Route::post('/tambah-penjualan', [PenjualanController::class, 'tambahPenjualan']);
    Route::post('/tambah-barang', [PenjualanController::class, 'tambahBarang']);
    Route::delete('/deleteDetail/{id}', [PenjualanController::class, 'delete']);
    Route::delete('/reset', [PenjualanController::class, 'reset']);
    Route::put('/update-detail', [PenjualanController::class, 'update']);
    Route::get('/transaksi/{id}', [PenjualanController::class, 'show'])->name('detailTransaksi');

    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::post('/tambah-pembelian', [PembelianController::class, 'add']);
    Route::post('/pembelian', [PembelianController::class, 'store']);
    Route::delete('/hapus-pembelian/{id}', [PembelianController::class, 'delete']);
    Route::put('/update-pembelian', [PembelianController::class, 'put']);
    Route::put('/update-jumlah', [PembelianController::class, 'jumlah']);

    Route::get('/kartu-stok', [KartuStokController::class, 'kartuStok']);
    Route::get('/kartu-stok', [KartuStokController::class, 'kartuStok'])->name('kartu-stok');
    Route::get('/kartu-stok-pdf', [KartuStokController::class, 'Pdf'])->name('kartu-stok-pdf');
    Route::get('/kartu-stok-excel', [KartuStokController::class, 'Excel'])->name('kartu-stok-excel');

    Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan');
    Route::get('/transaksi-pdf', [LaporanController::class, 'Pdf'])->name('transaksi-pdf');
    Route::get('/transaksi-excel', [LaporanController::class, 'Excel'])->name('transaksi-excel');
    Route::get('/print-ulang/{id}', [LaporanController::class, 'print'])->name('print');

    Route::get('/history', [HistoryController::class, 'index']);


});


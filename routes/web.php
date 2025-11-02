<?php

use App\Http\Controllers\AkunPengeluaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanSatuanController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {

    //home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    //endHome

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    //user
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('get-data-user', [UserController::class, 'getDataUser'])->name('getDataUser');
    Route::post('user', [UserController::class, 'addUser'])->name('addUser');

    Route::get('get-user/{id}', [UserController::class, 'getUser'])->name('getUser');

    Route::post('edit-user', [UserController::class, 'editUser'])->name('editUser');
    //enduser

    //cabang
    Route::get('outlet', [CabangController::class, 'index'])->name('outlet');
    Route::post('outlet', [CabangController::class, 'addOutlet'])->name('addOutlet');
    Route::patch('editOutlet', [CabangController::class, 'editOutlet'])->name('editOutlet');
    Route::get('deleteEmailCabang/{id}', [CabangController::class, 'deleteEmailCabang'])->name('deleteEmailCabang');
    Route::post('editHargaPengeluaran', [CabangController::class, 'editHargaPengeluaran'])->name('editHargaPengeluaran');
    //end cabang

    //akun pengeluaran
    Route::get('akun-pengeluaran', [AkunPengeluaranController::class, 'index'])->name('akunPengeluaran');
    Route::post('add-akun', [AkunPengeluaranController::class, 'addAkun'])->name('addAkun');
    Route::patch('edit-akun', [AkunPengeluaranController::class, 'editAkun'])->name('editAkun');
    //end pengeluaran

    //bahan
    Route::get('/bahan-satuan', [BahanSatuanController::class, 'index'])->name('bahanSatuan');
    Route::post('satuan', [BahanSatuanController::class, 'addSatuan'])->name('addSatuan');
    Route::post('bahan', [BahanSatuanController::class, 'addBahan'])->name('addBahan');
    Route::patch('satuan', [BahanSatuanController::class, 'editSatuan'])->name('editSatuan');
    Route::patch('bahan', [BahanSatuanController::class, 'editBahan'])->name('editBahan');
    Route::patch('dropDataBahan', [BahanSatuanController::class, 'dropDataBahan'])->name('dropDataBahan');
    //endbahan

    //barang kebutuhan
    Route::get('barangKebutuhan', [BahanSatuanController::class, 'barangKebutuhan'])->name('barangKebutuhan');
    Route::post('addBarangKebutuhan', [BahanSatuanController::class, 'addBarangKebutuhan'])->name('addBarangKebutuhan');
    Route::patch('editBarangKebutuhan', [BahanSatuanController::class, 'editBarangKebutuhan'])->name('editBarangKebutuhan');
    //end barang kebutuhan

    //pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
    Route::post('/pembayaran', [PembayaranController::class, 'addPembayaran'])->name('addPembayaran');
    Route::patch('/pembayaran', [PembayaranController::class, 'editPembayaran'])->name('editPembayaran');
    //end pembayaran

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
    Route::post('/karyawan', [KaryawanController::class, 'addKaryawan'])->name('addKaryawan');
    Route::patch('/karyawan', [KaryawanController::class, 'editKaryawan'])->name('editKaryawan');
    Route::post('/delete-karyawan', [KaryawanController::class, 'dropKaryawan'])->name('dropKaryawan');
    Route::post('sort-karyawan', [KaryawanController::class, 'sortKaryawan'])->name('sortKaryawan');
    //end karyawan

    //produk
    Route::get('/products', [ProductsController::class, 'index'])->name('products');
    Route::post('/products', [ProductsController::class, 'addProduct'])->name('addProduct');
    Route::patch('/produk', [ProductsController::class, 'editProduk'])->name('editProduk');

    Route::post('/add-resep', [ProductsController::class, 'addResep'])->name('addResep');

    Route::post('/drop-resep', [ProductsController::class, 'dropResep'])->name('dropResep');

    Route::post('/sort-produk', [ProductsController::class, 'sortProduk'])->name('sortProduk');

    Route::get('/delete-produk/{id}', [ProductsController::class, 'deleteProduk'])->name('deleteProduk');

    Route::get('getHargaResep/{produk_id}', [ProductsController::class, 'getHargaResep'])->name('getHargaResep');
    //end produk

    //kategori
    Route::post('tambah-kategori', [ProductsController::class, 'tambahKategori'])->name('tambahKategori');
    Route::post('edit-kategori', [ProductsController::class, 'editKategori'])->name('editKategori');
    //end kategori





    //block
    Route::get('forbidden-access', [AuthController::class, 'block'])->name('block');
    //endblock

    Route::get('ganti-password', [UserController::class, 'gantiPassword'])->name('gantiPassword');

    Route::post('edit-password', [UserController::class, 'editPassword'])->name('editPassword');
});


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login_page'])->name('loginPage');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\HomeController;
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

    //loket
    Route::get('loket', [BerkasController::class, 'loket'])->name('loket');
    Route::post('addBerkas', [BerkasController::class, 'addBerkas'])->name('addBerkas');
    Route::patch('editBerkas', [BerkasController::class, 'editBerkas'])->name('editBerkas');
    //endloket

    //penjadwalan
    Route::get('penjadwalan', [BerkasController::class, 'penjadwalan'])->name('penjadwalan');
    Route::post('dropBerkas/{id}', [BerkasController::class, 'dropBerkas'])->name('dropBerkas');
    Route::post('addPengukuranAdmin', [BerkasController::class,'addPengukuranAdmin'])->name('addPengukuranAdmin');
    Route::get('dropPengkuran/{id}', [BerkasController::class,'dropPengkuran'])->name('dropPengkuran');
    Route::post('addPengukuranPetugas', [BerkasController::class,'addPengukuranPetugas'])->name('addPengukuranPetugas');
    Route::post('tutupBerkas', [BerkasController::class,'tutupBerkas'])->name('tutupBerkas');
    //endpenjadwalan

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    //user
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::post('user', [UserController::class, 'addUser'])->name('addUser');
    Route::patch('edit-user', [UserController::class, 'editUser'])->name('editUser');
    //enduser


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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SubkriteriaController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\HalPelangganController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('dashboard.index');
})->name('index');

Route::get('/pesanan/create/{id_paket?}', [PesananController::class, 'create'])->name('pesanan.create');

Route::resource('pesanan', PesananController::class);

Route::resource('paket', PaketController::class);



Route::get('/penilaian/all', [PenilaianController::class, 'all'])->name('penilaian.all');
Route::resource('penilaian', PenilaianController::class);



Route::resource('kriteria', KriteriaController::class);


Route::resource('subkriteria', SubkriteriaController::class);

Route::resource('guide', GuideController::class);



Route::get('/dashboard-pelanggan', [HalPelangganController::class, 'showPackages'])->name('dashboard.pelanggan');








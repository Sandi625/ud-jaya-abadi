<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HalguideController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\NotifGuideController;
use App\Http\Controllers\PilihGuideController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SubkriteriaController;
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
    return view('welcome');
})->name('home');
Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');



Route::get('/pesanan/create/{id_paket?}', [PesananController::class, 'create'])->name('pesanan.create');

Route::resource('pesanan', PesananController::class);

Route::resource('paket', PaketController::class);



Route::get('/penilaian/all', [PenilaianController::class, 'all'])->name('penilaian.all');
Route::resource('penilaian', PenilaianController::class);



Route::resource('kriteria', KriteriaController::class);


Route::resource('subkriteria', SubkriteriaController::class);

Route::resource('guide', GuideController::class);



Route::get('/dashboard-pelanggan', [HalPelangganController::class, 'showPackages'])->name('dashboard.pelanggan');




Route::get('/pilih-guide', [PilihGuideController::class, 'index'])->name('pilihguide.index');

Route::get('/pilihguide/{pesanan}/create', [PilihGuideController::class, 'create'])->name('pilihguide.create');
Route::post('/pilihguide/{pesanan}', [PilihGuideController::class, 'store'])->name('pilihguide.store');

Route::get('/pilihguide/{pesanan}/edit', [PilihGuideController::class, 'edit'])->name('pilihguide.edit');
Route::put('/pilihguide/{pesanan}', [PilihGuideController::class, 'update'])->name('pilihguide.update');


// Route::get('/chart/penilaian-guide', [DashboardController::class, 'chartPenilaianGuide'])->name('chart.penilaian.guide');
Route::get('/notif-guide', [NotifGuideController::class, 'guidesWithPesanan'])->name('notif.guide');
Route::get('/guide/{id}/send-notif', [PilihGuideController::class, 'sendNotifToGuide'])->name('guide.sendNotif');

Route::get('/guides-with-pesanan', [NotifGuideController::class, 'guidesWithPesanan'])->name('guidesWithPesanan');
Route::get('/notif-guide/{id}', [NotifGuideController::class, 'show'])->name('guide.detail');



Route::prefix('customer')->middleware(['auth'])->group(function () {
    Route::get('/packages', [HalPelangganController::class, 'showPackages'])->name('customer.packages');
});





Route::get('/admin/reviews', [ReviewController::class, 'allReviews'])->name('review.all');
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit');
Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('review.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/review', [ReviewController::class, 'index'])->name('review.review');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
});


Route::resource('users', UserController::class);


Route::get('/halamanguide', [HalguideController::class, 'index'])
    ->name('halamanguide.index')
    ->middleware(['auth', 'isGuideOrAdmin']);

Route::get('/halaman-guide/{id}', [HalguideController::class, 'showguide'])
    ->name('halamanguide.show')
    ->middleware(['auth', 'isGuideOrAdmin']);



Route::resource('blogs', BlogController::class)
    ->except(['show'])
    ->middleware('auth');
// Route 'show' tidak menggunakan middleware auth
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/sblog', [BlogController::class, 'listBlogs'])->name('blog.list');

Route::get('/galeri', [GaleriController::class, 'showGaleri'])->name('galeri');
Route::resource('galeris', GaleriController::class);

    Route::get('/galeri/video', [GaleriController::class, 'showVideo'])->name('galeri.video');

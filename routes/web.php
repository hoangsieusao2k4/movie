<?php

use App\Http\Controllers\Admin\ActorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\VNPayController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleController;
use App\Models\Director;
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
// auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showFormEmail'])->name('password.email');
Route::post('/forgot-password-email', [ForgotPasswordController::class, 'sendEmail'])->name('password.check-email');


// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');

Route::get('/check-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('/check-otp', [ForgotPasswordController::class, 'checkOtp'])->name('check.otp');
Route::get('/reset-password', [ForgotPasswordController::class, 'showReset'])->name('showReset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('check-reset');


// google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/callback/google', [GoogleController::class, 'handleGoogleCallback']);
// client
Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/movies', [HomeController::class, 'genres'])->name('genres.index');
Route::get('/phim-le', [HomeController::class, 'movie'])->name('client.movie');
Route::get('/phim-bo', [HomeController::class, 'series'])->name('client.series');
Route::get('/quoc-gia/{slug}', [HomeController::class, 'country'])->name('client.country');
Route::get('/nam/{year}', [HomeController::class, 'year'])->name('client.year');
Route::get('/movies/{slug}', [HomeController::class, 'show'])->name('client.show');
Route::get('/watch/{slug}/{episode?}', [HomeController::class, 'watch'])->name('client.watch');
// comment
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{movie}', [CommentController::class, 'fetch'])->name('comments.fetch');


//admin

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');         // Danh sách
        Route::get('/create', [CategoryController::class, 'create'])->name('create');         // form thêm mới
        Route::post('/', [CategoryController::class, 'store'])->name('store');        // Thêm mới
        Route::get('{id}/show', [CategoryController::class, 'show'])->name('show');        // Xem chi tiết
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('edit');        // form cập nhật

        Route::put('{category}/update', [CategoryController::class, 'update'])->name('update');    // Cập nhật
        Route::delete('{category}/destroy', [CategoryController::class, 'destroy'])->name('destroy'); // Xoá
    });
    Route::prefix('movies')->name('movies.')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('index');         // Danh sách
        Route::get('/create', [MovieController::class, 'create'])->name('create');         // form thêm mới
        Route::post('/', [MovieController::class, 'store'])->name('store');        // Thêm mới
        Route::get('{movie:slug}/show', [MovieController::class, 'show'])->name('show');        // Xem chi tiết
        Route::get('{movie:slug}/edit', [MovieController::class, 'edit'])->name('edit');        // form cập nhật
        Route::put('{movie:slug}/update', [MovieController::class, 'update'])->name('update');    // Cập nhật
        Route::delete('{movie:slug}/destroy', [MovieController::class, 'destroy'])->name('destroy'); // Xoá
    });
    Route::prefix('genres')->name('genres.')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('index');         // Danh sách
        Route::get('/create', [GenreController::class, 'create'])->name('create');         // form thêm mới
        Route::post('/store', [GenreController::class, 'store'])->name('store');        // Thêm mới
        Route::get('{genre:slug}/show', [GenreController::class, 'show'])->name('show');        // Xem chi tiết
        Route::get('{genre:slug}/edit', [GenreController::class, 'edit'])->name('edit');        // form cập nhật

        Route::put('{genre:slug}/update', [GenreController::class, 'update'])->name('update');    // Cập nhật
        Route::delete('{genre}/destroy', [GenreController::class, 'destroy'])->name('destroy'); // Xoá
    });
    Route::prefix('directors')->name('directors.')->group(function () {
        Route::get('/', [DirectorController::class, 'index'])->name('index');         // Danh sách
        Route::get('/create', [DirectorController::class, 'create'])->name('create');         // form thêm mới
        Route::post('/store', [DirectorController::class, 'store'])->name('store');        // Thêm mới
        Route::get('{director}/show', [DirectorController::class, 'show'])->name('show');        // Xem chi tiết
        Route::get('{director}/edit', [DirectorController::class, 'edit'])->name('edit');        // form cập nhật

        Route::put('{director}/update', [DirectorController::class, 'update'])->name('update');    // Cập nhật
        Route::delete('{director}/destroy', [DirectorController::class, 'destroy'])->name('destroy'); // Xoá
    });
    Route::prefix('actors')->name('actors.')->group(function () {
        Route::get('/', [ActorController::class, 'index'])->name('index');         // Danh sách
        Route::get('/create', [ActorController::class, 'create'])->name('create');         // form thêm mới
        Route::post('/store', [ActorController::class, 'store'])->name('store');        // Thêm mới
        Route::get('{actor}/show', [ActorController::class, 'show'])->name('show');        // Xem chi tiết
        Route::get('{actor}/edit', [ActorController::class, 'edit'])->name('edit');        // form cập nhật

        Route::put('{actor}/update', [ActorController::class, 'update'])->name('update');    // Cập nhật
        Route::delete('{actor}/destroy', [ActorController::class, 'destroy'])->name('destroy'); // Xoá
    });
    Route::prefix('episodes')->name('episodes.')->group(function () {
        Route::post('/store/{movie}', [EpisodeController::class, 'store'])->name('store');
        Route::get('{episode}/edit', [EpisodeController::class, 'edit'])->name('edit');
        Route::put('{episode}/update', [EpisodeController::class, 'update'])->name('update');
        Route::delete('{episode}/destroy', [EpisodeController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('countries')->name('countries.')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');         // Danh sách
        Route::get('/create', [CountryController::class, 'create'])->name('create');         // form thêm mới
        Route::post('/', [CountryController::class, 'store'])->name('store');        // Thêm mới
        Route::get('{country}/show', [CountryController::class, 'show'])->name('show');        // Xem chi tiết
        Route::get('{country}/edit', [CountryController::class, 'edit'])->name('edit');        // form cập nhật
        Route::put('{country}/update', [CountryController::class, 'update'])->name('update');    // Cập nhật
        Route::delete('{country}/destroy', [CountryController::class, 'destroy'])->name('destroy'); // Xoá
    });
    // routes/web.php

});
Route::middleware('auth')->group(function () {
        Route::get('/premium', [VNPayController::class, 'form'])->name('premium.form');
        Route::post('/payment/vnpay', [VNPayController::class, 'createPayment'])->name('vnpay.payment');
        Route::get('/payment/vnpay/return', [VNPayController::class, 'handleReturn'])->name('vnpay.return');


    });

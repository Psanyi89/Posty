<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserPostController;

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

Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/users/{user:username}/posts', [UserPostController::class, 'index'])->name('users.posts');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/posts', [PostController::class, 'post']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/like', [PostLikeController::class, 'like'])->name('posts.likes');
    Route::delete('/posts/{post}/like', [PostLikeController::class, 'destroy'])->name('posts.likes');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
});
Route::group(
    ['middleware' => ['guest']],
    function () {

        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);

        Route::get('/register', [RegisterController::class, 'index'])->name('register');
        Route::post('/register', [RegisterController::class, 'store']);
    }
);

<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout'); // todo требует аутентификации

Route::get('/user', [UserController::class, 'show'])->name('user.show'); // todo требует аутентификации
Route::patch('/user', [UserController::class, 'update'])->name('user.update'); // todo требует аутентификации

Route::get('/films/{film}/similar', [FilmController::class, 'similar'])->name('films.similar');

Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::post('/films', [FilmController::class, 'store'])->name('films.store'); // todo требует аутентификации
Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show'); // todo доп повеление для аутентифицированного пользователя
Route::patch('/films/{film}', [FilmController::class, 'update'])->name('films.update'); // todo требует аутентификации

// Можно использовать ресурсный роут, вместо перечисления каждого отдельно
// Route::apiResource('films', '\App\Http\Controllers\FilmController')->except('destroy');

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::patch('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update'); // todo требует аутентификации

Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index'); // todo требует аутентификации
Route::post('/films/{film}/favorite', [FavoriteController::class, 'store'])->name('favorite.store'); // todo требует аутентификации
Route::delete('/films/{film}/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy'); // todo требует аутентификации

Route::get('/films/{film}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/films/{film}/comments', [CommentController::class, 'store'])->name('comments.store'); // todo требует аутентификации
Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update'); // todo требует аутентификации
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy'); // todo требует аутентификации

Route::get('/promo', [PromoController::class, 'show'])->name('promo.show');
Route::post('/promo/{film}', [PromoController::class, 'store'])->name('promo.store'); // todo требует аутентификации

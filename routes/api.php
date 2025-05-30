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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout'); // todo требует аутентификации

Route::controller(UserController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/user', [UserController::class, 'show'])->name('user.show'); // todo требует аутентификации
        Route::patch('/user', [UserController::class, 'update'])->name('user.update'); // todo требует аутентификации
});

Route::get('/films/{film}/similar', [FilmController::class, 'similar'])->name('films.similar');

Route::controller(FilmController::class)
    ->group(function () {
        Route::get('/films', 'index')->name('films.index');
        Route::post('/films', 'store')->middleware(['auth:sanctum', 'role:isModerator'])->name('films.store'); // todo требует аутентификации
        Route::get('/films/{film}', 'show')->name('films.show'); // todo доп повеление для аутентифицированного пользователя
        Route::patch('/films/{film}', 'update')->middleware(['auth:sanctum', 'role:isModerator'])->name('films.update'); // todo требует аутентификации
    });

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::patch('/genres/{genre}', [GenreController::class, 'update'])->middleware(['auth:sanctum', 'role:isModerator'])->name('genres.update'); // todo требует аутентификации

Route::controller(FavoriteController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/favorite', 'index')->name('favorite.index'); // todo требует аутентификации
        Route::post('/films/{film}/favorite', 'store')->name('favorite.store'); // todo требует аутентификации
        Route::delete('/films/{film}/favorite', 'destroy')->name('favorite.destroy'); // todo требует аутентификации
    });

Route::get('/films/{film}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::controller(CommentController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/films/{film}/comments', 'store')->name('comments.store'); // todo требует аутентификации
        Route::patch('/comments/{comment}', 'update')->name('comments.update'); // todo требует аутентификации
        Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy'); // todo требует аутентификации
    });

Route::get('/promo', [PromoController::class, 'show'])->name('promo.show');
Route::post('/promo/{film}', [PromoController::class, 'store'])->middleware(['auth:sanctum', 'role:isModerator'])->name('promo.store'); // todo требует аутентификации

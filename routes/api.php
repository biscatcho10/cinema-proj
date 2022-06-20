<?php

use App\Http\Controllers\APIs\CategoryController;
use App\Http\Controllers\APIs\FilmController;
use App\Http\Controllers\APIs\NewsController;
use App\Http\Controllers\APIs\TweetController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// all tweets
Route::get('tweet', [TweetController::class, 'index']);

// put all api protected routes here
Route::middleware('auth:api')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('category', CategoryController::class);

    Route::resource('films', FilmController::class);

    // add date to film
    Route::post('film/{film}/date', [FilmController::class, 'addDate']);

    // get today films
    Route::get('film/today', [FilmController::class, 'today']);
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShowTimeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('auth/register', [AuthController::class, 'register']);

Route::resource("category", CategoryController::class);
Route::resource("cinema", CinemaController::class);
Route::get("cinema-showtime", [CinemaController::class, 'getCinemaByMovieShowtime']);

Route::resource("room", RoomController::class);

Route::resource("movie", MovieController::class);
Route::get("movie-upcoming", [MovieController::class, 'getUpcomingMovie']);
Route::get("/movie-show-today", [MovieController::class, 'movieShowToday']);
Route::get("/movie-related", [MovieController::class, 'getMovieRelated']);
Route::get("/movie-showtime", [MovieController::class, 'getMovieByShowTime']);

Route::resource("schedule", ScheduleController::class);
Route::get("schedule-byCinema", [ScheduleController::class, 'getScheduleByCinema']);

Route::get("showtime", [ShowTimeController::class, 'getShowtimeByMovie']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::group(['middleware' => 'is.login'], function () {
    Route::post('/user/{id}', [UserController::class, 'update']);
});

Route::group(['middleware' => ['is.login', 'is.admin']], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'get']);
    Route::post('/user/is-enabled/{id}', [UserController::class, 'isEnabled']);
});

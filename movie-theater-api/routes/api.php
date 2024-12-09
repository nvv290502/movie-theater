<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillDetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ShowTimeController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Movie;
use App\Models\Role;
use App\Models\Seat;
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

Route::prefix('category')->group(function () {
    Route::resource("/", CategoryController::class);
    Route::get("{id}", [CategoryController::class, 'show'])->where('id', '[0-9]+');
    Route::get("list-name", [CategoryController::class, 'getListName']);
    Route::get("search/{name}", [CategoryController::class, 'getByName']);
});
  
Route::prefix('cinema')->group(function () {
    Route::resource("/", CinemaController::class);
    Route::get("{id}", [CinemaController::class, 'show'])->where('id', '[0-9]+');
    Route::get("showtime", [CinemaController::class, 'getCinemaByMovieShowtime']);
});

Route::prefix('room')->group(function () {
    Route::resource("/", RoomController::class);
    // Route::get("{id}", [RoomController::class, 'show'])->where('id', '[0-9]+');
    Route::get("cinema/{cinemaId}", [RoomController::class, 'getRoomByCinema'])->where('cinemaId', '[0-9]+');
    Route::post("save-layout/{roomId}", [RoomController::class, 'saveLayout'])->where('roomId', '[0-9]+');
    Route::post("update-initialization/{roomId}", [RoomController::class, 'updateInitialization'])->where('roomId', '[0-9]+');
    Route::get("is-enabled/cinema/{cinemaId}", [RoomController::class, 'getRoomIsEnabledByCinema'])->where('cinemaId','[0-9]+');
});

Route::prefix('movie')->group(function () {
    Route::resource("/", MovieController::class);
    Route::put("{id}", [MovieController::class, 'update'])->where('id','[0-9]+');
    Route::get("{id}", [MovieController::class, 'show'])->where('id', '[0-9]+');
    Route::get("upcoming", [MovieController::class, 'getUpcomingMovie']);
    Route::get("show-today", [MovieController::class, 'movieShowToday']);
    Route::get("related", [MovieController::class, 'getMovieRelated']);
    Route::get("showtime", [MovieController::class, 'getMovieByShowTime']);
    Route::get("list-name", [MovieController::class, 'getListName']);
    Route::get("search/{name}", [MovieController::class, 'getByName']);
    Route::get("showing", [MovieController::class, 'getMovieIsShowing']);
});

Route::prefix('schedule')->group(function () {
    Route::resource("/", ScheduleController::class);
    Route::get("{id}", [ScheduleController::class, 'show'])->where('id', '[0-9]+');
    Route::get("cinema", [ScheduleController::class, 'getScheduleByCinema']);
    Route::get("room/{roomId}", [ScheduleController::class, 'getScheduleByRoom']);
});

Route::prefix('showtime')->group(function () {
    Route::post("", [ShowTimeController::class, 'saveShowtime']);
    Route::get("{movieId}", [ShowTimeController::class, 'getShowtimeByMovie']);
    Route::post("update-price", [ShowTimeController::class, 'updatePriceTicket']);
});

Route::prefix('seat')->group(function(){
    Route::resource('/', SeatController::class);
    Route::get('{id}', [SeatController::class, 'show'])->where('id','[0-9]+');
    Route::get("room/{roomId}", [SeatController::class, 'getSeatByRoom'])->where('roomId','[0-9]+');
    Route::post("update-status/{roomId}", [SeatController::class, 'updateStatusSeat'])->where('roomId','[0-9]+');
});

Route::get("bill-detail/{billCode}", [BillDetailController::class, 'getBillDetail']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::prefix('user')->middleware(['is.login', 'is.admin'])->group(function(){
    Route::resource('/', UserController::class);
    Route::get("{id}", [UserController::class, 'get'])->where('id','[0-9]+');
    Route::post('is-enabled/{id}', [UserController::class, 'isEnabled'])->where('id','[0-9]+');
    Route::post('{id}', [UserController::class, 'update'])->where('id', '[0-9]+')->withoutMiddleware(\App\Http\Middleware\CheckRoleAdmin::class);
});

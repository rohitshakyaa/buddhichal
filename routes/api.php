<?php

use App\Http\Controllers\Api\BannerApiAdminController;
use App\Http\Controllers\Api\BannerApiController;
use App\Http\Controllers\Api\ChampionApiAdminController;
use App\Http\Controllers\Api\ChessBookApiAdminController;
use App\Http\Controllers\Api\NcaApiAdminController;
use App\Http\Controllers\Api\TeamChampionApiAdminController;
use App\Http\Controllers\Api\TournamentApiAdminController;
use App\Http\Controllers\Api\TournamentPlayerApiController;
use App\Http\Controllers\TournamentPlayerController;
use App\Models\Tournament;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('web/admin')->name('admin.')->group(function () {
    Route::get("banners", [BannerApiAdminController::class, 'index']);

    Route::get("ncas", [NcaApiAdminController::class, 'index']);

    Route::get("tournaments", [TournamentApiAdminController::class, 'index']);

    Route::get("champions", [ChampionApiAdminController::class, 'index']);
    Route::get("teamChampions", [TeamChampionApiAdminController::class, 'index']);

    Route::get("tournaments/players", [TournamentPlayerApiController::class, 'index']);
    Route::get("tournaments/players/create", [TournamentPlayerApiController::class, 'create']);
    Route::post("tournaments/players/store", [TournamentPlayerApiController::class, 'store']);

    Route::get("chess-books/{type}", [ChessBookApiAdminController::class, 'index']);
});

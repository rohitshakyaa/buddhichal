<?php

use App\Http\Controllers\Api\BannerApiController;
use App\Http\Controllers\Api\ChampionApiController;
use App\Http\Controllers\Api\ChessBookApiController;
use App\Http\Controllers\Api\NcaApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ProductClientApiController;
use App\Http\Controllers\Api\TeamChampionApiController;
use App\Http\Controllers\Api\TournamentApiController;
use App\Http\Controllers\Api\TournamentPlayerApiController;
use App\Http\Controllers\BookTypeApiController;
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

Route::get("tournaments", [TournamentApiController::class, 'index']);
Route::post("tournaments/players/store", [TournamentPlayerApiController::class, 'store']);
Route::get("nca-members", [NcaApiController::class, 'index']);
Route::get("banners", [BannerApiController::class, 'index']);
Route::get("champions/team", [TeamChampionApiController::class, 'index']);
Route::get("champions/{gender}", [ChampionApiController::class, 'index']);
Route::get("books", [ChessBookApiController::class, 'index']);
Route::get("books/types", [BookTypeApiController::class, 'index']);
Route::get("products", [ProductApiController::class, 'index']);
Route::post("products/clients/store", [ProductClientApiController::class, 'store']);

/* ----------  data table -------------- */
Route::prefix('web/admin')->name('.')->group(function () {
    Route::get("banners", [BannerApiController::class, 'index']);
    Route::get("ncas", [NcaApiController::class, 'index']);
    Route::get("tournaments", [TournamentApiController::class, 'getDataForDataTable']);
    Route::get("champions", [ChampionApiController::class, 'index']);
    Route::get("team-champions", [TeamChampionApiController::class, 'getDataForDataTable']);
    Route::get("tournaments/players", [TournamentPlayerApiController::class, 'index']);
    Route::get("books", [ChessBookApiController::class, 'index']);
    Route::get("books/types", [BookTypeApiController::class, 'index']);
    Route::get("products", [ProductApiController::class, 'getDataForDataTable']);
    Route::get("products/clients", [ProductClientApiController::class, 'index']);
});

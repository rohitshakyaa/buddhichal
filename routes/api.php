<?php

use App\Http\Controllers\Api\BannerApiAdminController;
use App\Http\Controllers\Api\BannerApiController;
use App\Http\Controllers\Api\NcaApiAdminController;
use App\Http\Controllers\Api\TournamentPlayerApiController;
use App\Http\Controllers\TournamentPlayerController;
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

Route::get("web/admin/tournaments", function () {
    $tournaments = [
        (object) [
            'title' => "Tournament 1",
            'number' => "980123123",
            'location' => "Khokana",
            "start_date" => "2021-01-21",
            "end_date" => "2022-02-02",
            "total_prize" => "Rs. 4000",
            "description" => "Testtest",
            "register" => false,
        ]
    ];
    return response()->json($tournaments);
});

Route::get("web/admin/ncas", [NcaApiAdminController::class, 'index']);

Route::get("web/admin/tournaments/players", [TournamentPlayerApiController::class, 'index']);
Route::get("web/admin/banners", [BannerApiAdminController::class, 'index']);

Route::get("/banners", [BannerApiController::class, 'index']);

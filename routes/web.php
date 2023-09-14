<?php

use App\Http\Controllers\Api\BannerApiAdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NcaController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentPlayerController;
use App\Models\Tournament;
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

Route::get("/", function () {
  return redirect(route('dashboard'));
});


Route::get('/book/{id}', [BookController::class, 'getBookByType']);

Route::get("/admin", [DashboardController::class, 'dashboardPage']);
Route::get("/admin/dashboard", [DashboardController::class, 'dashboardPage'])->name('dashboard');

Route::get("/admin/login", [UserController::class, 'loginPage'])->name('login');
Route::post("/admin/login", [UserController::class, 'login'])->name('login');
Route::get("/admin/tournaments", [TournamentController::class, 'index'])->name('tournamentIndex');
Route::get("/admin/tournaments/create", [TournamentController::class, 'create'])->name('tournamentCreate');
Route::post("/admin/tournaments/store", [TournamentController::class, 'store'])->name("tournamentStore");

Route::get("/admin/ncas", [NcaController::class, 'index'])->name('ncaIndex');
Route::get("/admin/ncas/create", [NcaController::class, 'create'])->name('ncaCreate');
Route::post("/admin/ncas/store", [NcaController::class, 'store'])->name('ncaStore');

Route::get("/admin/tournament/players", [TournamentPlayerController::class, 'index'])->name('tournamentPlayerIndex');

Route::get("/admin/banners", [BannerController::class, 'index'])->name('bannerIndex');
Route::get("/admin/banners/create", [BannerController::class, 'create'])->name('bannerCreate');
Route::post("/admin/banners/store", [BannerController::class, 'store'])->name('bannerStore');
Route::get("/admin/banners/{id}/edit", [BannerController::class, 'edit'])->name('bannerEdit');
Route::post("/admin/banners/{id}/update", [BannerController::class, 'update'])->name('bannerUpdate');
Route::post("/admin/banners/{id}/destroy", [BannerController::class, 'destroy'])->name('bannerDestroy');

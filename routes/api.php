<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
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


Route::group([
		'middleware' => 'api',
		'prefix' => 'auth'
], static function ($router) {
	
	Route::post('login', [AuthController::class, 'login']);
	Route::post('logout', [AuthController::class, 'logout']);
	Route::post('refresh', [AuthController::class, 'refresh']);
	Route::post('me', [AuthController::class, 'me']);
	Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth:api')->group(function () {
	Route::apiResource('portfolio', PortfolioController::class)->except('show', 'destroy');
	Route::get('portfolio/value', [PortfolioController::class, 'getValue'])->name('portfolio.getValue');
});
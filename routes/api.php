<?php

use App\Http\Controllers\MutantController;
use App\Http\Controllers\StatsController;
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

Route::post('/mutant', [MutantController::class, 'store'])->name('store');
Route::get('/stats', [StatsController::class, 'index'])->name('index');

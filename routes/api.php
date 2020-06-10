<?php

use App\Http\Controllers\MutantController;
use App\Http\Controllers\StatsController;
use App\Http\Middleware\ForceJson;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ForceJson::class], function (Router $route) {
    $route->post('/mutant', [MutantController::class, 'store'])->name('store');
    $route->get('/stats', [StatsController::class, 'index'])->name('index');
});

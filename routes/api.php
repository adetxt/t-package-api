<?php

use App\Http\Controllers\API\PackageController;
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

Route::middleware('rest')->group(function () {
    Route::put('package/{id}', [PackageController::class, 'upsert']);
    Route::patch('package/{id}', [PackageController::class, 'updatePartial']);
    Route::apiResource('package', PackageController::class)->except(['update']);
});

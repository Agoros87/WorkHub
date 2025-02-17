<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);

Route::get('/advertisements', [AdvertisementController::class, 'index']);
Route::get('/advertisements/{advertisement:slug}', [AdvertisementController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/advertisements', [AdvertisementController::class, 'store']);
    Route::put('/advertisements/{advertisement:slug}', [AdvertisementController::class, 'update']);
    Route::delete('/advertisements/{advertisement:slug}', [AdvertisementController::class, 'destroy']);
});

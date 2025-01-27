<?php

use App\Http\Controllers\PageHomeController;
use App\Http\Controllers\AdvertisementController;
use Illuminate\Support\Facades\Route;

Route::get('/', PageHomeController::class)->name('welcome');

Route::get('/select-role', function () {
    return view('select-role');
})->name('select-role');

Route::get('/register/employer', function () {
    return view('auth.register-employer');
})->name('register.employer');

Route::get('/register/worker', function () {
    return view('auth.register-worker');
})->name('register.worker');

Route::resource('jobs', AdvertisementController::class)
    ->names('advertisements')
    ->parameters(['jobs' => 'advertisement'])
    ->only(['index', 'show']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('jobs', AdvertisementController::class)
        ->names('advertisements')
        ->parameters(['jobs' => 'advertisement'])
        ->except(['index', 'show']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

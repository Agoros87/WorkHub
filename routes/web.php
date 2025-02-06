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

Route::get('/terms-of-service', function () {
    return view('terms', [
        'terms' => Illuminate\Support\Str::markdown(file_get_contents(resource_path('markdown/terms.md')))
    ]);
})->name('terms.show');

Route::get('/privacy-policy', function () {
    return view('policy', [
        'policy' => Illuminate\Support\Str::markdown(file_get_contents(resource_path('markdown/policy.md')))
    ]);
})->name('policy.show');

Route::get('/register/worker', function () {
    return view('auth.register-worker');
})->name('register.worker');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::resource('advertisements', AdvertisementController::class)
        ->except(['index', 'show']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('advertisements', AdvertisementController::class)
    ->only(['index', 'show']);

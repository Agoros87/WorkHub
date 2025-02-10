<?php

use App\Http\Controllers\PageHomeController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
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
        'terms' => Illuminate\Support\Str::markdown(file_get_contents(resource_path('markdown/terms.md'))),
    ]);
})->name('terms.show');

Route::get('/privacy-policy', function () {
    return view('policy', [
        'policy' => Illuminate\Support\Str::markdown(file_get_contents(resource_path('markdown/policy.md'))),
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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::resource('advertisements', AdvertisementController::class)
    ->only(['index', 'show']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('/advertisements/{advertisement}/apply', [JobApplicationController::class, 'store'])
        ->name('advertisements.apply');
    Route::get('/job-applications/{jobApplication}', [JobApplicationController::class, 'show'])
        ->name('job-applications.show');
    Route::delete('/job-applications/{jobApplication}', [JobApplicationController::class, 'destroy'])
        ->name('job-applications.destroy');
});

<?php

use App\Http\Controllers\PageWelcomeController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Livewire\SearchAdvertisements;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::get('/', PageWelcomeController::class)->name('welcome');

Route::get('/select-role', function () {
    return view('select-role');
})->name('select-role');
    // Rutas para autenticación y registro

Route::get('/register/employer', function () {
    return view('auth.register-employer');
})->name('register.employer');

Route::get('/register/worker', function () {
    return view('auth.register-worker');
})->name('register.worker');

    // Rutas para términos y política de privacidad

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

Route::get('/search', SearchAdvertisements::class)->name('search');

    // Rutas para anuncios

Route::middleware(['auth', 'verified', RoleMiddleware::using(['creator','admin'])])->group(function () {
    Route::resource('advertisements', AdvertisementController::class)
        ->except(['show']);
});

Route::middleware(['auth', 'verified', RoleMiddleware::using(['creator','admin'])])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/advertisements/{advertisement}', [AdvertisementController::class, 'show'])
    ->name('advertisements.show');

Route::get('/advertisements/{advertisement}/pdf', [AdvertisementController::class, 'downloadPdf'])
    ->name('advertisements.pdf');

    // Rutas para aplicar a un anuncio

Route::middleware(['auth', 'verified', RoleMiddleware::using(['creator','admin'])])->group(function () {
    Route::post('/advertisements/{advertisement}/apply', [JobApplicationController::class, 'store'])
        ->name('advertisements.apply');
    Route::get('/job-applications/{jobApplication}', [JobApplicationController::class, 'show'])
        ->name('job-applications.show');
    Route::delete('/job-applications/{jobApplication}', [JobApplicationController::class, 'destroy'])
        ->name('job-applications.destroy');

    // Rutas para favoritos
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::put('/favorites/{slug}', [FavoriteController::class, 'update'])->name('favorites.update');
    Route::delete('/favorites/{slug}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

// Rutas de administración
Route::middleware(['auth', 'verified', RoleMiddleware::using('admin')])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.admin-dashboard');
    Route::delete('/admin/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');
    Route::delete('/admin/advertisements/{advertisement}', [AdminDashboardController::class, 'deleteAdvertisement'])->name('admin.advertisements.delete');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdvertisementController;

/*
|--------------------------------------------------------------------------
| API Routes - WorkHub API v1
|--------------------------------------------------------------------------
|
| Aquí se registran todas las rutas para la API de WorkHub.
| La API está diseñada para gestionar anuncios de trabajo en hostelería.
|
*/

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
|
| POST /api/login   - Iniciar sesión y obtener token
| POST /api/logout  - Cerrar sesión (requiere autenticación)
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Rutas de Anuncios
|--------------------------------------------------------------------------
|
| Rutas públicas:
| GET /api/advertisements      - Listar todos los anuncios
| GET /api/advertisements/{slug} - Ver un anuncio específico
|
| Rutas protegidas (requieren autenticación):
| POST   /api/advertisements     - Crear nuevo anuncio
| PUT    /api/advertisements/{slug} - Actualizar anuncio
| DELETE /api/advertisements/{slug} - Eliminar anuncio
|
*/

// Rutas públicas de anuncios
Route::get('/advertisements', [AdvertisementController::class, 'index']);
Route::get('/advertisements/{advertisement:slug}', [AdvertisementController::class, 'show']);

// Rutas protegidas de anuncios
Route::apiResource('advertisements', AdvertisementController::class)
    ->parameters(['advertisements' => 'advertisement:slug'])
    ->middleware(['auth:sanctum'])->except(['index', 'show']);

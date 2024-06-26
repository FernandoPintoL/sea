<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\HabitanteController;
use App\Http\Controllers\GaleriaVisitanteController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    /* TIPO DOCUMENTO RUTAS */
    Route::resource('tipodocumento', TipoDocumentoController::class);
    Route::post('/tipodocumento/query',[TipoDocumentoController::class, 'query'])->name('tipodocumento.query');
    /* HABITANTES RUTAS */
    Route::resource('habitante', HabitanteController::class);
    Route::post('/habitante/query',[HabitanteController::class, 'query'])->name('habitante.query');

    Route::post('/galeriavisitante/uploadimage', [GaleriaVisitanteController::class,'uploadimage'])->name('galeriavisitante.uploadimage');

});
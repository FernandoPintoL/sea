<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\HabitanteController;
use App\Http\Controllers\PerfilController;

Route::get('/appuser', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::apiResource('/users', UserController::class);
Route::post('/appusers/consultar', [UserController::class,'consultar'])->name('appusers.consultar');
Route::post('/appusers/registerOnApi', [UserController::class,'registerOnApi'])->name('appusers.registerOnApi');
Route::post('/appusers/loginOnApi', [UserController::class,'loginOnApi'])->name('appusers.loginOnApi');
Route::post('/appusers/logout', [UserController::class,'logout'])->name('appusers.logout');

/* TIPO PERFIL RUTAS */
Route::resource('appperfil', PerfilController::class);
Route::post('/appperfil/query',[PerfilController::class, 'query'])->name('appperfil.query');
/* TIPO DOCUMENTO RUTAS */
Route::resource('apptipodocumento', TipoDocumentoController::class);
Route::post('/apptipodocumento/query',[TipoDocumentoController::class, 'query'])->name('apptipodocumento.query');
/* HABITANTES RUTAS */
Route::resource('apphabitante', HabitanteController::class);
Route::post('/apphabitante/query',[HabitanteController::class, 'query'])->name('apphabitante.query');
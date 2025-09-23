<?php

use App\Http\Controllers\AreaEsportivaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Usuarios
Route::get('/usuarios', [UsuarioController::class, 'index']);

Route::post('/usuarios', [UsuarioController::class, 'store']);

Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);

Route::patch('/usuarios/edit/{id}', [UsuarioController::class, 'update']);

Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::post('/login', [UsuarioController::class, 'login']);


// Areas esportivas
Route::get('/areas', [AreaEsportivaController::class, 'index']);

Route::get('/areas/{id}', [AreaEsportivaController::class, 'show']);

Route::middleware(['auth:sanctum', 'admin'])->group(function (){
    Route::post('/areas', [AreaEsportivaController::class, 'store']);
    
    Route::patch('/areas/edit/{id}',
    [AreaEsportivaController::class, 'update']);
});
<?php

use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/usuarios', [UsuarioController::class, 'index']);

Route::post('/usuarios', [UsuarioController::class, 'store']);

Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);

Route::patch('/usuarios/edit/{id}', [UsuarioController::class, 'update']);

Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

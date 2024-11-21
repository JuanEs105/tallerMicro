<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudiantesController;

Route::prefix('estudiantes')->group(function() {
    Route::post('/', [EstudiantesController::class, 'store']); // Crear un estudiante
    Route::get('/', [EstudiantesController::class, 'index']); // Obtener lista de estudiantes
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

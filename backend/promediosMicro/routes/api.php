<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\NotasController;

Route::prefix('estudiantes')->group(function() {
    Route::post('/', [EstudiantesController::class, 'store']); // Crear un estudiante
    Route::get('/', [EstudiantesController::class, 'index']); // Obtener lista de estudiantes
});

// Rutas para las notas
Route::prefix('notas')->group(function () {
    Route::post('/', [NotasController::class, 'store']); // Agregar una nueva nota
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

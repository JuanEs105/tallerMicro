<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\NotasController;

// Rutas para estudiantes
Route::prefix('estudiantes')->group(function() {
    Route::post('/', [EstudiantesController::class, 'store']); // Crear un estudiante
    Route::get('/', [EstudiantesController::class, 'index']); // Listar estudiantes
    Route::get('/{id}', [EstudiantesController::class, 'show']); // Obtener estudiante por ID
    Route::put('/{id}', [EstudiantesController::class, 'update']); // Actualizar estudiante
    Route::delete('/{id}', [EstudiantesController::class, 'destroy']); // Eliminar estudiante
});

// Rutas para las notas
Route::prefix('notas')->group(function () {
    Route::post('/', [NotasController::class, 'store']); // Agregar nueva nota
});



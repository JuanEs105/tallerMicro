<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use App\Models\Estudiantes;
use Illuminate\Http\Request;

class NotasController extends Controller
{
    // Método para agregar una nueva nota
    public function store(Request $request)
    {
        $validated = $request->validate([
            'actividad' => 'required|string|max:100',
            'nota' => 'required|numeric|min:0|max:5', // Validación de rango 0-5
            'codEstudiante' => 'required|exists:estudiantes,cod', // Verifica que el estudiante exista
        ]);

        $nota = Notas::create($validated);

        return response()->json([
            'message' => 'Nota agregada exitosamente',
            'nota' => $nota,
        ], 201);
    }
}

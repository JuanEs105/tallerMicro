<?php

namespace App\Http\Controllers;

use App\Models\Estudiantes;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    // Método para listar estudiantes con sus notas definitivas y estado
    public function index()
    {
        $estudiantes = Estudiantes::with('notas')->get();

        $data = $estudiantes->map(function ($estudiante) {
            $promedio = $estudiante->notas->avg('nota') ?? 0; // Calcula el promedio o 0 si no hay notas
            $estado = $promedio >= 3 ? 'Aprobado' : 'Reprobado'; // Determina el estado

            return [
                'cod' => $estudiante->cod,
                'nombres' => $estudiante->nombres,
                'email' => $estudiante->email,
                'nota_definitiva' => $promedio,
                'estado' => $estado,
            ];
        });

        return response()->json($data, 200);
    }

    // Método para almacenar un estudiante
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cod' => 'required|unique:estudiantes,cod',
            'nombres' => 'required|string|max:250',
            'email' => 'required|email|max:250',
        ]);

        $estudiante = Estudiantes::create($validated);

        return response()->json($estudiante, 201);
    }
}

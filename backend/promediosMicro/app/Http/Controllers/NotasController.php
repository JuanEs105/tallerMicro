<?php
namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;

class NotasController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los parámetros de búsqueda desde la query string
        $actividad = $request->query('actividad'); // Filtro por actividad
        $min_nota = $request->query('min_nota');   // Filtro por nota mínima
        $max_nota = $request->query('max_nota');   // Filtro por nota máxima

        // Iniciar la consulta
        $notasQuery = Notas::query();

        // Filtrar por actividad si se pasa el parámetro 'actividad'
        if ($actividad) {
            $notasQuery->where('actividad', 'LIKE', '%' . $actividad . '%');
        }

        // Filtrar por rango de notas si se pasan los parámetros 'min_nota' y 'max_nota'
        if ($min_nota !== null) {
            $notasQuery->where('nota', '>=', $min_nota);
        }

        if ($max_nota !== null) {
            $notasQuery->where('nota', '<=', $max_nota);
        }

        // Obtener las notas filtradas
        $notas = $notasQuery->get();

        // Categorizar las notas según el rango de calificación
        $notasCategorized = $notas->map(function ($nota) {
            if ($nota->nota >= 0 && $nota->nota <= 2) {
                $categoria = 'Muy baja';
                $color = 'red'; // Rojo para notas entre 0 y 2
            } elseif ($nota->nota > 2 && $nota->nota < 3) {
                $categoria = 'Baja';
                $color = 'orange'; // Naranja para notas entre 2 y 3
            } elseif ($nota->nota >= 3 && $nota->nota < 4) {
                $categoria = 'Buena';
                $color = 'yellow'; // Amarillo para notas entre 3 y 4
            } else {
                $categoria = 'Excelente';
                $color = 'green'; // Verde para notas mayores o iguales a 4
            }

            return [
                'actividad' => $nota->actividad,
                'nota' => $nota->nota,
                'categoria' => $categoria,
                'color' => $color, // Colores o etiquetas de categoría
            ];
        });

        return response()->json($notasCategorized, 200);
    }

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

    // Método para modificar una nota existente
    public function update(Request $request, $id)
    {
        // Validar la entrada del usuario
        $validated = $request->validate([
            'actividad' => 'required|string|max:100',
            'nota' => 'required|numeric|min:0|max:5', // Validación de rango 0-5
        ]);

        // Buscar la nota por ID
        $nota = Notas::find($id);

        if (!$nota) {
            return response()->json([
                'message' => 'Nota no encontrada'
            ], 404);
        }

        // Actualizar los datos de la nota
        $nota->actividad = $validated['actividad'];
        $nota->nota = $validated['nota'];
        $nota->save();

        return response()->json([
            'message' => 'Nota actualizada exitosamente',
            'nota' => $nota,
        ], 200);
    }
}

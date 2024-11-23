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


    public function show(string $id)
    {
        $estudiante = Estudiantes::find($id);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        return response()->json($estudiante, 200);
    }


    public function update(Request $request, string $id)
    {
        $dataBody = $request->all();
        $estudiante = Estudiantes::find($id);

        if (empty($estudiante)) {
            return response()->json(["msg" => "Estudiante no encontrado"], 404);
        }

        // No permitas cambiar el 'cod' del estudiante si tiene notas asociadas
        if ($estudiante->notas()->exists() && $estudiante->cod !== $dataBody['cod']) {
            return response()->json(["msg" => "El código del estudiante no puede ser cambiado porque ya tiene notas asociadas."], 400);
        }

        // Actualiza los demás datos, pero no el 'cod'
        $estudiante->nombres = $dataBody['nombres'];
        $estudiante->email = $dataBody['email'];
        $estudiante->save();

        return response()->json(["data" => $estudiante], 200);
    }


    public function destroy(Request $request, $id)
{
    // Buscar al estudiante por su ID
    $estudiante = Estudiantes::find($id);

    // Verificar si el estudiante existe
    if (!$estudiante) {
        return response()->json(['error' => 'Estudiante no encontrado.'], 404);
    }

    // Eliminar las notas asociadas al estudiante
    $estudiante->notas()->delete(); // Elimina todas las notas asociadas al estudiante

    // Confirmación opcional
    $confirmacion = $request->query('confirmar');

    // Si no se ha confirmado, se envía un mensaje de confirmación
    if ($confirmacion !== 'true') {
        return response()->json([
            'mensaje' => '¿Está seguro que desea eliminar este estudiante?',
            'confirmar' => true
        ], 200);
    }

    // Eliminar el estudiante
    $estudiante->delete();

    return response()->json(['mensaje' => 'Estudiante eliminado exitosamente.'], 200);
}


}

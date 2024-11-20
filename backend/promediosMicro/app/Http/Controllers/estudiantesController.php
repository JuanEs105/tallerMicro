<?php

namespace app\Http\Controllers;

use App\Models\Estudiantes;
use Illuminate\Auth\Events\Validated;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Http\Request;

class estudiantesController extends Controller 
{
    public function store(Request $request)
    {
        $Validated = $request->validate([
            'cod' => 'required|exists:notas,codEstudiante',
            'nombres' =>'required|string|max:150',
            'email' => 'required|string|max:50'
        ]);


        $estudiate = Estudiantes::create($Validated);

        return response()->json($estudiate, 201);
    }
}
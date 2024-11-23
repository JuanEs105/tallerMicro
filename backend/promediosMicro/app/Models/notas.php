<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notas extends Model
{
    protected $table = 'notas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = false; // Sin marcas de tiempo automáticas

    protected $fillable = [
        'actividad',
        'nota',
        'codEstudiante',
    ];

    // Relación inversa con la tabla `estudiantes`
    public function estudiante()
    {
        return $this->belongsTo(Estudiantes::class, 'codEstudiante', 'cod');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiantes extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'cod';
    public $incrementing = false;
    protected $keyType = 'integer';
    public $timestamps = false; // Sin marcas de tiempo automáticas

    protected $fillable = [
        'cod',
        'nombres',
        'email',
    ];

    // Relación con la tabla `notas`
    public function notas()
    {
        return $this->hasMany(Notas::class, 'codEstudiante', 'cod');
    }
}

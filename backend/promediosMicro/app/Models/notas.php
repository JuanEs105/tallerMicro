<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notas extends Model
{
    protected $table = 'notas';

    protected $fillable = [
        'id',
        'actividad',
        'nota',
        'codEstudiante'
];
}
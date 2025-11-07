<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actividad extends Model
{
    use HasFactory;

    // ESPECIFICAR EXPLÍCITAMENTE EL NOMBRE DE LA TABLA
    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'dia_semana',
        'hora_inicio',
        'hora_finalizacion'
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_finalizacion' => 'datetime:H:i',
    ];

    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'inscripciones')
                    ->withTimestamps();
    }
}
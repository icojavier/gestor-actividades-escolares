<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    use HasFactory;

    // ESPECIFICAR EXPLÍCITAMENTE EL NOMBRE DE LA TABLA
    protected $table = 'alumnos';

    protected $fillable = [
        'nombre_completo',
        'curso_academico',
        'edad'
    ];

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'inscripciones');
    }

    // Para withCount
    public function actividades_count()
    {
        return $this->belongsToMany(Actividad::class, 'inscripciones')->count();
    }

    // AGREGAR ESTA RELACIÓN FALTANTE
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }
}

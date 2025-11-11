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
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime',
    ];

    // Relación con inscripciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function alumnos()
{
    return $this->belongsToMany(Alumno::class, 'inscripciones');
}

    // Para withCount
    public function alumnos_count()
    {
        return $this->belongsToMany(Alumno::class, 'inscripciones')->count();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

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
        'hora_finalizacion' => 'datetime',
    ];

    // Accessors para formatear horas
    public function getHoraInicioFormateadaAttribute()
    {
        return $this->hora_inicio ? $this->hora_inicio->format('H:i') : null;
    }

    public function getHoraFinalizacionFormateadaAttribute()
    {
        return $this->hora_finalizacion ? $this->hora_finalizacion->format('H:i') : null;
    }

    // Relación con inscripciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    // Relación con alumnos
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'inscripciones');
    }
}